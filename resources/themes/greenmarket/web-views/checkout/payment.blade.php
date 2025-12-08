@extends('web-views.layouts.app')

@section('title', translate('choose_Payment_Method') . ' | ' . $web_config['company_name'])

@push('css_or_js')
  <script src="https://polyfill.io/v3/polyfill.min.js?version=3.52.1&features=fetch"></script>
  <script src="https://js.stripe.com/v3/"></script>

  <style>
    /* Custom Utilities */
    .container-custom {
      max-width: 1240px;
      margin-left: auto;
      margin-right: auto;
      padding-left: var(--spacing-container);
      padding-right: var(--spacing-container);
    }

    .hero-gradient {
      background: linear-gradient(135deg, #1b3a2c 0%, #2d5f3f 100%);
    }

    .text-shadow-sm {
      text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
    }

    /* Smooth Scrolling */
    html {
      scroll-behavior: smooth;
    }

    /* Container */
    .container-ds {
      max-width: 1240px;
      margin-left: auto;
      margin-right: auto;
      padding-left: 2rem;
      padding-right: 2rem;
    }

    /* Product Card Styles */
    .product-card {
      background: var(--color-neutral-white);
      border: 1px solid var(--color-neutral-light-gray);
      border-radius: 8px;
      padding: 1rem;
      transition: all 0.3s ease;
      aspect-ratio: 3/4;
      display: flex;
      flex-direction: column;
    }

    .product-card:hover {
      transform: translateY(-4px);
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.12);
      border-color: var(--color-primary-light-green);
    }

    .product-image-container {
      aspect-ratio: 1/1;
      margin-bottom: 0.75rem;
      border-radius: 4px;
      overflow: hidden;
      background: var(--color-neutral-off-white);
      position: relative;
    }

    .product-badge {
      position: absolute;
      top: 0.5rem;
      right: 0.5rem;
      padding: 0.25rem 0.5rem;
      border-radius: 4px;
      font-size: 0.75rem;
      font-weight: 600;
      z-index: 10;
    }

    .badge-new {
      background: var(--color-primary-light-green);
      color: var(--color-neutral-white);
    }

    .badge-sale {
      background: #dc3545;
      color: var(--color-neutral-white);
    }

    .badge-hot {
      background: var(--color-secondary-amber);
      color: var(--color-neutral-white);
    }

    /* Sticky Header */
    header {
      position: sticky;
      top: 0;
      z-index: 1000;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    /* Custom Slick Carousel Dots */
    .slick-dots {
      bottom: -50px;
    }

    .slick-dots li button:before {
      color: var(--color-primary-green);
      font-size: 12px;
    }

    .slick-dots li.slick-active button:before {
      color: var(--color-primary-light-green);
    }

    /* Product Action Buttons */
    .product-actions {
      position: absolute;
      top: 0.5rem;
      left: 0.5rem;
      display: flex;
      flex-direction: column;
      gap: 0.5rem;
      opacity: 0;
      transition: opacity 0.3s ease;
    }

    .product-card:hover .product-actions {
      opacity: 1;
    }

    .action-btn {
      width: 2.5rem;
      height: 2.5rem;
      border-radius: 50%;
      border: none;
      background: var(--color-neutral-white);
      color: var(--color-primary-green);
      cursor: pointer;
      transition: all 0.3s ease;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .action-btn:hover {
      background: var(--color-primary-green);
      color: var(--color-neutral-white);
    }

    /* We Care Section */
    .we-care-section {
      background: linear-gradient(135deg, var(--primary-color-light) 0%, var(--primary-color) 100%);
      padding: 4rem 0;
    }

    /* Hero Slider Styles */
    .hero-slider {
      position: relative;
    }

    .hero-slider .slick-prev,
    .hero-slider .slick-next {
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
      z-index: 10;
      width: 40px;
      height: 40px;
      background: rgba(255, 255, 255, 0.2);
      border: none;
      border-radius: 50%;
      color: white;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: all 0.3s ease;
    }

    .hero-slider .slick-prev:hover,
    .hero-slider .slick-next:hover {
      background: rgba(255, 255, 255, 0.4);
    }

    .hero-slider .slick-prev {
      left: 20px;
    }

    .hero-slider .slick-next {
      right: 20px;
    }

    .hero-slider .slick-prev i,
    .hero-slider .slick-next i {
      font-size: 18px;
    }

    /* Category Slider Styles */
    .category-slider {
      overflow: hidden;
    }

    .category-slider .slick-slide {
      padding: 0 5px;
      height: auto;
    }

    .category-slider .slick-slide>div {
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .category-slider .slick-list {
      margin: 0 -5px;
    }

    /* Slick Slider Gap for Product Cards */
    .product-slider .slick-slide {
      margin: 0 8px;
    }

    .product-slider .slick-list {
      margin: 0 -8px;
    }

    .product-slider .slick-prev,
    .product-slider .slick-next {
      z-index: 1;
      width: 40px;
      height: 40px;
    }

    .product-slider .slick-prev {
      left: -30px;
    }

    .product-slider .slick-next {
      right: -30px;
    }

    .product-slider .slick-prev:before,
    .product-slider .slick-next:before {
      font-size: 30px;
      color: var(--primary-color-light);
    }

    /* Hero slider dots */
    .hero-slider .slick-dots {
      bottom: 20px;
    }

    .hero-slider .slick-dots li button:before {
      color: white;
      font-size: 12px;
    }

    .hero-slider .slick-dots li.slick-active button:before {
      color: var(--primary-color-light);
    }

    /* Category slider arrows */
    .category-slider .slick-prev,
    .category-slider .slick-next {
      z-index: 1;
    }

    .category-slider .slick-prev {
      left: -20px;
    }

    .category-slider .slick-next {
      right: -20px;
    }

    /* Product card hover effects */
    .bg-transparent.rounded-lg.shadow-md:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    /* Line clamp utility */
    .line-clamp-2 {
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
      overflow: hidden;
    }

    /* Loading spinner */
    #loading {
      display: flex;
    }

    #loading.hidden {
      display: none;
    }

    /* Smooth transitions */
    * {
      transition-property: color, background-color, border-color,
        text-decoration-color, fill, stroke, opacity, box-shadow, transform,
        filter, backdrop-filter;
      transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
      transition-duration: 150ms;
    }

    /* Custom scrollbar */
    ::-webkit-scrollbar {
      width: 8px;
      height: 8px;
    }

    ::-webkit-scrollbar-track {
      background: #f1f1f1;
    }

    ::-webkit-scrollbar-thumb {
      background: var(--primary-color);
      border-radius: 4px;
    }

    ::-webkit-scrollbar-thumb:hover {
      background: var(--primary-color);
      opacity: 0.8;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
      .container-ds {
        padding-left: 1rem;
        padding-right: 1rem;
      }

      .product-slider .slick-prev,
      .product-slider .slick-next {
        display: none !important;
      }

      .category-slider .slick-prev,
      .category-slider .slick-next {
        display: none !important;
      }
    }

    .top-bar-bg {
      background-color: var(--primary-color) !important;
    }

    .main-header-bg,
    .footer-bg,
    .whatsapp-bg {
      background-color: var(--primary-color) !important;
    }
  </style>
@endpush

@section('content')
  @php
    use App\Utils\CartManager;
    $cart = CartManager::getCartListQuery(type: 'checked');
    $cartTotal = CartManager::getCartListTotalAppliedDiscount($cart);
    $shippingCost = CartManager::get_shipping_cost(type: 'checked');
    $couponDiscount = session()->has('coupon_discount') ? session('coupon_discount') : 0;
    $grandTotal = $cartTotal + $shippingCost - $couponDiscount;
  @endphp

  <div class="container mx-auto max-w-7xl px-4 py-8">
    <!-- Page Header -->
    <div class="mb-6">
      <h1 class="mb-2 text-center text-2xl font-bold text-black"
          style="font-family: 'Hind Siliguri', 'Noto Sans Bengali', sans-serif;">
        {{ translate('payment_method') }}
      </h1>
      <p class="text-center text-sm text-gray-600" style="font-family: 'Hind Siliguri', 'Noto Sans Bengali', sans-serif;">
        {{ translate('select_a_payment_method_to_proceed') }}
      </p>
    </div>

    <div class="flex flex-col gap-6 lg:flex-row">
      <!-- Payment Methods Section -->
      <div class="lg:w-2/3">
        @if (!$activeMinimumMethods)
          <div class="rounded-lg bg-white p-8 text-center shadow-md">
            <img src="{{ theme_asset(path: 'public/assets/front-end/img/icons/nodata.svg') }}" alt=""
                 class="mx-auto mb-4 h-16 w-16">
            <h5 class="font-medium text-gray-600">
              {{ translate('payment_methods_are_not_available_at_this_time.') }}</h5>
          </div>
        @else
          <div class="rounded-lg bg-white p-6 shadow-md">
            <!-- Cash on Delivery -->
            @if (($cashOnDeliveryBtnShow && $cash_on_delivery['status']) || (auth('customer')->check() && $wallet_status == 1))
              <div class="mb-6">
                <h3 class="mb-4 text-lg font-bold text-black"
                    style="font-family: 'Hind Siliguri', 'Noto Sans Bengali', sans-serif;">
                  {{ translate('payment_method') }}
                </h3>

                <div class="space-y-3">
                  @if ($cashOnDeliveryBtnShow && $cash_on_delivery['status'])
                    <div class="cursor-pointer rounded-lg border border-gray-200 p-4 transition-all hover:border-green-500"
                         id="cod-for-cart">
                      <form action="{{ route('checkout-complete') }}" method="get" class="needs-validation"
                            id="cash_on_delivery_form">
                        <label class="m-0 cursor-pointer">
                          <input type="hidden" name="payment_method" value="cash_on_delivery">
                          <div class="flex items-center gap-3">
                            <input type="radio" id="cash_on_delivery" name="payment_method_radio"
                                   class="h-5 w-5 border-gray-300 text-green-500 focus:ring-green-500" checked>
                            <div class="flex flex-1 items-center gap-3">
                              <span class="text-sm font-medium text-black"
                                    style="font-family: 'Hind Siliguri', 'Noto Sans Bengali', sans-serif;">
                                {{ translate('cash_on_Delivery') }}
                              </span>
                            </div>
                          </div>
                        </label>
                      </form>
                    </div>
                  @endif

                  <!-- Wallet Payment -->
                  @if (auth('customer')->check() && $wallet_status == 1)
                    <div
                         class="cursor-pointer rounded-lg border border-gray-200 p-4 transition-all hover:border-green-500">
                      <button class="flex w-full items-center gap-3" type="button" data-toggle="modal"
                              data-target="#wallet_submit_button">
                        <input type="radio" name="payment_method_radio" class="h-5 w-5 text-green-500">
                        <img width="24"
                             src="{{ theme_asset(path: 'public/assets/front-end/img/icons/wallet-sm.png') }}"
                             alt="Wallet" />
                        <span class="text-sm font-medium text-black"
                              style="font-family: 'Hind Siliguri', 'Noto Sans Bengali', sans-serif;">
                          {{ translate('pay_via_Wallet') }}
                        </span>
                      </button>
                    </div>
                  @endif
                </div>
              </div>
            @endif

            <!-- Digital Payment Methods -->
            @if ($digital_payment['status'] == 1)
              {{-- @if (count($payment_gateways_list) > 0 || (isset($offline_payment) && $offline_payment['status'] && count($offline_payment_methods) > 0))
                                <div class="mb-6">
                                    <h3 class="text-lg font-bold text-black mb-2"
                                        style="font-family: 'Hind Siliguri', 'Noto Sans Bengali', sans-serif;">
                                        {{ translate('pay_via_online') }}
                                    </h3>
                                    <p class="text-xs text-gray-600 mb-4">
                                        {{ translate('faster_&_secure_way_to_pay') }}
                                    </p>

                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                        @foreach ($payment_gateways_list as $payment_gateway)
                                            <?php
                                            // $additionalData = $payment_gateway->additional_data != null ? json_decode($payment_gateway->additional_data) : [];
                                            // $gatewayImgPath = dynamicAsset(path: 'public/assets/back-end/img/modal/payment-methods/' . $payment_gateway->key_name . '.png');
                                            // if ($additionalData != null && isset($additionalData->gateway_image) && file_exists(base_path('storage/app/public/payment_modules/gateway_image/' . $additionalData->gateway_image))) {
                                            //     $gatewayImgPath = $additionalData->gateway_image ? dynamicStorage(path: 'storage/app/public/payment_modules/gateway_image/' . $additionalData->gateway_image) : $gatewayImgPath;
                                            // }
                                            ?>

                                            <div class="border border-gray-200 rounded-lg p-4 hover:border-green-500 transition-all cursor-pointer">
                                                <form method="post" class="digital_payment"
                                                    id="{{ $payment_gateway->key_name }}_form"
                                                    action="{{ route('customer.web-payment-request') }}">
                                                    @csrf
                                                    <input type="hidden" name="user_id"
                                                        value="{{ auth('customer')->check() ? auth('customer')->user()->id : session('guest_id') }}">
                                                    <input type="hidden" name="customer_id"
                                                        value="{{ auth('customer')->check() ? auth('customer')->user()->id : session('guest_id') }}">
                                                    <input type="hidden" name="payment_method" value="{{ $payment_gateway->key_name }}">
                                                    <input type="hidden" name="payment_platform" value="web">

                                                    @if ($payment_gateway->mode == 'live' && isset($payment_gateway->live_values['callback_url']))
                                                        <input type="hidden" name="callback"
                                                            value="{{ $payment_gateway->live_values['callback_url'] }}">
                                                    @elseif ($payment_gateway->mode == 'test' && isset($payment_gateway->test_values['callback_url']))
                                                        <input type="hidden" name="callback"
                                                            value="{{ $payment_gateway->test_values['callback_url'] }}">
                                                    @else
                                                        <input type="hidden" name="callback" value="">
                                                    @endif

                                                    <input type="hidden" name="external_redirect_link"
                                                        value="{{ route('web-payment-success') }}">

                                                    <label class="flex items-center gap-3 cursor-pointer">
                                                        <input type="radio" id="{{ $payment_gateway->key_name }}"
                                                            name="online_payment" class="w-5 h-5 text-green-500"
                                                            value="{{ $payment_gateway->key_name }}">
                                                        <img width="30" src="{{ $gatewayImgPath }}" alt="">
                                                        <span class="text-sm font-medium text-black"
                                                            style="font-family: 'Hind Siliguri', 'Noto Sans Bengali', sans-serif;">
                                                            @if ($payment_gateway->additional_data && json_decode($payment_gateway->additional_data)->gateway_title != null)
                                                                {{ json_decode($payment_gateway->additional_data)->gateway_title }}
                                                            @else
                                                                {{ str_replace('_', ' ', $payment_gateway->key_name) }}
                                                            @endif
                                                        </span>
                                                    </label>
                                                </form>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif --}}

              <!-- Offline Payment -->
              @if (isset($offline_payment) && $offline_payment['status'] && count($offline_payment_methods) > 0)
                <div class="mb-6">
                  <div class="rounded-lg border border-green-200 bg-green-50 p-4">
                    <div class="mb-4 flex items-center justify-between">
                      <label class="flex cursor-pointer items-center gap-3">
                        <input type="radio" id="pay_offline" name="online_payment" class="h-5 w-5 text-green-500"
                               value="pay_offline">
                        <span class="text-sm font-medium text-black"
                              style="font-family: 'Hind Siliguri', 'Noto Sans Bengali', sans-serif;">
                          {{ translate('pay_offline') }}
                        </span>
                      </label>
                      <div data-toggle="tooltip"
                           title="{{ translate('for_offline_payment_options,_please_follow_the_steps_below') }}">
                        <i class="fa fa-info-circle text-green-600"></i>
                      </div>
                    </div>

                    <div class="pay_offline_card mt-4 hidden">
                      <div class="flex flex-wrap gap-3">
                        @foreach ($offline_payment_methods as $method)
                          <button type="button"
                                  class="offline_payment_button rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm font-medium transition-all hover:border-green-500"
                                  id="{{ $method->id }}">{{ $method->method_name }}</button>
                        @endforeach
                      </div>
                    </div>
                  </div>
                </div>
              @endif
            @endif

          </div>
        @endif
      </div>

      <!-- Order Summary Sidebar -->
      <div class="lg:w-1/3">
        <div class="sticky top-4 rounded-lg bg-white p-6 shadow-md">
          <h3 class="mb-4 text-lg font-bold text-black"
              style="font-family: 'Hind Siliguri', 'Noto Sans Bengali', sans-serif;">
            {{ translate('order_summary') }}
          </h3>

          @php
            $subTotal = 0;
            $totalTax = 0;
            $totalDiscountOnProduct = 0;
            $totalShippingCost = $shippingCost;
            $getShippingCostSavedForFreeDelivery = CartManager::getShippingCostSavedForFreeDelivery(type: 'checked');

            if ($cart->count() > 0) {
                foreach ($cart as $cartItem) {
                    $subTotal += $cartItem['price'] * $cartItem['quantity'];
                    $totalTax += $cartItem['tax_model'] == 'exclude' ? $cartItem['tax'] * $cartItem['quantity'] : 0;
                    $totalDiscountOnProduct += $cartItem['discount'] * $cartItem['quantity'];
                }

                if (session()->missing('coupon_type') || session('coupon_type') != 'free_delivery') {
                    $totalShippingCost = $shippingCost - $getShippingCostSavedForFreeDelivery;
                }
            }

            $couponDiscountAmount = session()->has('coupon_discount') ? session('coupon_discount') : 0;
            $totalAmount = $subTotal + $totalTax + $totalShippingCost - $couponDiscountAmount - $totalDiscountOnProduct;
          @endphp

          <div class="mb-4 space-y-3">
            <div class="flex items-center justify-between">
              <span class="text-sm text-gray-600" style="font-family: 'Hind Siliguri', 'Noto Sans Bengali', sans-serif;">
                {{ translate('sub_total') }}
              </span>
              <span class="text-sm font-medium text-black">
                {{ webCurrencyConverter($subTotal - $totalDiscountOnProduct) }}
              </span>
            </div>

            @if ($totalTax > 0)
              <div class="flex items-center justify-between">
                <span class="text-sm text-gray-600"
                      style="font-family: 'Hind Siliguri', 'Noto Sans Bengali', sans-serif;">
                  {{ translate('tax') }}
                </span>
                <span class="text-sm font-medium text-black">
                  {{ webCurrencyConverter($totalTax) }}
                </span>
              </div>
            @endif

            <div class="flex items-center justify-between">
              <span class="text-sm text-gray-600" style="font-family: 'Hind Siliguri', 'Noto Sans Bengali', sans-serif;">
                {{ translate('shipping') }}
              </span>
              <span class="text-sm font-medium text-green-600">
                {{ webCurrencyConverter($totalShippingCost) }}
              </span>
            </div>

            @if ($couponDiscountAmount > 0)
              <div class="flex items-center justify-between">
                <span class="text-sm text-gray-600"
                      style="font-family: 'Hind Siliguri', 'Noto Sans Bengali', sans-serif;">
                  {{ translate('coupon_discount') }}
                </span>
                <span class="text-sm font-medium text-green-600">
                  -{{ webCurrencyConverter($couponDiscountAmount) }}
                </span>
              </div>
            @endif
          </div>

          <div class="mb-4 border-t-2 border-gray-200 pt-4">
            <div class="mb-4 flex items-center justify-between">
              <span class="text-lg font-bold text-black"
                    style="font-family: 'Hind Siliguri', 'Noto Sans Bengali', sans-serif;">
                {{ translate('total') }}
              </span>
              <span class="text-xl font-extrabold text-black">
                {{ webCurrencyConverter($totalAmount) }}
              </span>
            </div>

            <!-- Proceed Checkout Button -->
            <button type="button" id="place-order-btn"
                    class="flex w-full cursor-pointer items-center justify-center gap-2 rounded-lg border-none bg-orange-500 px-6 py-3 text-base font-bold text-white transition-all duration-300 hover:-translate-y-0.5 hover:bg-orange-600 hover:shadow-lg disabled:transform-none disabled:cursor-not-allowed disabled:bg-gray-300 disabled:shadow-none"
                    style="font-family: 'Hind Siliguri', 'Noto Sans Bengali', sans-serif;">
              <span id="place-order-btn-text">{{ translate('proceed_checkout') ?? 'Proceed Checkout' }}</span>
              <span id="place-order-btn-loading" class="hidden">
                <svg class="h-5 w-5 animate-spin text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                     viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                          stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                  </path>
                </svg>
                {{ translate('processing') ?? 'Processing...' }}
              </span>
            </button>
          </div>

          <a href="{{ route('checkout-details') }}"
             class="inline-flex items-center gap-2 text-sm font-medium text-green-600 hover:text-green-700">
            <i class="fa fa-arrow-left"></i>
            {{ translate('go_back') }}
          </a>
        </div>
      </div>
    </div>
  </div>

  <!-- Offline Payment Modal -->
  @if (isset($offline_payment) && $offline_payment['status'])
    <div class="modal fade" id="selectPaymentMethod" tabindex="-1" aria-labelledby="selectPaymentMethodLabel"
         aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content">
          <div class="modal-header border-0 pb-0">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="{{ route('offline-payment-checkout-complete') }}" method="post"
                  class="needs-validation form-loading-button-form">
              @csrf
              <div class="mb-4 flex justify-center">
                <img width="52"
                     src="{{ theme_asset(path: 'public/assets/front-end/img/select-payment-method.png') }}"
                     alt="">
              </div>
              <p class="mb-4 text-center text-sm">
                {{ translate('pay_your_bill_using_any_of_the_payment_method_below_and_input_the_required_information_in_the_form') }}
              </p>

              <select class="mb-4 w-full rounded-md border border-gray-200 px-3 py-2" id="pay_offline_method"
                      name="payment_by" required>
                <option value="" disabled>{{ translate('select_Payment_Method') }}</option>
                @foreach ($offline_payment_methods as $method)
                  <option value="{{ $method->id }}">{{ translate('payment_Method') }} :
                    {{ $method->method_name }}</option>
                @endforeach
              </select>
              <div class="" id="payment_method_field">
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  @endif

  <!-- Wallet Payment Modal -->
  @if (auth('customer')->check() && $wallet_status == 1)
    <div class="modal fade" id="wallet_submit_button" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">{{ translate('wallet_payment') }}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          @php($customer_balance = auth('customer')->user()->wallet_balance)
          @php($couponAmount = session()->has('coupon_discount') ? session('coupon_discount') : 0)
          @php($totalAmount = $amount - $couponAmount)
          @php($remain_balance = $customer_balance - $totalAmount)
          <form action="{{ route('checkout-complete-wallet') }}" method="get" class="needs-validation">
            @csrf
            <div class="modal-body">
              <div class="mb-4">
                <label class="mb-1 block text-sm font-medium">{{ translate('your_current_balance') }}</label>
                <input class="w-full rounded-md border border-gray-200 px-3 py-2" type="text"
                       value="{{ webCurrencyConverter(amount: $customer_balance ?? 0) }}" readonly>
              </div>

              <div class="mb-4">
                <label class="mb-1 block text-sm font-medium">{{ translate('order_amount') }}</label>
                <input class="w-full rounded-md border border-gray-200 px-3 py-2" type="text"
                       value="{{ webCurrencyConverter(amount: $totalAmount ?? 0) }}" readonly>
              </div>

              <div class="mb-4">
                <label class="mb-1 block text-sm font-medium">{{ translate('remaining_balance') }}</label>
                <input class="w-full rounded-md border border-gray-200 px-3 py-2" type="text"
                       value="{{ webCurrencyConverter(amount: $remain_balance ?? 0) }}" readonly>
                @if ($remain_balance < 0)
                  <label class="mt-1 text-sm text-red-500">
                    {{ translate('you_do_not_have_sufficient_balance_for_pay_this_order!!') }}</label>
                @endif
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="rounded-md bg-gray-200 px-4 py-2"
                      data-dismiss="modal">{{ translate('close') }}</button>
              <button type="submit" class="rounded-md bg-green-600 px-4 py-2 text-white"
                      {{ $remain_balance > 0 ? '' : 'disabled' }}>{{ translate('submit') }}</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  @endif

  <span id="route-action-checkout-function" data-route="checkout-payment"></span>
@endsection

@push('script')
  <script src="{{ theme_asset(path: 'public/assets/front-end/js/payment.js') }}"></script>
  <script>
    // Auto-select Cash on Delivery on page load
    $(document).ready(function() {
      // Ensure COD is checked by default
      if ($('#cash_on_delivery').length) {
        $('#cash_on_delivery').prop('checked', true);
        // Uncheck any other payment methods
        $('input[name="payment_method_radio"], input[name="online_payment"]').not('#cash_on_delivery').prop('checked',
          false);
      }
    });

    // Handle payment method radio changes
    $(document).on('change', 'input[name="payment_method_radio"], input[name="online_payment"]', function() {
      $('input[name="payment_method_radio"], input[name="online_payment"]').not(this).prop('checked', false);
    });

    // Handle offline payment selection
    $(document).on('change', '#pay_offline', function() {
      if ($(this).is(':checked')) {
        $('.pay_offline_card').removeClass('hidden');
      } else {
        $('.pay_offline_card').addClass('hidden');
      }
    });

    // Handle Proceed Checkout button click
    $('#place-order-btn').on('click', function(e) {
      e.preventDefault();

      const $btn = $(this);
      const $btnText = $('#place-order-btn-text');
      const $btnLoading = $('#place-order-btn-loading');

      // Check if a payment method is selected (COD should be selected by default)
      const selectedPaymentMethod = $(
        'input[name="payment_method_radio"]:checked, input[name="online_payment"]:checked');

      // If no payment method selected, default to COD
      if (selectedPaymentMethod.length === 0) {
        if ($('#cash_on_delivery').length) {
          $('#cash_on_delivery').prop('checked', true);
          // Submit COD form directly
          $btn.prop('disabled', true);
          $btnText.addClass('hidden');
          $btnLoading.removeClass('hidden');
          $('#cash_on_delivery_form').submit();
          return false;
        } else {
          if (typeof toastr !== 'undefined') {
            toastr.warning('{{ translate('please_select_a_payment_method') ?? 'Please select a payment method' }}', {
              CloseButton: true,
              ProgressBar: true
            });
          } else {
            alert('{{ translate('please_select_a_payment_method') ?? 'Please select a payment method' }}');
          }
          return false;
        }
      }

      // Disable button and show loading
      $btn.prop('disabled', true);
      $btnText.addClass('hidden');
      $btnLoading.removeClass('hidden');

      // Submit the form based on selected payment method
      const paymentMethodId = selectedPaymentMethod.attr('id');

      if (paymentMethodId === 'cash_on_delivery') {
        // Submit cash on delivery form
        $('#cash_on_delivery_form').submit();
      } else if (selectedPaymentMethod.closest('form').length > 0) {
        // Submit the form that contains the selected payment method
        selectedPaymentMethod.closest('form').submit();
      } else {
        // For wallet or other methods that use modals
        if (selectedPaymentMethod.closest('button').data('target')) {
          const modalTarget = selectedPaymentMethod.closest('button').data('target');
          $(modalTarget).modal('show');
          // Re-enable button
          $btn.prop('disabled', false);
          $btnText.removeClass('hidden');
          $btnLoading.addClass('hidden');
        } else {
          // Re-enable button if no form found
          $btn.prop('disabled', false);
          $btnText.removeClass('hidden');
          $btnLoading.addClass('hidden');

          if (typeof toastr !== 'undefined') {
            toastr.error('{{ translate('something_went_wrong') ?? 'Something went wrong' }}', {
              CloseButton: true,
              ProgressBar: true
            });
          }
        }
      }
    });
  </script>
@endpush
