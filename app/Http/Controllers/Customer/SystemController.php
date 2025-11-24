<?php

namespace App\Http\Controllers\Customer;

use App\Models\User;
use App\Utils\Helpers;
use App\Http\Controllers\Controller;
use App\Models\ShippingAddress;
use App\Models\ShippingMethod;
use App\Models\CartShipping;
use App\Traits\CommonTrait;
use App\Utils\CartManager;
use App\Utils\OrderManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SystemController extends Controller
{
    use CommonTrait;

    public function setPaymentMethod($name): JsonResponse
    {
        if (auth('customer')->check() || session()->has('mobile_app_payment_customer_id')) {
            session()->put('payment_method', $name);
            return response()->json(['status' => 1]);
        }
        return response()->json(['status' => 0]);
    }

    public function setShippingMethod(Request $request): JsonResponse
    {
        if ($request['cart_group_id'] == 'all_cart_group') {
            foreach (CartManager::get_cart_group_ids() as $groupId) {
                $request['cart_group_id'] = $groupId;
                self::insertIntoCartShipping($request);
            }
        } else {
            self::insertIntoCartShipping($request);
        }
        return response()->json(['status' => 1]);
    }

    public static function insertIntoCartShipping($request): void
    {
        $shipping = CartShipping::where(['cart_group_id' => $request['cart_group_id']])->first();
        if (isset($shipping) == false) {
            $shipping = new CartShipping();
        }
        $shipping['cart_group_id'] = $request['cart_group_id'];
        $shipping['shipping_method_id'] = $request['id'];
        $shipping['shipping_cost'] = ShippingMethod::find($request['id'])->cost;
        $shipping->save();

        if (session('coupon_code') && session('coupon_discount')) {
            $result = OrderManager::getTotalCouponAmount(request: $request, couponCode: session('coupon_code'));
            if (!$result['status']) {
                session()->forget('coupon_code');
                session()->forget('coupon_type');
                session()->forget('coupon_bearer');
                session()->forget('coupon_discount');
                session()->forget('coupon_seller_id');
            }
        }
    }

    /*
     * default theme
     * @return json
     */
    public function getChooseShippingAddress(Request $request): JsonResponse
    {
        $zip_restrict_status = getWebConfig(name: 'delivery_zip_code_area_restriction');
        $country_restrict_status = getWebConfig(name: 'delivery_country_restriction');

        $physical_product = $request['physical_product'];
        $shipping = [];
        $billing = [];

        parse_str($request['shipping'], $shipping);
        parse_str($request['billing'], $billing);
        $is_guest = !auth('customer')->check();

        if (isset($shipping['save_address']) && $shipping['save_address'] == 'on') {

            // Simplified checkout validation - only require name, phone, email (for guests), city, and address
            if ($shipping['contact_person_name'] == null || $shipping['city'] == null || $shipping['address'] == null || ($is_guest && (!isset($shipping['email']) || $shipping['email'] == null))) {
                return response()->json([
                    'errors' => translate('Fill_all_required_fields_of_shipping_address')
                ], 403);
            }

            // Set default values for required database fields if not provided
            $defaultLocation = getWebConfig(name: 'default_location');
            $defaultCountry = 'Bangladesh';
            if ($defaultLocation) {
                // Check if $defaultLocation is already an array or a JSON string
                if (is_array($defaultLocation)) {
                    $locationData = $defaultLocation;
                } else {
                    $locationData = json_decode($defaultLocation, true);
                }
                if (is_array($locationData) && isset($locationData['country'])) {
                    $defaultCountry = $locationData['country'];
                }
            }

            $shipping['address_type'] = $shipping['address_type'] ?? 'home';
            // City is now required, so don't set default
            if (empty($shipping['city'])) {
                return response()->json([
                    'errors' => translate('City_is_required')
                ], 403);
            }
            $shipping['zip'] = $shipping['zip'] ?? '0000';
            $shipping['country'] = $shipping['country'] ?? $defaultCountry;
            $shipping['latitude'] = $shipping['latitude'] ?? '0';
            $shipping['longitude'] = $shipping['longitude'] ?? '0';

            // Only validate country/zip restrictions if they are actually set (not defaults)
            if ($shipping['country'] != 'N/A' && $shipping['country'] != '0000' && $shipping['country'] != $defaultCountry) {
                if ($country_restrict_status && !self::delivery_country_exist_check($shipping['country'])) {
                    return response()->json([
                        'errors' => translate('Delivery_unavailable_in_this_country.')
                    ], 403);
                }
            }

            if ($shipping['zip'] != '0000' && $shipping['zip'] != 'N/A') {
                if ($zip_restrict_status && !self::delivery_zipcode_exist_check($shipping['zip'])) {
                    return response()->json([
                        'errors' => translate('Delivery_unavailable_in_this_zip_code_area')
                    ], 403);
                }
            }

            $address_id = DB::table('shipping_addresses')->insertGetId([
                'customer_id' => auth('customer')->id() ?? ((session()->has('guest_id') ? session('guest_id') : 0)),
                'is_guest' => auth('customer')->check() ? 0 : (session()->has('guest_id') ? 1 : 0),
                'contact_person_name' => $shipping['contact_person_name'],
                'address_type' => $shipping['address_type'],
                'address' => $shipping['address'],
                'city' => $shipping['city'],
                'zip' => $shipping['zip'],
                'country' => $shipping['country'],
                'phone' => $shipping['phone'],
                'email' => auth('customer')->check() ? null : ($shipping['email'] ?? null),
                'latitude' => $shipping['latitude'],
                'longitude' => $shipping['longitude'],
                'is_billing' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } else if (isset($shipping['shipping_method_id']) && ($shipping['shipping_method_id'] == 0 || !isset($shipping['update_address']))) {

            // Simplified checkout validation - only require name, phone, email (for guests), city, and address
            if ($shipping['contact_person_name'] == null || $shipping['city'] == null || $shipping['address'] == null || ($is_guest && (!isset($shipping['email']) || $shipping['email'] == null))) {
                return response()->json([
                    'errors' => translate('Fill_all_required_fields_of_shipping/billing_address')
                ], 403);
            }

            // Set default values for required database fields if not provided
            $defaultLocation = getWebConfig(name: 'default_location');
            $defaultCountry = 'Bangladesh';
            if ($defaultLocation) {
                // Check if $defaultLocation is already an array or a JSON string
                if (is_array($defaultLocation)) {
                    $locationData = $defaultLocation;
                } else {
                    $locationData = json_decode($defaultLocation, true);
                }
                if (is_array($locationData) && isset($locationData['country'])) {
                    $defaultCountry = $locationData['country'];
                }
            }

            $shipping['address_type'] = $shipping['address_type'] ?? 'home';
            // City is now required, so don't set default
            if (empty($shipping['city'])) {
                return response()->json([
                    'errors' => translate('City_is_required')
                ], 403);
            }
            $shipping['zip'] = $shipping['zip'] ?? '0000';
            $shipping['country'] = $shipping['country'] ?? $defaultCountry;
            $shipping['latitude'] = $shipping['latitude'] ?? '0';
            $shipping['longitude'] = $shipping['longitude'] ?? '0';

            // Only validate country/zip restrictions if they are actually set (not defaults)
            if ($shipping['country'] != 'N/A' && $shipping['country'] != '0000' && $shipping['country'] != $defaultCountry) {
                if ($country_restrict_status && !self::delivery_country_exist_check($shipping['country'])) {
                    return response()->json([
                        'errors' => translate('Delivery_unavailable_in_this_country')
                    ], 403);
                }
            }

            if ($shipping['zip'] != '0000' && $shipping['zip'] != 'N/A') {
                if ($zip_restrict_status && !self::delivery_zipcode_exist_check($shipping['zip'])) {
                    return response()->json([
                        'errors' => translate('Delivery_unavailable_in_this_zip_code_area')
                    ], 403);
                }
            }

            $address_id = DB::table('shipping_addresses')->insertGetId([
                'customer_id' => auth('customer')->id() ?? ((session()->has('guest_id') ? session('guest_id') : 0)),
                'is_guest' => auth('customer')->check() ? 0 : (session()->has('guest_id') ? 1 : 0),
                'contact_person_name' => $shipping['contact_person_name'],
                'address_type' => $shipping['address_type'],
                'address' => $shipping['address'],
                'city' => $shipping['city'],
                'zip' => $shipping['zip'],
                'country' => $shipping['country'],
                'phone' => $shipping['phone'],
                'email' => auth('customer')->check() ? null : ($shipping['email'] ?? null),
                'latitude' => $shipping['latitude'],
                'longitude' => $shipping['longitude'],
                'is_billing' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } else {
            // Check if we're trying to use an existing address (not simplified checkout)
            // In simplified checkout, shipping_method_id refers to the shipping method, not an address ID
            // So we check if update_address is set to determine if we're using an existing address
            if (isset($shipping['update_address']) && isset($shipping['shipping_method_id']) && $shipping['shipping_method_id'] > 0) {
                // This is using an existing address (not simplified checkout)
                $address = ShippingAddress::find($shipping['shipping_method_id']);
                if (!$address) {
                    return response()->json([
                        'errors' => translate('Shipping_address_not_found')
                    ], 403);
                }
                if (!$address->country || !$address->zip) {
                    return response()->json([
                        'errors' => translate('Please_update_country_and_zip_for_this_shipping_address')
                    ], 403);
                } elseif ($country_restrict_status && !self::delivery_country_exist_check($address->country)) {
                    return response()->json([
                        'errors' => translate('Delivery_unavailable_in_this_country')
                    ], 403);
                } elseif ($zip_restrict_status && !self::delivery_zipcode_exist_check($address->zip)) {
                    return response()->json([
                        'errors' => translate('Delivery_unavailable_in_this_zip_code_area')
                    ], 403);
                }
                $address_id = $shipping['shipping_method_id'];
            } else {
                // Simplified checkout - create new address even if shipping_method_id is set (it's the shipping method, not address ID)
                // Simplified checkout validation - only require name, phone, email (for guests), city, and address
                if ($shipping['contact_person_name'] == null || $shipping['city'] == null || $shipping['address'] == null || ($is_guest && (!isset($shipping['email']) || $shipping['email'] == null))) {
                    return response()->json([
                        'errors' => translate('Fill_all_required_fields_of_shipping/billing_address')
                    ], 403);
                }

                // Set default values for required database fields if not provided
                $defaultLocation = getWebConfig(name: 'default_location');
                $defaultCountry = 'Bangladesh';
                if ($defaultLocation) {
                    // Check if $defaultLocation is already an array or a JSON string
                    if (is_array($defaultLocation)) {
                        $locationData = $defaultLocation;
                    } else {
                        $locationData = json_decode($defaultLocation, true);
                    }
                    if (is_array($locationData) && isset($locationData['country'])) {
                        $defaultCountry = $locationData['country'];
                    }
                }

                $shipping['address_type'] = $shipping['address_type'] ?? 'home';
                // City is now required, so don't set default
                if (empty($shipping['city'])) {
                    return response()->json([
                        'errors' => translate('City_is_required')
                    ], 403);
                }
                $shipping['zip'] = $shipping['zip'] ?? '0000';
                $shipping['country'] = $shipping['country'] ?? $defaultCountry;
                $shipping['latitude'] = $shipping['latitude'] ?? '0';
                $shipping['longitude'] = $shipping['longitude'] ?? '0';

                // Only validate country/zip restrictions if they are actually set (not defaults)
                if ($shipping['country'] != 'N/A' && $shipping['country'] != '0000' && $shipping['country'] != $defaultCountry) {
                    if ($country_restrict_status && !self::delivery_country_exist_check($shipping['country'])) {
                        return response()->json([
                            'errors' => translate('Delivery_unavailable_in_this_country')
                        ], 403);
                    }
                }

                if ($shipping['zip'] != '0000' && $shipping['zip'] != 'N/A') {
                    if ($zip_restrict_status && !self::delivery_zipcode_exist_check($shipping['zip'])) {
                        return response()->json([
                            'errors' => translate('Delivery_unavailable_in_this_zip_code_area')
                        ], 403);
                    }
                }

                $address_id = DB::table('shipping_addresses')->insertGetId([
                    'customer_id' => auth('customer')->id() ?? ((session()->has('guest_id') ? session('guest_id') : 0)),
                    'is_guest' => auth('customer')->check() ? 0 : (session()->has('guest_id') ? 1 : 0),
                    'contact_person_name' => $shipping['contact_person_name'],
                    'address_type' => $shipping['address_type'],
                    'address' => $shipping['address'],
                    'city' => $shipping['city'],
                    'zip' => $shipping['zip'],
                    'country' => $shipping['country'],
                    'phone' => $shipping['phone'],
                    'email' => auth('customer')->check() ? null : ($shipping['email'] ?? null),
                    'latitude' => $shipping['latitude'],
                    'longitude' => $shipping['longitude'],
                    'is_billing' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        if ($request->billing_addresss_same_shipping == 'false') {
            if (isset($billing['save_address_billing']) && $billing['save_address_billing'] == 'on') {

                if ($billing['billing_contact_person_name'] == null || $billing['billing_address'] == null || $billing['billing_city'] == null || $billing['billing_zip'] == null || $billing['billing_country'] == null || ($is_guest && $billing['billing_contact_email'] == null)) {
                    return response()->json([
                        'errors' => translate('Billing_address_is_currently_disabled') . '. ' . translate('To_purchase_digital_products,_please_include_a_physical_product_in_your_order') . '.',
                    ], 403);
                } elseif ($country_restrict_status && !self::delivery_country_exist_check($billing['billing_country'])) {
                    return response()->json([
                        'errors' => translate('Delivery_unavailable_in_this_country')
                    ], 403);
                } elseif ($zip_restrict_status && !self::delivery_zipcode_exist_check($billing['billing_zip'])) {
                    return response()->json([
                        'errors' => translate('Delivery_unavailable_in_this_zip_code_area')
                    ], 403);
                }

                $billing_address_id = DB::table('shipping_addresses')->insertGetId([
                    'customer_id' => auth('customer')->id() ?? ((session()->has('guest_id') ? session('guest_id') : 0)),
                    'is_guest' => auth('customer')->check() ? 0 : (session()->has('guest_id') ? 1 : 0),
                    'contact_person_name' => $billing['billing_contact_person_name'],
                    'address_type' => $billing['billing_address_type'],
                    'address' => $billing['billing_address'],
                    'city' => $billing['billing_city'],
                    'zip' => $billing['billing_zip'],
                    'country' => $billing['billing_country'],
                    'phone' => $billing['billing_phone'],
                    'email' => auth('customer')->check() ? null : $billing['billing_contact_email'],
                    'latitude' => $billing['billing_latitude'],
                    'longitude' => $billing['billing_longitude'],
                    'is_billing' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } elseif ($billing['billing_method_id'] == 0) {

                if ($billing['billing_contact_person_name'] == null || $billing['billing_address'] == null || $billing['billing_city'] == null || $billing['billing_zip'] == null || $billing['billing_country'] == null || ($is_guest && $billing['billing_contact_email'] == null)) {
                    return response()->json([
                        'errors' => translate('Fill_all_required_fields_of_billing_address')
                    ], 403);
                } elseif ($country_restrict_status && !self::delivery_country_exist_check($billing['billing_country'])) {
                    return response()->json([
                        'errors' => translate('Delivery_unavailable_in_this_country')
                    ], 403);
                } elseif ($zip_restrict_status && !self::delivery_zipcode_exist_check($billing['billing_zip'])) {
                    return response()->json([
                        'errors' => translate('Delivery_unavailable_in_this_zip_code_area')
                    ], 403);
                }

                $billing_address_id = DB::table('shipping_addresses')->insertGetId([
                    'customer_id' => auth('customer')->id() ?? ((session()->has('guest_id') ? session('guest_id') : 0)),
                    'is_guest' => auth('customer')->check() ? 0 : (session()->has('guest_id') ? 1 : 0),
                    'contact_person_name' => $billing['billing_contact_person_name'],
                    'address_type' => $billing['billing_address_type'],
                    'address' => $billing['billing_address'],
                    'city' => $billing['billing_city'],
                    'zip' => $billing['billing_zip'],
                    'country' => $billing['billing_country'],
                    'phone' => $billing['billing_phone'],
                    'email' => auth('customer')->check() ? null : $billing['billing_contact_email'],
                    'latitude' => $billing['billing_latitude'],
                    'longitude' => $billing['billing_longitude'],
                    'is_billing' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } else {
                $address = ShippingAddress::find($billing['billing_method_id']);
                if ($physical_product == 'yes') {
                    if (!$address->country || !$address->zip) {
                        return response()->json([
                            'errors' => translate('Update_country_and_zip_for_this_billing_address')
                        ], 403);
                    } elseif ($country_restrict_status && !self::delivery_country_exist_check($address->country)) {
                        return response()->json([
                            'errors' => translate('Delivery_unavailable_in_this_country')
                        ], 403);
                    } elseif ($zip_restrict_status && !self::delivery_zipcode_exist_check($address->zip)) {
                        return response()->json([
                            'errors' => translate('Delivery_unavailable_in_this_zip_code_area')
                        ], 403);
                    }
                }
                $billing_address_id = $billing['billing_method_id'];
            }
        } else {
            $billing_address_id = $address_id;
        }

        session()->put('address_id', $address_id);
        session()->put('billing_address_id', $billing_address_id);

        return response()->json([], 200);
    }


    public function getChooseShippingAddressOther(Request $request): JsonResponse
    {
        $billingInputByCustomer = getWebConfig(name: 'billing_input_by_customer');
        $productTypes = CartManager::getCartListQuery(type: 'checked')->pluck('product_type')->toArray() ?? ['physical'];
        if (!$billingInputByCustomer && !in_array('physical', $productTypes)) {
            return response()->json([
                'errors' => translate('Billing_address_is_currently_disabled') . '. ' . translate('To_purchase_digital_products,_please_include_a_physical_product_in_your_order') . '.',
            ], 403);
        }

        $shipping = [];
        $billing = [];
        parse_str($request['shipping'], $shipping);
        parse_str($request['billing'], $billing);

        if (isset($shipping['phone'])) {
            $shippingPhoneValue = preg_replace('/[^0-9]/', '', $shipping['phone']);
            $shippingPhoneLength = strlen($shippingPhoneValue);
            if ($shippingPhoneLength < 4) {
                return response()->json([
                    'errors' => translate('The_phone_number_must_be_at_least_4_characters')
                ], 403);
            }
            if ($shippingPhoneLength > 20) {
                return response()->json([
                    'errors' => translate('The_phone_number_may_not_be_greater_than_20_characters')
                ], 403);
            }
        }

        if ($request['billing_addresss_same_shipping'] == 'false' && isset($billing['billing_phone'])) {
            $billingPhoneValue = preg_replace('/[^0-9]/', '', $billing['billing_phone']);
            $billingPhoneLength = strlen($billingPhoneValue);
            if ($billingPhoneLength < 4) {
                return response()->json([
                    'errors' => translate('The_phone_number_must_be_at_least_4_characters')
                ], 403);
            }

            if ($billingPhoneLength > 20) {
                return response()->json([
                    'errors' => translate('The_phone_number_may_not_be_greater_than_20_characters')
                ], 403);
            }
        }

        $physicalProduct = $request['physical_product'];
        $zipRestrictStatus = getWebConfig(name: 'delivery_zip_code_area_restriction');
        $countryRestrictStatus = getWebConfig(name: 'delivery_country_restriction');
        $isGuestCustomer = !auth('customer')->check();

        // Shipping start
        $addressId = $shipping['shipping_method_id'] ?? 0;
        
        // Set default country
        $defaultLocation = getWebConfig(name: 'default_location');
        $defaultCountry = 'Bangladesh';
        if ($defaultLocation) {
            // Check if $defaultLocation is already an array or a JSON string
            if (is_array($defaultLocation)) {
                $locationData = $defaultLocation;
            } else {
                $locationData = json_decode($defaultLocation, true);
            }
            if (is_array($locationData) && isset($locationData['country'])) {
                $defaultCountry = $locationData['country'];
            }
        }
        $shipping['country'] = $shipping['country'] ?? $defaultCountry;
        
        if (isset($shipping['shipping_method_id'])) {
            // Simplified checkout validation - only require name, phone, email (for guests), and address
            if ($shipping['contact_person_name'] == null || $shipping['address'] == null || $shipping['phone'] == null || ($isGuestCustomer && (!isset($shipping['email']) || $shipping['email'] == null))) {
                return response()->json([
                    'errors' => translate('Fill_all_required_fields_of_shipping_address')
                ], 403);
            }

            // Set default values for required database fields if not provided
            $shipping['address_type'] = $shipping['address_type'] ?? 'home';
            // City is now required, so don't set default
            if (empty($shipping['city'])) {
                return response()->json([
                    'errors' => translate('City_is_required')
                ], 403);
            }
            $shipping['zip'] = $shipping['zip'] ?? '0000';
            $shipping['country'] = $shipping['country'] ?? $defaultCountry;

            // Only validate country/zip restrictions if they are actually set (not defaults)
            if ($shipping['country'] != 'N/A' && $shipping['country'] != '0000' && $shipping['country'] != $defaultCountry) {
                if ($countryRestrictStatus && !self::delivery_country_exist_check($shipping['country'])) {
                    return response()->json([
                        'errors' => translate('Delivery_unavailable_in_this_country.')
                    ], 403);
                }
            }

            if ($shipping['zip'] != '0000' && $shipping['zip'] != 'N/A') {
                if ($zipRestrictStatus && !self::delivery_zipcode_exist_check($shipping['zip'])) {
                    return response()->json([
                        'errors' => translate('Delivery_unavailable_in_this_zip_code_area')
                    ], 403);
                }
            }
        }

        if (isset($shipping['save_address']) && $shipping['save_address'] == 'on') {
            // Ensure default values are set
            $shipping['address_type'] = $shipping['address_type'] ?? 'home';
            $shipping['city'] = $shipping['city'] ?? 'N/A';
            $shipping['zip'] = $shipping['zip'] ?? '0000';
            $shipping['country'] = $shipping['country'] ?? $defaultCountry;
            
            $addressId = ShippingAddress::insertGetId([
                'customer_id' => auth('customer')->id() ?? ((session()->has('guest_id') ? session('guest_id') : 0)),
                'is_guest' => auth('customer')->check() ? 0 : (session()->has('guest_id') ? 1 : 0),
                'contact_person_name' => $shipping['contact_person_name'],
                'address_type' => $shipping['address_type'],
                'address' => $shipping['address'],
                'city' => $shipping['city'],
                'zip' => $shipping['zip'],
                'country' => $shipping['country'],
                'phone' => $shipping['phone'],
                'latitude' => $shipping['latitude'] ?? "0",
                'longitude' => $shipping['longitude'] ?? "0",
                'email' => auth('customer')->check() ? null : ($shipping['email'] ?? null),
                'is_billing' => 0,
            ]);
        } elseif (isset($shipping['update_address']) && $shipping['update_address'] == 'on') {
            $getShipping = ShippingAddress::find($addressId);
            $getShipping->contact_person_name = $shipping['contact_person_name'];
            $getShipping->address_type = $shipping['address_type'];
            $getShipping->address = $shipping['address'];
            $getShipping->city = $shipping['city'];
            $getShipping->zip = $shipping['zip'];
            $getShipping->country = $shipping['country'];
            $getShipping->phone = $shipping['phone'];
            $getShipping->latitude = $shipping['latitude'] ?? "";
            $getShipping->longitude = $shipping['longitude'] ?? "";
            $getShipping->save();
        } elseif (isset($shipping['shipping_method_id']) && !isset($shipping['update_address']) && !isset($shipping['save_address'])) {
            // Ensure default values are set
            $shipping['address_type'] = $shipping['address_type'] ?? 'home';
            $shipping['city'] = $shipping['city'] ?? 'N/A';
            $shipping['zip'] = $shipping['zip'] ?? '0000';
            $shipping['country'] = $shipping['country'] ?? $defaultCountry;
            
            $addressId = ShippingAddress::insertGetId([
                'customer_id' => auth('customer')->check() ? 0 : ((session()->has('guest_id') ? session('guest_id') : 0)),
                'is_guest' => auth('customer')->check() ? 0 : (session()->has('guest_id') ? 1 : 0),
                'contact_person_name' => $shipping['contact_person_name'],
                'address_type' => $shipping['address_type'],
                'address' => $shipping['address'],
                'city' => $shipping['city'],
                'zip' => $shipping['zip'],
                'country' => $shipping['country'],
                'phone' => $shipping['phone'],
                'email' => auth('customer')->check() ? null : ($shipping['email'] ?? null),
                'latitude' => $shipping['latitude'] ?? '0',
                'longitude' => $shipping['longitude'] ?? '0',
                'is_billing' => 0,
            ]);
        }
        // Shipping End
        // Billing Start
        $billingAddressId = $addressId ?? 0;
        if ($request['billing_addresss_same_shipping'] == 'false' && isset($billing['billing_method_id']) && $billingInputByCustomer) {
            $billingAddressId = $billing['billing_method_id'];
            if ($billing['billing_contact_person_name'] == null || !isset($billing['billing_address_type']) || !isset($billing['billing_address']) || $billing['billing_address'] == null || $billing['billing_city'] == null || !isset($billing['billing_zip']) || $billing['billing_zip'] == null || !isset($billing['billing_country']) || $billing['billing_country'] == null || $billing['billing_phone'] == null || ($isGuestCustomer && $billing['billing_contact_email'] == null)) {
                return response()->json([
                    'errors' => translate('Fill_all_required_fields_of_billing_address')
                ], 403);
            } elseif ($countryRestrictStatus && !self::delivery_country_exist_check($billing['billing_country'])) {
                return response()->json([
                    'errors' => translate('Delivery_unavailable_in_this_country')
                ], 403);
            } elseif ($zipRestrictStatus && !self::delivery_zipcode_exist_check($billing['billing_zip'])) {
                return response()->json([
                    'errors' => translate('Delivery_unavailable_in_this_zip_code_area')
                ], 403);
            }

            if (isset($billing['save_address_billing']) && $billing['save_address_billing'] == 'on') {
                $billingAddressId = ShippingAddress::insertGetId([
                    'customer_id' => auth('customer')->id() ?? ((session()->has('guest_id') ? session('guest_id') : 0)),
                    'is_guest' => auth('customer')->check() ? 0 : (session()->has('guest_id') ? 1 : 0),
                    'contact_person_name' => $billing['billing_contact_person_name'],
                    'address_type' => $billing['billing_address_type'],
                    'address' => $billing['billing_address'],
                    'city' => $billing['billing_city'],
                    'zip' => $billing['billing_zip'],
                    'country' => $billing['billing_country'],
                    'phone' => $billing['billing_phone'],
                    'email' => auth('customer')->check() ? null : $billing['billing_contact_email'],
                    'latitude' => $billing['billing_latitude'] ?? '',
                    'longitude' => $billing['billing_longitude'] ?? '',
                    'is_billing' => 1,
                ]);
            } elseif (isset($billing['update_billing_address']) && $billing['update_billing_address'] == 'on') {
                $getBilling = ShippingAddress::find($billingAddressId);
                $getBilling->contact_person_name = $billing['billing_contact_person_name'];
                $getBilling->address_type = $billing['billing_address_type'];
                $getBilling->address = $billing['billing_address'];
                $getBilling->city = $billing['billing_city'];
                $getBilling->zip = $billing['billing_zip'];
                $getBilling->country = $billing['billing_country'];
                $getBilling->phone = $billing['billing_phone'];
                $getBilling->latitude = $billing['billing_latitude'] ?? '';
                $getBilling->longitude = $billing['billing_longitude'] ?? '';
                $getBilling->save();
            } elseif (!isset($billing['update_billing_address']) && !isset($billing['save_address_billing'])) {
                $billingAddressId = ShippingAddress::insertGetId([
                    'customer_id' => auth('customer')->check() ? 0 : ((session()->has('guest_id') ? session('guest_id') : 0)),
                    'is_guest' => auth('customer')->check() ? 0 : (session()->has('guest_id') ? 1 : 0),
                    'contact_person_name' => $billing['billing_contact_person_name'],
                    'address_type' => $billing['billing_address_type'],
                    'address' => $billing['billing_address'],
                    'city' => $billing['billing_city'],
                    'zip' => $billing['billing_zip'],
                    'country' => $billing['billing_country'],
                    'phone' => $billing['billing_phone'],
                    'email' => auth('customer')->check() ? null : $billing['billing_contact_email'],
                    'latitude' => $billing['billing_latitude'] ?? '',
                    'longitude' => $billing['billing_longitude'] ?? '',
                    'is_billing' => 1,
                ]);
            }
        } elseif ($request['billing_addresss_same_shipping'] == 'false' && !isset($billing['billing_method_id']) && $physicalProduct != 'yes') {
            return response()->json([
                'errors' => translate('Fill_all_required_fields_of_billing_address')
            ], 403);
        }

        session()->put('address_id', $addressId);
        session()->put('billing_address_id', $billingAddressId);

        if ($request['is_check_create_account'] && $isGuestCustomer) {
            if (empty($request['customer_password']) || empty($request['customer_confirm_password'])) {
                return response()->json([
                    'errors' => translate('The_password_or_confirm_password_can_not_be_empty')
                ], 403);
            }
            if ($request['customer_password'] != $request['customer_confirm_password']) {
                return response()->json([
                    'errors' => translate('The_password_and_confirm_password_must_match')
                ], 403);
            }
            if (strlen($request['customer_password']) < 7 || strlen($request['customer_confirm_password']) < 7) {
                return response()->json([
                    'errors' => translate('The_password_must_be_at_least_8_characters')
                ], 403);
            }
            if ($request['shipping']) {
                $newCustomerAddress = [
                    'name' => $shipping['contact_person_name'],
                    'email' => $shipping['email'],
                    'phone' => $shipping['phone'],
                    'password' => $request['customer_password'],
                ];
            } else {
                $newCustomerAddress = [
                    'name' => $billing['billing_contact_person_name'],
                    'email' => $billing['billing_contact_email'],
                    'phone' => $billing['billing_phone'],
                    'password' => $request['customer_password'],
                ];
            }

            if (User::where(['email' => $newCustomerAddress['email']])->orWhere(['phone' => $newCustomerAddress['phone']])->first()) {
                return response()->json(['errors' => translate('Already_registered')], 403);
            } else {
                $newCustomerRegister = self::getRegisterNewCustomer(request: $request, address: $newCustomerAddress);
                session()->put('newCustomerRegister', $newCustomerRegister);
            }
        } else {
            session()->forget('newCustomerRegister');
            session()->forget('newRegisterCustomerInfo');
        }

        if (!session('address_id') && !session('billing_address_id')) {
            return response()->json([
                'errors' => translate('Please_update_address_information')
            ], 403);
        }

        return response()->json([], 200);
    }

    function getRegisterNewCustomer($request, $address): array
    {
        return [
            'name' => $address['name'],
            'f_name' => $address['name'],
            'l_name' => '',
            'email' => $address['email'],
            'phone' => $address['phone'],
            'is_active' => 1,
            'password' => $address['password'],
            'referral_code' => Helpers::generate_referer_code(),
            'shipping_id' => session('address_id'),
            'billing_id' => session('billing_address_id'),
        ];
    }
}
