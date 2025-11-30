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
    
    <!-- Tailwind CSS -->
    @if(file_exists(public_path('themes/greenmarket/assets/css/tailwind.css')))
        <link rel="stylesheet" href="{{ asset('themes/greenmarket/assets/css/tailwind.css') }}">
    @else
        <!-- Fallback: Using Tailwind CDN if local file not found -->
        <script src="https://cdn.tailwindcss.com"></script>
    @endif
    
    <!-- Additional CSS -->
    @if(file_exists(public_path('themes/greenmarket/assets/css/custom.css')))
        <link rel="stylesheet" href="{{ asset('themes/greenmarket/assets/css/custom.css') }}">
    @endif
    <link rel="stylesheet" href="{{ dynamicAsset(path: 'public/assets/backend/libs/intl-tel-input/css/intlTelInput.css') }}">
    <link rel="stylesheet" href="{{ dynamicAsset(path: 'public/assets/backend/libs/google-recaptcha/google-recaptcha-init.css') }}">

    @stack('css_or_js')
    @include(VIEW_FILE_NAMES['robots_meta_content_partials'])
    <title>@yield('title')</title>

    <style>
        :root {
            --primary-color: {{ $web_config['primary_color'] }};
            --primary-rgb: {{ getHexToRGBColorCode($web_config['primary_color']) }};
            --secondary-color: {{ $web_config['secondary_color'] }};
            --secondary-rgb: {{ getHexToRGBColorCode($web_config['secondary_color']) }};
        }
    </style>

    {!! getSystemDynamicPartials(type: 'analytics_script') !!}
</head>
<body class="bg-gray-50">
    <div id="loading" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-white bg-opacity-90">
        <div class="text-center">
            <img width="200" alt="Loading" 
                 src="{{ getStorageImages(path: getWebConfig(name: 'loader_gif'), type: 'source', source: file_exists(public_path('themes/greenmarket/assets/img/loader.gif')) ? asset('themes/greenmarket/assets/img/loader.gif') : dynamicAsset(path: 'public/assets/front-end/img/loader.gif')) }}">
        </div>
    </div>

    @include('theme-views.layouts.partials._alert-message')
    @include('theme-views.layouts.partials._header')

    <main>
        @yield('content')
    </main>

    @include('theme-views.layouts.partials._footer')

    <!-- Modals -->
    @include('theme-views.layouts.partials.modal._quick-view')
    @include('theme-views.layouts.partials.modal._buy-now')

    <!-- WhatsApp Floating Button -->
    @php($whatsapp = getWebConfig(name: 'whatsapp'))
    @if(isset($whatsapp['status']) && $whatsapp['status'] == 1)
        <div class="fixed bottom-6 right-6 z-40">
            <a href="https://wa.me/{{ $whatsapp['phone'] }}?text=Hello%20there!" target="_blank" 
               class="block w-14 h-14 bg-green-500 rounded-full flex items-center justify-center shadow-lg hover:bg-green-600 transition-colors">
                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198-.05-.371-.223-.52-.173-.149-1.476-1.82-2.02-2.491-.543-.671-.362-.743.135-1.234.135-.149.298-.298.446-.446.149-.149.198-.248.298-.248.099 0 .173.05.248.174.074.124.347.644.52.868.173.223.298.372.521.62.223.248.372.298.62.149.248-.149 1.027-.644 1.975-1.05.948-.405 1.675-.3 1.95.15.273.446.173 1.275-.074 1.771"/>
                </svg>
            </a>
        </div>
    @endif

    <!-- Scroll to Top Button -->
    <button id="scroll-top" class="hidden fixed bottom-24 right-6 z-40 w-12 h-12 text-white rounded-full shadow-lg hover:opacity-90 transition-all flex items-center justify-center" style="background-color: var(--primary-color);">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
        </svg>
    </button>

    <!-- Scripts -->
    <script src="{{ dynamicAsset(path: 'public/assets/front-end/vendor/jquery/dist/jquery-2.2.4.min.js') }}"></script>
    @if(file_exists(public_path('themes/greenmarket/assets/js/main.js')))
        <script src="{{ asset('themes/greenmarket/assets/js/main.js') }}"></script>
    @endif
    <script src="{{ dynamicAsset(path: 'public/assets/backend/libs/intl-tel-input/js/intlTelInput.js') }}"></script>
    <script src="{{ dynamicAsset(path: 'public/assets/backend/libs/intl-tel-input/js/utils.js') }}"></script>
    <script src="{{ dynamicAsset(path: 'public/assets/backend/libs/intl-tel-input/js/intlTelInout-validation.js') }}"></script>

    @include('theme-views.layouts.partials._translate-text-for-js')
    @include('theme-views.layouts.partials._route-for-js')
    @include('theme-views.layouts._firebase-script')

    {!! Toastr::message() !!}

    @php($recaptcha = getWebConfig(name: 'recaptcha'))
    @if(isset($recaptcha) && $recaptcha['status'] == 1)
        <script src="https://www.google.com/recaptcha/api.js?render={{ $recaptcha['site_key'] }}"></script>
    @endif
    <script src="{{ dynamicAsset(path: 'public/assets/backend/libs/google-recaptcha/google-recaptcha-init.js') }}"></script>

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
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    </script>

    @stack('script')
</body>
</html>

