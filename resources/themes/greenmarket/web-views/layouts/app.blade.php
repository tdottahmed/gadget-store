<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ session()->get('direction') ?? 'ltr' }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="_token" content="{{ csrf_token() }}">
    <meta name="robots" content="index, follow">
    <meta property="og:site_name" content="{{ $web_config['company_name'] }}" />

    <meta name="google-site-verification" content="{{ getWebConfig('google_search_console_code') }}">
    <meta name="msvalidate.01" content="{{ getWebConfig('bing_webmaster_code') }}">
    <meta name="baidu-site-verification" content="{{ getWebConfig('baidu_webmaster_code') }}">
    <meta name="yandex-verification" content="{{ getWebConfig('yandex_webmaster_code') }}">

    <link rel="apple-touch-icon" sizes="180x180" href="{{ $web_config['fav_icon']['path'] }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ $web_config['fav_icon']['path'] }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@400;500;600&family=Hind+Siliguri:wght@400;500;600;700&family=Noto+Sans+Bengali:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- slick css --}}
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <link rel="stylesheet" type="text/css"
        href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" />

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet"
        href="{{ dynamicAsset(path: 'public/assets/backend/libs/intl-tel-input/css/intlTelInput.css') }}">
    <link rel="stylesheet"
        href="{{ dynamicAsset(path: 'public/assets/backend/libs/google-recaptcha/google-recaptcha-init.css') }}">

    @stack('css_or_js')
    @include(VIEW_FILE_NAMES['robots_meta_content_partials'])
    <title>@yield('title')</title>

    {{-- Dynamic Theme Colors --}}
    @php
        $systemColors = getWebConfig('colors');
        $primaryColor = $systemColors['primary'] ?? '#003315';
        $secondaryColor = $systemColors['secondary'] ?? '#F58300';
        $primaryColorLight = $systemColors['primary_light'] ?? '#2d8659';
        $panelSidebarColor = $systemColors['panel-sidebar'] ?? '#003315';

        // Generate darker/lighter variants for hover states
        function adjustBrightness($hex, $percent)
        {
            $hex = str_replace('#', '', $hex);
            $r = hexdec(substr($hex, 0, 2));
            $g = hexdec(substr($hex, 2, 2));
            $b = hexdec(substr($hex, 4, 2));

            $r = max(0, min(255, $r + $r * $percent));
            $g = max(0, min(255, $g + $g * $percent));
            $b = max(0, min(255, $b + $b * $percent));

            return '#' .
                str_pad(dechex($r), 2, '0', STR_PAD_LEFT) .
                str_pad(dechex($g), 2, '0', STR_PAD_LEFT) .
                str_pad(dechex($b), 2, '0', STR_PAD_LEFT);
        }

        $primaryColorHover = adjustBrightness($primaryColor, -0.1);
        $primaryColorLightHover = adjustBrightness($primaryColorLight, -0.1);
    @endphp
    <style>
        :root {
            --primary-color: {{ $primaryColor }};
            --secondary-color: {{ $secondaryColor }};
            --primary-color-light: {{ $primaryColorLight }};
            --panel-sidebar-color: {{ $panelSidebarColor }};
            --primary-color-hover: {{ $primaryColorHover }};
            --primary-color-light-hover: {{ $primaryColorLightHover }};
        }

        /* Dynamic Color Classes */
        .top-bar-bg {
            background-color: var(--secondary-color) !important;
        }

        .main-header-bg,
        .footer-bg {
            background-color: var(--primary-color) !important;
        }

        .whatsapp-bg {
            background-color: #fa582c !important;
        }

        /* Call Button Animation - Top to Bottom */
        @keyframes callButtonBounce {
            0% {
                transform: translateY(-10px);
            }
            50% {
                transform: translateY(10px);
            }
            100% {
                transform: translateY(-10px);
            }
        }

        .call-button-animate {
            animation: callButtonBounce 2s ease-in-out infinite;
        }

        .bg-primary-dynamic {
            background-color: var(--primary-color) !important;
        }

        .bg-primary-light-dynamic {
            background-color: var(--primary-color-light) !important;
        }

        .text-primary-dynamic {
            color: var(--primary-color) !important;
        }

        .text-primary-light-dynamic {
            color: var(--primary-color-light) !important;
        }

        .border-primary-dynamic {
            border-color: var(--primary-color) !important;
        }

        .border-primary-light-dynamic {
            border-color: var(--primary-color-light) !important;
        }

        .bg-primary-dynamic:hover {
            background-color: var(--primary-color-hover) !important;
        }

        .bg-primary-light-dynamic:hover {
            background-color: var(--primary-color-light-hover) !important;
        }

        .text-primary-dynamic:hover,
        .hover\:text-primary-dynamic:hover {
            color: var(--primary-color) !important;
        }

        .border-primary-dynamic:hover,
        .hover\:border-primary-dynamic:hover {
            border-color: var(--primary-color) !important;
        }

        /* Tailwind color overrides for dynamic colors */
        .bg-green-600 {
            background-color: var(--primary-color) !important;
        }

        .bg-green-500 {
            background-color: var(--primary-color-light) !important;
        }

        .hover\:bg-green-700:hover {
            background-color: var(--primary-color-hover) !important;
        }

        .text-green-600 {
            color: var(--primary-color) !important;
        }

        .text-green-500 {
            color: var(--primary-color-light) !important;
        }

        .hover\:text-green-700:hover {
            color: var(--primary-color-hover) !important;
        }

        .border-green-500 {
            border-color: var(--primary-color-light) !important;
        }

        .border-green-600 {
            border-color: var(--primary-color) !important;
        }

        .focus\:border-green-500:focus {
            border-color: var(--primary-color-light) !important;
        }

        .focus\:ring-green-100:focus {
            --tw-ring-color: var(--primary-color-light);
            opacity: 0.3;
        }

        /* Secondary color support */
        .bg-orange-500 {
            background-color: var(--secondary-color) !important;
        }

        .hover\:bg-orange-600:hover {
            background-color: var(--secondary-color) !important;
            opacity: 0.9;
        }

        /* Green-50 equivalent for light backgrounds */
        .bg-green-50,
        .hover\:bg-green-50:hover {
            background-color: color-mix(in srgb, var(--primary-color-light) 10%, white) !important;
        }

        /* Gradient backgrounds */
        .hero-gradient,
        .we-care-section {
            background: linear-gradient(135deg, var(--primary-color-light) 0%, var(--primary-color) 100%) !important;
        }

        /* Additional dynamic color utilities */
        [style*="#2d8659"],
        [style*="#1a5f3f"],
        [style*="#003315"] {
            /* These will be overridden by inline styles with CSS variables */
        }
    </style>

    {!! getSystemDynamicPartials(type: 'analytics_script') !!}
