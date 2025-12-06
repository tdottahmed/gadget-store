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
                class="block flex h-12 w-12 items-center justify-center rounded-full whatsapp-bg shadow-lg">
                <i class="fa-brands fa-whatsapp text-xl text-white font-semibold"></i>
            </a>
        </div>
    @endif

    <!-- Scroll to Top Button -->
    <button id="scroll-top"
        class="fixed bottom-24 right-6 z-40 flex hidden h-12 w-12 items-center justify-center rounded-full text-white shadow-lg transition-all hover:opacity-90"
        style="background-color: #003315;">
        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
        </svg>
    </button>

    <!-- Scripts -->
    <script src="{{ dynamicAsset(path: 'public/assets/front-end/vendor/jquery/dist/jquery-2.2.4.min.js') }}"></script>
    <!-- Slick Carousel JS -->
    @if (file_exists(public_path('themes/greenmarket/assets/js/slick.min.js')))
        <script type="text/javascript" src="{{ asset('themes/greenmarket/assets/js/slick.min.js') }}"></script>
    @else
        <!-- Fallback to CDN if local file not found -->
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    @endif
    @if (file_exists(public_path('themes/greenmarket/assets/js/main.js')))
        <script src="{{ asset('themes/greenmarket/assets/js/main.js') }}"></script>
    @endif
    @if (file_exists(public_path('themes/greenmarket/assets/js/cart-functions.js')))
        <script src="{{ asset('themes/greenmarket/assets/js/cart-functions.js') }}"></script>
    @else
        <script src="{{ theme_asset('assets/js/cart-functions.js') }}"></script>
    @endif
    @if (file_exists(public_path('themes/greenmarket/assets/js/recently-viewed.js')))
        <script src="{{ asset('themes/greenmarket/assets/js/recently-viewed.js') }}"></script>
    @endif
    <script src="{{ dynamicAsset(path: 'public/assets/backend/libs/intl-tel-input/js/intlTelInput.js') }}"></script>
    <script src="{{ dynamicAsset(path: 'public/assets/backend/libs/intl-tel-input/js/utils.js') }}"></script>
    <script src="{{ dynamicAsset(path: 'public/assets/backend/libs/intl-tel-input/js/intlTelInout-validation.js') }}">
    </script>

    @include('web-views.layouts.partials._translate-text-for-js')
    @include('web-views.layouts.partials._route-for-js')
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

    @stack('script')
</body>

</html>
