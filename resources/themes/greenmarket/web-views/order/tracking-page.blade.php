@extends('web-views.layouts.app')

@section('title', translate('track_Order') . ' | ' . $web_config['company_name'])

@push('css_or_js')
    <meta property="og:image" content="{{ $web_config['web_logo']['path'] }}" />
    <meta property="og:title" content="{{ $web_config['company_name'] }} " />
    <meta property="og:url" content="{{ env('APP_URL') }}">
    <meta property="og:description" content="{{ $web_config['meta_description'] }}">
    <meta property="twitter:card" content="{{ $web_config['web_logo']['path'] }}" />
    <meta property="twitter:title" content="{{ $web_config['company_name'] }}" />
    <meta property="twitter:url" content="{{ env('APP_URL') }}">
    <meta property="twitter:description" content="{{ $web_config['meta_description'] }}">

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
    <div class="container mx-auto px-4 py-12 max-w-4xl">
        <div class="bg-white rounded-lg shadow-lg p-6 md:p-8">
            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl md:text-3xl font-bold text-black text-center flex-1"
                    style="font-family: 'Hind Siliguri', 'Noto Sans Bengali', sans-serif;">
                    {{ translate('track_order') }}
                </h2>
                <a href="{{ route('track-order.index') }}"
                    class="text-green-600 hover:text-green-700 text-sm font-medium flex items-center gap-2">
                    <i class="fa fa-refresh"></i>
                    {{ translate('clear') }}
                </a>
            </div>

            <!-- Tracking Form -->
            <form action="{{ route('track-order.result') }}" method="post" class="max-w-2xl mx-auto">
                @csrf

                @if(session()->has('Error'))
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                        <div class="flex items-center justify-between">
                            <span class="text-red-800 font-medium">{{ session()->get('Error') }}</span>
                            <button type="button" class="text-red-600 hover:text-red-800" onclick="this.parentElement.parentElement.remove()">
                                <i class="fa fa-times"></i>
                            </button>
                        </div>
                    </div>
                @endif

                <div class="space-y-4 mb-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Order ID Input -->
                        <div>
                            <label for="order_id" class="block text-sm font-semibold text-black mb-2"
                                style="font-family: 'Hind Siliguri', 'Noto Sans Bengali', sans-serif;">
                                {{ translate('order_ID') }}
                            </label>
                            <input type="number" id="order_id" name="order_id"
                                value="{{ request('order_id') }}"
                                placeholder="{{ translate('order_id') }}"
                                required
                                class="w-full px-4 py-3 border border-gray-200 rounded-lg text-sm text-black bg-white transition-all duration-300 placeholder:text-gray-300 focus:border-green-500 focus:outline-none focus:ring-3 focus:ring-green-100"
                                style="font-family: 'Hind Siliguri', 'Noto Sans Bengali', sans-serif;">
                        </div>

                        <!-- Phone Number Input -->
                        <div>
                            <label for="phone_number" class="block text-sm font-semibold text-black mb-2"
                                style="font-family: 'Hind Siliguri', 'Noto Sans Bengali', sans-serif;">
                                {{ translate('phone') }}
                            </label>
                            <input type="tel" id="phone_number" name="phone_number"
                                value="{{ request('phone_number') }}"
                                placeholder="{{ translate('your_phone_number') }}"
                                required
                                class="w-full px-4 py-3 border border-gray-200 rounded-lg text-sm text-black bg-white transition-all duration-300 placeholder:text-gray-300 focus:border-green-500 focus:outline-none focus:ring-3 focus:ring-green-100"
                                style="font-family: 'Hind Siliguri', 'Noto Sans Bengali', sans-serif;">
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-2">
                        <button type="submit" name="trackOrder"
                            class="w-full md:w-auto px-8 py-3 bg-green-600 text-white rounded-lg font-bold text-center hover:bg-green-700 transition-all duration-300 hover:-translate-y-0.5 hover:shadow-lg"
                            style="font-family: 'Hind Siliguri', 'Noto Sans Bengali', sans-serif;">
                            {{ translate('track_order') }}
                        </button>
                    </div>
                </div>

                <!-- Info Section -->
                <div class="text-center pt-8 border-t border-gray-200">
                    <div class="flex justify-center mb-4">
                    </div>
                    <p class="text-gray-600 text-sm md:text-base max-w-md mx-auto"
                        style="font-family: 'Hind Siliguri', 'Noto Sans Bengali', sans-serif;">
                        {{ translate('enter_your_order_ID_&_phone_number_to_get_delivery_updates') }}
                    </p>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('script')
    <script>
        // Auto-focus on order ID input
        $(document).ready(function() {
            $('#order_id').focus();
        });

        // Form validation
        $('form').on('submit', function(e) {
            const orderId = $('#order_id').val().trim();
            const phoneNumber = $('#phone_number').val().trim();

            if (!orderId || !phoneNumber) {
                e.preventDefault();
                if (typeof toastr !== 'undefined') {
                    toastr.warning('{{ translate("please_fill_all_fields") ?? "Please fill all fields" }}', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                } else {
                    alert('{{ translate("please_fill_all_fields") ?? "Please fill all fields" }}');
                }
                return false;
            }
        });
    </script>
@endpush