</head>

<body class="bg-white font-primary text-[#212529] antialiased">
    <div id="loading" class="fixed inset-0 z-50 flex hidden items-center justify-center bg-white bg-opacity-90">
        <div class="text-center">
            <img width="200" alt="Loading"
                src="{{ getStorageImages(path: getWebConfig(name: 'loader_gif'), type: 'source', source: file_exists(public_path('themes/greenmarket/assets/img/loader.gif')) ? asset('themes/greenmarket/assets/img/loader.gif') : dynamicAsset(path: 'public/assets/front-end/img/loader.gif')) }}">
        </div>
    </div>

    @include('web-views.layouts.partials._alert-message')
    @include('web-views.layouts.partials._header')

    <main>
        <div class="mx-auto">
            @yield('content')
        </div>
    </main>

    @include('web-views.layouts.partials._footer')

    <!-- Mobile Bottom Navigation Bar -->
    <div class="fixed bottom-0 left-0 right-0 z-50 block border-t border-gray-200 bg-white md:hidden"
        id="mobile_app_bar">
        @include('web-views.layouts.partials._app-bar')
    </div>

    <!-- Cart Sidebar -->
    @include('web-views.layouts.partials._cart-sidebar')

    <!-- Modals -->
    @include('web-views.layouts.partials.modal._quick-view')
    @include('web-views.layouts.partials.modal._buy-now')
    @include('web-views.layouts.partials.modal._checkout')

    <!-- WhatsApp Floating Button -->
    @php($whatsapp = getWebConfig(name: 'whatsapp'))
    @if (isset($whatsapp['status']) && $whatsapp['status'] == 1)
        <div class="fixed bottom-6 right-6 z-40">
            <a href="https://wa.me/{{ $whatsapp['phone'] }}?text=Hello%20there!" target="_blank"
                class="whatsapp-bg call-button-animate block flex h-12 w-12 items-center justify-center rounded-full shadow-lg">
                <i class="fa-solid fa-phone text-lg font-semibold text-white"></i>
            </a>
        </div>
    @endif

    <!-- Scroll to Top Button -->
    <button id="scroll-top"
        class="fixed bottom-24 right-6 z-40 flex hidden h-12 w-12 items-center justify-center rounded-full text-white shadow-lg transition-all hover:opacity-90"
        style="background-color: var(--primary-color);">
        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
        </svg>
    </button>

    <!-- Scripts -->
    <script src="{{ dynamicAsset(path: 'public/assets/front-end/vendor/jquery/dist/jquery-2.2.4.min.js') }}"></script>

    {{-- Include route data and translations BEFORE cart functions --}}
    @include('web-views.layouts.partials._translate-text-for-js')
    @include('web-views.layouts.partials._route-for-js')

    <!-- Slick Carousel JS -->
    @if (file_exists(public_path('themes/greenmarket/assets/js/slick.min.js')))
        <script type="text/javascript" src="{{ asset('themes/greenmarket/assets/js/slick.min.js') }}"></script>
    @else
        <!-- Fallback to CDN if local file not found -->
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    @endif

    {{-- Include cart functions script inline to ensure it always loads - must be after jQuery and route-data --}}
    <script src="{{ dynamicAsset(path: 'public/assets/backend/libs/intl-tel-input/js/intlTelInput.js') }}"></script>
    <script src="{{ dynamicAsset(path: 'public/assets/backend/libs/intl-tel-input/js/utils.js') }}"></script>
    <script src="{{ dynamicAsset(path: 'public/assets/backend/libs/intl-tel-input/js/intlTelInout-validation.js') }}">
    </script>

    @include('web-views.layouts._firebase-script')

    {!! Toastr::message() !!}

    @php($recaptcha = getWebConfig(name: 'recaptcha'))
    @if (isset($recaptcha) && $recaptcha['status'] == 1)
        <script src="https://www.google.com/recaptcha/api.js?render={{ $recaptcha['site_key'] }}"></script>
    @endif
    <script src="{{ dynamicAsset(path: 'public/assets/backend/libs/google-recaptcha/google-recaptcha-init.js') }}">
    </script>

    <script>
        // Scroll to top functionality
        window.addEventListener('scroll', function() {
            const scrollTop = document.getElementById('scroll-top');
            if (window.pageYOffset > 300) {
                scrollTop.classList.remove('hidden');
            } else {
                scrollTop.classList.add('hidden');
            }
        });

        document.getElementById('scroll-top')?.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    </script>

    <script>
        /**
         * Recently Viewed Products Functionality
         * Stores product IDs in cookies and retrieves them for display
         */

        // Cookie helper functions
        function setCookie(name, value, days) {
            const expires = new Date();
            expires.setTime(expires.getTime() + (days * 24 * 60 * 60 * 1000));
            document.cookie = name + '=' + value + ';expires=' + expires.toUTCString() + ';path=/';
        }

        function getCookie(name) {
            const nameEQ = name + '=';
            const ca = document.cookie.split(';');
            for (let i = 0; i < ca.length; i++) {
                let c = ca[i];
                while (c.charAt(0) === ' ') c = c.substring(1, c.length);
                if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length, c.length);
            }
            return null;
        }

        // Add product to recently viewed
        function addToRecentlyViewed(productId, productSlug, productName, productImage, productPrice) {
            if (!productId) return;

            const cookieName = 'greenmarket_recently_viewed';
            const maxItems = 10; // Maximum number of recently viewed items
            const cookieExpiryDays = 30; // Cookie expires in 30 days

            // Get existing recently viewed products
            let recentlyViewed = getCookie(cookieName);
            let products = [];

            if (recentlyViewed) {
                try {
                    products = JSON.parse(recentlyViewed);
                } catch (e) {
                    products = [];
                }
            }

            // Remove product if it already exists (to move it to the top)
            products = products.filter(p => p.id !== productId);

            // Add new product to the beginning
            products.unshift({
                id: productId,
                slug: productSlug,
                name: productName,
                image: productImage,
                price: productPrice,
                viewedAt: new Date().toISOString()
            });

            // Keep only the most recent items
            if (products.length > maxItems) {
                products = products.slice(0, maxItems);
            }

            // Save back to cookie
            setCookie(cookieName, JSON.stringify(products), cookieExpiryDays);
        }

        // Get recently viewed products
        function getRecentlyViewed() {
            const cookieName = 'greenmarket_recently_viewed';
            const recentlyViewed = getCookie(cookieName);

            if (!recentlyViewed) {
                return [];
            }

            try {
                return JSON.parse(recentlyViewed);
            } catch (e) {
                return [];
            }
        }

        // Load recently viewed products and display them
        function loadRecentlyViewedProducts() {
            const recentlyViewed = getRecentlyViewed();
            const container = $('#recently-viewed-container');

            if (!container.length) {
                return;
            }

            if (recentlyViewed.length === 0) {
                container.html('<div class="text-center py-8 text-gray-500">No recently viewed products</div>');
                // Hide slider navigation if no products
                $('.recently-prev, .recently-next').hide();
                return;
            }

            // Show slider navigation
            $('.recently-prev, .recently-next').show();

            // Render from cookie data (simpler approach)
            renderRecentlyViewedFromCookie(recentlyViewed);
        }

        // Render products from server data
        function renderRecentlyViewedProducts(products) {
            const container = $('#recently-viewed-container');
            let html = '';

            products.forEach(function(product) {
                html += generateProductCardHTML(product);
            });

            container.html(html);

            // Initialize slider if slick is available
            if (typeof $ !== 'undefined' && $.fn.slick) {
                if ($('.recently-viewed-slider').hasClass('slick-initialized')) {
                    $('.recently-viewed-slider').slick('unslick');
                }
                initializeRecentlyViewedSlider();
            }
        }

        // Render products from cookie data
        function renderRecentlyViewedFromCookie(recentlyViewed) {
            const container = $('#recently-viewed-container');
            let html = '';

            // Limit to 10 most recent items
            const itemsToShow = recentlyViewed.slice(0, 10);

            itemsToShow.forEach(function(item) {
                const productSlug = item.slug || '';
                const productName = item.name || 'Product';
                const productImage = item.image || 'https://placehold.co/400';
                const productPrice = item.price || '৳0';
                const productId = item.id || '';

                html += `
            <div class="bg-transparent rounded-lg shadow-md border-1 ml-2 mr-2 border-gray-50 overflow-hidden group flex flex-col h-full">
                <div class="relative p-8 flex-shrink-0" style="height: 256px;">
                    <a href="/product/${productSlug}" class="block h-full">
                        <img src="${productImage}" alt="${productName}" class="w-full h-full object-contain">
                    </a>
                </div>
                <div class="flex flex-shrink-0">
                    <a href="/product/${productSlug}" class="flex-1 py-3 flex items-center justify-center border-r hover:cursor-pointer border-gray-200 text-white text-sm font-medium transition-colors bg-primary-dynamic hover:opacity-90">
                        <span class="text-sm font-medium">এখনই দেখুন</span>
                    </a>
                    <button class="flex-1 py-3 flex items-center justify-center hover:cursor-pointer add-to-cart-btn text-white text-sm font-medium transition-colors hover:opacity-90" style="background-color: var(--secondary-color);" data-product-id="${productId}" data-product-slug="${productSlug}">
                        <span class="text-sm font-medium">কার্টে যোগ করুন</span>
                    </button>
                </div>
                <div class="p-4 flex-shrink-0 flex flex-col flex-grow">
                    <a href="/product/${productSlug}" class="flex-shrink-0">
                        <h3 class="text-sm font-bold text-[#222222] mb-2 line-clamp-2 min-h-[2.5rem]">${productName}</h3>
                    </a>
                    <div class="flex items-center gap-2 mt-auto">
                        <span class="text-2xl font-bold text-primary-dynamic">${productPrice}</span>
                    </div>
                </div>
            </div>
        `;
            });

            container.html(html);

            // Initialize slider if slick is available
            if (typeof $ !== 'undefined' && $.fn.slick) {
                setTimeout(function() {
                    if ($('.recently-viewed-slider').hasClass('slick-initialized')) {
                        $('.recently-viewed-slider').slick('unslick');
                    }
                    initializeRecentlyViewedSlider();
                }, 100);
            }
        }

        // Generate product card HTML
        function generateProductCardHTML(product) {
            const productSlug = product.slug || '';
            const productName = product.name || 'Product';
            const productImage = product.thumbnail_full_url ? getProductImageUrl(product.thumbnail_full_url) :
                'https://prd.place/400';
            const productPrice = product.discounted_price || product.unit_price || '৳0';
            const productDiscountPrice = product.discount > 0 ? product.unit_price : null;
            const productId = product.id;

            return `
        <div class="bg-transparent rounded-lg shadow-md border-1 border-gray-50 overflow-hidden group flex flex-col h-full">
            <div class="relative p-8 flex-shrink-0" style="height: 256px;">
                <a href="/product/${productSlug}" class="block h-full">
                    <img src="${productImage}" alt="${productName}" class="w-full h-full object-contain">
                </a>
            </div>
            <div class="flex flex-shrink-0">
                <a href="/product/${productSlug}" class="flex-1 py-3 flex items-center justify-center border-r hover:cursor-pointer border-gray-200 text-white text-sm font-medium transition-colors bg-primary-dynamic hover:opacity-90">
                    <span class="text-sm font-medium">এখনই দেখুন</span>
                </a>
                <button class="flex-1 py-3 flex items-center justify-center hover:cursor-pointer add-to-cart-btn text-white text-sm font-medium transition-colors hover:opacity-90" style="background-color: var(--secondary-color);" data-product-id="${productId}" data-product-slug="${productSlug}">
                    <span class="text-sm font-medium">কার্টে যোগ করুন</span>
                </button>
            </div>
            <div class="p-4 flex-shrink-0 flex flex-col flex-grow">
                <a href="/product/${productSlug}" class="flex-shrink-0">
                    <h3 class="text-sm font-bold text-[#222222] mb-2 line-clamp-2 min-h-[2.5rem]">${productName}</h3>
                </a>
                <div class="flex items-center gap-2 mt-auto">
                    <span class="text-2xl font-bold text-primary-dynamic">${productPrice}</span>
                    ${productDiscountPrice ? `<span class="text-medium text-[#afb4be] line-through">${productDiscountPrice}</span>` : ''}
                </div>
            </div>
        </div>
    `;
        }

        // Helper function to get product image URL
        function getProductImageUrl(path) {
            if (!path) return 'https://placehold.co/400';
            if (path.startsWith('http')) return path;
            return '/storage/app/public/product/thumbnail/' + path;
        }

        // Initialize recently viewed slider
        function initializeRecentlyViewedSlider() {
            if ($('.recently-viewed-slider').length && typeof $ !== 'undefined' && $.fn.slick) {
                $('.recently-viewed-slider').slick({
                    slidesToShow: 4,
                    slidesToScroll: 1,
                    infinite: true,
                    arrows: false,
                    dots: false,
                    responsive: [{
                        breakpoint: 992,
                        settings: {
                            slidesToShow: 3
                        }
                    }, {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 2
                        }
                    }, {
                        breakpoint: 576,
                        settings: {
                            slidesToShow: 1
                        }
                    }]
                });
            }
        }

        // Track product view on product details page
        $(document).ready(function() {
            // Check if we're on a product details page
            if ($('#product-details-page').length) {
                const productData = $('#product-details-page');
                const productId = productData.data('product-id');
                const productSlug = productData.data('product-slug');
                const productName = productData.data('product-name');
                const productImage = productData.data('product-image');
                const productPrice = productData.data('product-price');

                if (productId) {
                    addToRecentlyViewed(productId, productSlug, productName, productImage, productPrice);
                }
            }

            // Track product views when clicking on product links (eye icon or product card)
            $(document).on('click', 'a[href*="/product/"], a.quick-view-btn', function(e) {
                // Don't prevent default, let the link work normally
                const href = $(this).attr('href');
                if (!href) return;

                const productSlug = href.split('/product/').pop().split('?')[0];

                // Extract product ID from data attribute if available
                const productCard = $(this).closest('.bg-transparent.rounded-lg, .product-card');
                const productId = productCard.find('[data-product-id]').data('product-id') ||
                    $(this).data('product-id') ||
                    productCard.find('.add-to-cart-btn').data('product-id');

                if (productId) {
                    const productName = productCard.find('h3').text().trim() || $(this).closest(
                        '[class*="product"]').find('h3').text().trim();
                    const productImage = productCard.find('img').first().attr('src') || $(this).find('img')
                        .attr('src');
                    const productPrice = productCard.find('[class*="text-2xl"], .text-primary-dynamic')
                        .first().text().trim();

                    if (productId && productSlug) {
                        addToRecentlyViewed(productId, productSlug, productName, productImage,
                            productPrice);
                    }
                }
            });

            // Load recently viewed products on page load
            setTimeout(function() {
                loadRecentlyViewedProducts();
            }, 500);
        });
    </script>

    {{-- cart functions script --}}
    <script>
        /**
         * Dynamic Cart Functions for Greenmarket Theme
         */

        // Add to Cart Function
        function addToCartGreenmarket(productId, quantity = 1, variant = null) {
            if (typeof productId === 'undefined' || !productId) {
                console.error('Product ID is required');
                if (typeof toastr !== 'undefined') {
                    toastr.error('Product not found');
                }
                return;
            }

            const cartAddUrl = $('#route-data').data('route-cart-add');
            if (!cartAddUrl) {
                console.error('Cart add route not found');
                return;
            }

            const formData = {
                _token: $('meta[name="_token"]').attr('content'),
                id: productId,
                quantity: quantity
            };

            if (variant) {
                formData.variant = variant;
            }

            $.ajax({
                url: cartAddUrl,
                method: 'POST',
                data: formData,
                beforeSend: function() {
                    if ($('#loading').length) {
                        $('#loading').removeClass('hidden');
                    }
                },
                success: function(response) {
                    if ($('#loading').length) {
                        $('#loading').addClass('hidden');
                    }

                    if (response.status === 1) {
                        if (typeof toastr !== 'undefined') {
                            toastr.success(response.message || 'Product added to cart successfully');
                        }

                        // Update cart count
                        updateCartCountGreenmarket();

                        // Reload the page
                        window.location.reload();
                    } else {
                        if (typeof toastr !== 'undefined') {
                            toastr.error(response.message || 'Failed to add product to cart');
                        }
                    }
                },
                error: function(xhr) {
                    if ($('#loading').length) {
                        $('#loading').addClass('hidden');
                    }
                    const errorMessage = xhr.responseJSON?.message || 'Something went wrong';
                    if (typeof toastr !== 'undefined') {
                        toastr.error(errorMessage);
                    }
                }
            });
        }

        // Update Cart Count
        function updateCartCountGreenmarket() {
            const navCartUrl = $('#route-data').data('route-cart-nav') || '/cart/nav-cart-items';

            $.ajax({
                url: navCartUrl,
                method: 'POST',
                data: {
                    _token: $('meta[name="_token"]').attr('content')
                },
                success: function(response) {
                    if (response && response.data) {
                        // Parse the cart partial HTML to get cart count
                        const $cartHtml = $(response.data);
                        const cartCount = $cartHtml.find('.cart-count-badge').text() || '0';
                        const $headerBadge = $('.cart-count-badge');

                        // Update or create cart count badge in header
                        if (parseInt(cartCount) > 0) {
                            if ($headerBadge.length) {
                                $headerBadge.text(cartCount);
                                $headerBadge.attr('title', cartCount +
                                    ' {{ translate('items_in_cart') ?? 'items in cart' }}');
                            } else {
                                // Add badge if it doesn't exist
                                $('a[href*="shop-cart"]').append(
                                    '<span class="cart-count-badge absolute -top-2 left-3 flex h-5 w-5 items-center justify-center rounded-full bg-[#DC3545] text-xs font-bold text-white md:-top-3 md:left-4" title="' +
                                    cartCount + ' {{ translate('items_in_cart') ?? 'items in cart' }}">' +
                                    cartCount + '</span>');
                            }
                        } else {
                            // Remove badge if cart is empty
                            $headerBadge.remove();
                        }
                    }
                },
                error: function() {
                    console.error('Failed to update cart count');
                }
            });
        }

        // Load cart sidebar content dynamically
        function loadCartSidebarContent() {
            const navCartUrl = $('#route-data').data('route-cart-nav') || '/cart/nav-cart-items';

            $.ajax({
                url: navCartUrl,
                method: 'POST',
                data: {
                    _token: $('meta[name="_token"]').attr('content')
                },
                success: function(response) {
                    if (response && response.data) {
                        const $newContent = $(response.data);

                        // Update cart items container
                        if ($newContent.find('#cart-items-container').length) {
                            $('#cart-items-container').html($newContent.find('#cart-items-container').html());
                        }

                        // Update cart footer
                        const $newFooter = $newContent.find('.border-t.border-gray-200.bg-white.p-4.space-y-4');
                        const $currentFooter = $(
                            '#cart-sidebar .border-t.border-gray-200.bg-white.p-4.space-y-4');
                        if ($newFooter.length) {
                            if ($currentFooter.length) {
                                $currentFooter.replaceWith($newFooter);
                            } else {
                                $('#cart-sidebar .flex-1.overflow-y-auto').after($newFooter);
                            }
                        }

                        // Update cart count badge
                        const cartCount = $newContent.find('.cart-count-badge').text() || '0';
                        $('#cart-sidebar .cart-count-badge').text(cartCount);
                    }
                },
                error: function() {
                    console.error('Failed to load cart sidebar content');
                }
            });
        }

        // Initialize cart functions on document ready
        $(document).ready(function() {
            // Add to cart button click handler - handles both .add-to-cart-btn and .greenmarket-add-to-cart-btn
            $(document).on('click', '.add-to-cart-btn, .greenmarket-add-to-cart-btn', function(e) {
                e.preventDefault();
                e.stopPropagation();
                const productId = $(this).data('product-id');
                if (productId) {
                    addToCartGreenmarket(productId, 1);
                } else {
                    console.error('Product ID not found on add to cart button');
                    if (typeof toastr !== 'undefined') {
                        toastr.error('Product ID not found');
                    }
                }
                return false;
            });

            // Quick view button click handler
            $(document).on('click', '.quick-view-btn', function(e) {
                e.preventDefault();
                e.stopPropagation();
                const productId = $(this).data('product-id');
                if (productId && typeof quickView !== 'undefined') {
                    quickView(productId);
                }
                return false;
            });
        });
    </script>

    @stack('script')
</body>

</html>
