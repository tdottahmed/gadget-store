@extends('web-views.layouts.app')

@section('title', translate('order_Complete') . ' | ' . $web_config['company_name'])

@section('content')
    <div class="container mx-auto px-4 py-12 max-w-4xl">
        <div class="flex justify-center">
            <div class="w-full max-w-2xl">
                @if(auth('customer')->check() || session('guest_id'))
                    <div class="bg-white rounded-lg shadow-lg p-8 md:p-12">
                        <!-- Success Icon -->
                        <div class="flex justify-center mb-6">
                            <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center">
                                <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                        </div>

                        <!-- Success Message -->
                        <div class="text-center mb-6">
                            <h2 class="text-2xl md:text-3xl font-bold text-black mb-3"
                                style="font-family: 'Hind Siliguri', 'Noto Sans Bengali', sans-serif;">
                                @if(isset($isNewCustomerInSession) && $isNewCustomerInSession)
                                    {{ translate('Order_Placed_&_Account_Created_Successfully') }}!
                                @else
                                    {{ translate('Order_Placed_Successfully') }}!
                                @endif
                            </h2>

                            @if (isset($order_ids) && count($order_ids) > 0)
                                <p class="text-gray-600 text-sm md:text-base mb-2"
                                    style="font-family: 'Hind Siliguri', 'Noto Sans Bengali', sans-serif;">
                                    {{ translate('your_payment_has_been_successfully_processed_and_your_order') }} -
                                    <span class="font-bold text-green-600">
                                        @foreach ($order_ids as $key => $order)
                                            {{ $order }}@if(!$loop->last), @endif
                                        @endforeach
                                    </span>
                                    {{ translate('has_been_placed.') }}
                                </p>
                            @else
                                <p class="text-gray-600 text-sm md:text-base"
                                    style="font-family: 'Hind Siliguri', 'Noto Sans Bengali', sans-serif;">
                                    {{ translate('your_order_is_being_processed_and_will_be_completed.') }}
                                    {{ translate('You_will_receive_an_email_confirmation_when_your_order_is_placed.') }}
                                </p>
                            @endif
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mt-8">
                            <a href="{{ route('track-order.index') }}"
                                class="w-full sm:w-auto px-8 py-3 bg-green-600 text-white rounded-lg font-bold text-center hover:bg-green-700 transition-all duration-300 hover:-translate-y-0.5 hover:shadow-lg"
                                style="font-family: 'Hind Siliguri', 'Noto Sans Bengali', sans-serif;">
                                {{ translate('track_Order') }}
                            </a>
                            <a href="{{ route('home') }}"
                                class="w-full sm:w-auto px-8 py-3 bg-gray-100 text-gray-700 rounded-lg font-bold text-center hover:bg-gray-200 transition-all duration-300"
                                style="font-family: 'Hind Siliguri', 'Noto Sans Bengali', sans-serif;">
                                {{ translate('Continue_Shopping') }}
                            </a>
                        </div>

                        <!-- Additional Info -->
                        <div class="mt-8 pt-6 border-t border-gray-200">
                            <p class="text-center text-sm text-gray-500"
                                style="font-family: 'Hind Siliguri', 'Noto Sans Bengali', sans-serif;">
                                {{ translate('thank_you_for_your_order') }}! 
                                {{ translate('your_order_has_been_processed') }}.
                                {{ translate('check_your_email_to_get_the_order_id_and_details') }}.
                            </p>
                        </div>
                    </div>
                @else
                    <!-- Not authenticated or guest -->
                    <div class="bg-white rounded-lg shadow-lg p-8 text-center">
                        <div class="mb-4">
                            <svg class="w-16 h-16 text-gray-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-700 mb-2"
                            style="font-family: 'Hind Siliguri', 'Noto Sans Bengali', sans-serif;">
                            {{ translate('Access_Denied') }}
                        </h3>
                        <p class="text-gray-600 mb-6"
                            style="font-family: 'Hind Siliguri', 'Noto Sans Bengali', sans-serif;">
                            {{ translate('Please_login_to_view_your_order') }}.
                        </p>
                        <a href="{{ route('home') }}"
                            class="inline-block px-6 py-3 bg-green-600 text-white rounded-lg font-bold hover:bg-green-700 transition-all duration-300"
                            style="font-family: 'Hind Siliguri', 'Noto Sans Bengali', sans-serif;">
                            {{ translate('Go_to_Home') }}
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

