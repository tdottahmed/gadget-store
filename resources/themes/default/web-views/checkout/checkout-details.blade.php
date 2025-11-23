@extends('layouts.front-end.app')

@section('title', translate('Checkout'))

@section('content')

    <div class="container pb-5 mb-2 mb-md-4 rtl __inline-54 text-align-direction checkout-details-page">
        <div class="row">
            <div class="col-md-12 mb-5 pt-5">
                <div class="feature_header __feature_header">
                    <span>{{ translate('checkout')}}</span>
                </div>
            </div>
            <section class="col-lg-8">
                <div class="checkout_details">
                    @include('web-views.partials._checkout-steps',['step'=>1])
                    <h2 class="h4 pb-3 mb-2 mt-5">{{translate('shipping_information')}}</h2>
                    
                    <form class="needs-validation" autocomplete="off" id="checkout-form" novalidate>
                        @csrf
                        <div class="card">
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="contact_person_name">
                                                {{ translate('name')}} <span class="text-danger">*</span>
                                            </label>
                                            <input class="form-control" type="text" name="contact_person_name"
                                                   id="contact_person_name" value="{{auth('customer')->check() ? auth('customer')->user()->f_name : ''}}"
                                                   placeholder="{{ translate('enter_your_name') }}" required>
                                            <div class="invalid-feedback">
                                                {{ translate('please_enter_your_name')}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="phone">
                                                {{ translate('phone')}} <span class="text-danger">*</span>
                                            </label>
                                            <input class="form-control" type="tel" name="phone"
                                                   id="phone" value="{{auth('customer')->check() ? auth('customer')->user()->phone : ''}}"
                                                   placeholder="{{ translate('enter_your_phone') }}" required>
                                            <div class="invalid-feedback">
                                                {{ translate('please_enter_your_phone')}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                @if(!auth('customer')->check())
                                <div class="form-row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="email">
                                                {{ translate('email_address')}} <span class="text-danger">*</span>
                                            </label>
                                            <input class="form-control" type="email" name="email"
                                                   id="email" value="{{old('email')}}"
                                                   placeholder="{{ translate('enter_your_email') }}" required>
                                            <div class="invalid-feedback">
                                                {{ translate('please_provide_a_valid_email_address')}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                
                                <div class="form-row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="city">
                                                {{ translate('city')}} <span class="text-danger">*</span>
                                            </label>
                                            <input class="form-control" type="text" name="city"
                                                   id="city" value="{{old('city')}}"
                                                   placeholder="{{ translate('enter_your_city') }}" required>
                                            <div class="invalid-feedback">
                                                {{ translate('please_enter_your_city')}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="address">
                                                {{ translate('address')}} <span class="text-danger">*</span>
                                            </label>
                                            <textarea class="form-control" name="address" id="address" rows="3"
                                                      placeholder="{{ translate('enter_your_full_address') }}" required></textarea>
                                            <div class="invalid-feedback">
                                                {{ translate('please_enter_your_address')}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                @if(isset($shipping_methods) && count($shipping_methods) > 0 && $response['physical_product_view'] == 'yes')
                                <div class="form-row mt-3">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="mb-3">
                                                {{ translate('shipping_method')}} <span class="text-danger">*</span>
                                            </label>
                                            <div class="border rounded p-3 shipping-methods-container">
                                                @foreach($shipping_methods as $method)
                                                <div class="shipping-method-item position-relative rounded p-3 mb-2 {{isset($selected_shipping_method) && $selected_shipping_method == $method->id ? 'selected' : ($loop->first ? 'selected' : '')}}"
                                                     data-method-id="{{$method->id}}">
                                                    <div class="form-check mb-0">
                                                        <input class="form-check-input shipping-method-radio" type="radio" 
                                                               name="shipping_method_id" 
                                                               id="shipping_method_{{$method->id}}" 
                                                               value="{{$method->id}}"
                                                               data-cost="{{$method->cost}}"
                                                               data-method-id="{{$method->id}}"
                                                               {{isset($selected_shipping_method) && $selected_shipping_method == $method->id ? 'checked' : ($loop->first ? 'checked' : '')}}
                                                               required>
                                                        <label class="form-check-label d-flex align-items-center w-100" for="shipping_method_{{$method->id}}">
                                                            <span class="custom-radio me-3"></span>
                                                            <div class="shipping-method-content flex-grow-1">
                                                                <div class="shipping-method-title fw-medium">
                                                                    {{$method->title}} 
                                                                    @if($method->duration)
                                                                        <span class="text-muted">({{$method->duration}})</span>
                                                                    @endif
                                                                </div>
                                                                <div class="shipping-method-cost text-success fw-medium">
                                                                    {{ webCurrencyConverter(amount: $method->cost) }}
                                                                </div>
                                                            </div>
                                                        </label>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                            <div class="invalid-feedback">
                                                {{ translate('please_select_shipping_method')}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                
                                <div class="form-row mt-3">
                                    <div class="col-12">
                                        <button class="btn btn--primary btn-block" type="submit">
                                            {{ translate('proceed_to_payment')}}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>

                <br>
                <div class="row">
                    <div class="col-12">
                        <a class="btn btn-secondary btn-block" href="{{route('shop-cart')}}">
                            <i class="czi-arrow-{{Session::get('direction') === "rtl" ? 'right' : 'left'}} mt-sm-0 mx-1"></i>
                            <span class="d-none d-sm-inline">{{ translate('back_to_cart')}} </span>
                            <span class="d-inline d-sm-none">{{ translate('back')}}</span>
                        </a>
                    </div>
                </div>
            </section>

            @include('web-views.partials._order-summary')
        </div>
    </div>

    <span id="route-action-checkout-function" data-route="checkout-details"></span>
    <span id="route-choose-shipping-address" data-url="{{ route('customer.choose-shipping-address') }}"></span>
    <span id="route-set-shipping-method" data-url="{{ route('customer.set-shipping-method') }}"></span>
    @if(isset($cart_group_ids) && count($cart_group_ids) > 0)
        <input type="hidden" id="checkout-cart-group-id" value="{{ $cart_group_ids[0] }}">
    @endif

    <style>
        /* Custom radio button styles */
        .shipping-method-item {
            border: 2px solid #e9ecef;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .shipping-method-item:hover {
            border-color: #42d697;
            background-color: rgba(66, 214, 151, 0.05);
        }

        .shipping-method-item.selected {
            border-color: #42d697;
            background-color: rgba(66, 214, 151, 0.1);
            box-shadow: 0 0 0 1px #42d697;
        }

        /* Hide default radio button */
        .shipping-method-radio {
            position: absolute;
            opacity: 0;
            cursor: pointer;
        }

        /* Custom radio button */
        .custom-radio {
            position: relative;
            width: 20px;
            height: 20px;
            border: 2px solid #adb5bd;
            border-radius: 50%;
            transition: all 0.3s ease;
            flex-shrink: 0;
        }

        .shipping-method-radio:checked + .form-check-label .custom-radio {
            border-color: #42d697;
            background-color: #42d697;
        }

        .shipping-method-radio:checked + .form-check-label .custom-radio::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 8px;
            height: 8px;
            background-color: white;
            border-radius: 50%;
        }

        .shipping-method-radio:focus + .form-check-label .custom-radio {
            box-shadow: 0 0 0 2px rgba(66, 214, 151, 0.25);
        }

        .shipping-method-content {
            margin-left: 8px;
        }

        .shipping-method-title {
            font-size: 1rem;
            margin-bottom: 4px;
        }

        .shipping-method-cost {
            font-size: 0.95rem;
        }

        /* Improved container styling */
        .shipping-methods-container {
            background-color: #f8f9fa;
            border: 1px solid #e9ecef !important;
        }

        /* Animation for selection */
        .shipping-method-item {
            animation: fadeIn 0.3s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0.8; transform: translateY(2px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
@endsection

@push('script')

    <script>
        $('#checkout-form').submit(function (e) {
            e.preventDefault();
            
            if (!this.checkValidity()) {
                e.stopPropagation();
                $(this).addClass('was-validated');
                return false;
            }
            
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            
            // Get default country from config
            let defaultCountry = 'Bangladesh';
            @if(isset($default_location) && $default_location)
                @php
                    // Check if $default_location is already an array or a JSON string
                    if (is_array($default_location)) {
                        $locationData = $default_location;
                    } else {
                        $locationData = json_decode($default_location, true);
                    }
                    $defaultCountryValue = (is_array($locationData) && isset($locationData['country'])) ? $locationData['country'] : 'Bangladesh';
                @endphp
                defaultCountry = '{{ $defaultCountryValue }}';
            @endif
            
            // Get selected shipping method
            let selectedShippingMethod = $('input[name="shipping_method_id"]:checked').val() || '0';
            
            // Prepare form data with default values for required fields
            let formData = {
                shipping: $.param({
                    contact_person_name: $('#contact_person_name').val(),
                    phone: $('#phone').val(),
                    email: $('#email').val() || '',
                    city: $('#city').val(),
                    address: $('#address').val(),
                    address_type: 'home', // Default value
                    zip: '0000', // Default value
                    country: defaultCountry, // Default or from config
                    latitude: '0',
                    longitude: '0',
                    shipping_method_id: selectedShippingMethod
                }),
                billing: $.param({
                    billing_addresss_same_shipping: 'true'
                }),
                physical_product: '{{ $response["physical_product_view"] ?? "yes" }}'
            };
            
            $.ajax({
                url: $('#route-choose-shipping-address').data('url'),
                type: 'POST',
                data: formData,
                beforeSend: function () {
                    $('#loading').show();
                },
                success: function (data) {
                    if (data.errors) {
                        toastr.error(data.errors, {
                            CloseButton: true,
                            ProgressBar: true
                        });
                    } else {
                        toastr.success('{{ translate("address_saved_successfully")}}', {
                            CloseButton: true,
                            ProgressBar: true
                        });
                        setTimeout(function () {
                            location.href = '{{ route("checkout-payment") }}';
                        }, 500);
                    }
                },
                complete: function () {
                    $('#loading').hide();
                },
                error: function (xhr) {
                    let errorMessage = '{{ translate("something_went_wrong")}}';
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        errorMessage = xhr.responseJSON.errors;
                    }
                    toastr.error(errorMessage, {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
            });
        });
        
        // Handle shipping method selection change - update shipping cost via AJAX
        $('.shipping-method-radio').on('change', function() {
            let methodId = $(this).val();
            let cartGroupId = $('#checkout-cart-group-id').val();
            
            // Update visual selection
            $('.shipping-method-item').removeClass('selected');
            $(this).closest('.shipping-method-item').addClass('selected');
            
            if (!cartGroupId || !methodId) {
                return;
            }
            
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            
            $.ajax({
                url: $('#route-set-shipping-method').data('url'),
                type: 'GET',
                data: {
                    id: methodId,
                    cart_group_id: cartGroupId
                },
                beforeSend: function() {
                    $('#loading').show();
                },
                success: function(response) {
                    if (response.status == 1) {
                        // Reload page to update order summary with new shipping cost
                        location.reload();
                    } else {
                        toastr.error('{{ translate("failed_to_update_shipping_method")}}', {
                            CloseButton: true,
                            ProgressBar: true
                        });
                    }
                },
                complete: function() {
                    $('#loading').hide();
                },
                error: function() {
                    toastr.error('{{ translate("something_went_wrong")}}', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
            });
        });

        // Add click handler for shipping method items
        $('.shipping-method-item').on('click', function() {
            const radio = $(this).find('.shipping-method-radio');
            radio.prop('checked', true).trigger('change');
        });
    </script>

@endpush