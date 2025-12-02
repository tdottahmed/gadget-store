@extends('web-views.layouts.app')

@section('title', $web_config['company_name'] . ' ' . translate('Online_Shopping') . ' | ' . $web_config['company_name']
    . ' ' . translate('ecommerce'))

    @push('css_or_js')
        <meta property="og:image" content="{{ $web_config['web_logo']['path'] }}" />
        <meta property="og:title" content="Welcome To {{ $web_config['company_name'] }} Home" />
        <meta property="og:url" content="{{ env('APP_URL') }}">
        <meta property="og:description" content="{{ $web_config['meta_description'] }}">
        <meta name="description" content="{{ $web_config['meta_description'] }}">
        <meta property="twitter:card" content="{{ $web_config['web_logo']['path'] }}" />
        <meta property="twitter:title" content="Welcome To {{ $web_config['company_name'] }} Home" />
        <meta property="twitter:url" content="{{ env('APP_URL') }}">
        <meta property="twitter:description" content="{{ $web_config['meta_description'] }}">
    @endpush

@section('content')
    {{-- Hero Slider --}}
    {{-- @include(VIEW_FILE_NAMES['hero_slider']) --}}

    <!-- Hero Section -->
    <section class="relative overflow-hidden">
        <div class="hero-slider">
            <!-- Slide 1 -->
            <div>
                <img src="https://pub-b80211003304448e8a7f0edc480f0608.r2.dev/Web%20Slider%2002_KMG5yaqx6.webp"
                    alt="Slider image 1" class="w-full h-[300px] sm:h-[400px] md:h-[500px] lg:h-[580px] object-cover">
            </div>
            <!-- Slide 2 -->
            <div>
                <img src="https://pub-b80211003304448e8a7f0edc480f0608.r2.dev/Web%20Slider%2001_KMGsqf98.webp"
                    alt="Slider image 2" class="w-full h-[300px] sm:h-[400px] md:h-[500px] lg:h-[580px] object-cover">
            </div>
        </div>
    </section>

    <!-- Category Bar -->
    <section class="bg-primary-light py-3">
        <div class="container-ds">
            <div class="category-slider">
                <div>
                    <a href="#"
                        class="flex flex-col items-center gap-2 text-[#052E16] hover:text-[#389e63] hover:scale-110 transition-transform group">
                        <div
                            class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center group-hover:bg-white/30 transition-colors">
                            <i class="fas fa-leaf text-xl"></i>
                        </div>
                        <span class="text-lg font-bold">Organic</span>
                    </a>
                </div>
                <div>
                    <a href="#"
                        class="flex flex-col items-center gap-2 text-[#052e16] hover:text-[#389e63] hover:scale-110 transition-transform group">
                        <div
                            class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center group-hover:bg-white/30 transition-colors">
                            <i class="fas fa-apple-alt text-xl"></i>
                        </div>
                        <span class="text-lg font-bold">Healthy Food</span>
                    </a>
                </div>
                <div>
                    <a href="#"
                        class="flex flex-col items-center gap-2 text-[#052e16] hover:text-[#389e63] hover:scale-110 transition-transform group">
                        <div
                            class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center group-hover:bg-white/30 transition-colors">
                            <i class="fas fa-spa text-xl"></i>
                        </div>
                        <span class="text-lg font-bold">Wellness</span>
                    </a>
                </div>
                <div>
                    <a href="#"
                        class="flex flex-col items-center gap-2 text-[#052e16] hover:text-[#389e63] hover:scale-110 transition-transform group">
                        <div
                            class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center group-hover:bg-white/30 transition-colors">
                            <i class="fas fa-th-large text-xl"></i>
                        </div>
                        <span class="text-lg font-bold">All</span>
                    </a>
                </div>
                <div>
                    <a href="#"
                        class="flex flex-col items-center gap-2 text-[#052e16] hover:text-[#389e63] hover:scale-110 transition-transform group">
                        <div
                            class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center group-hover:bg-white/30 transition-colors">
                            <i class="fas fa-palette text-xl"></i>
                        </div>
                        <span class="text-lg font-bold">Cosmetics</span>
                    </a>
                </div>
                <div>
                    <a href="#"
                        class="flex flex-col items-center gap-2 text-[#052e16] hover:text-[#389e63] hover:scale-110 transition-transform group">
                        <div
                            class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center group-hover:bg-white/30 transition-colors">
                            <i class="fas fa-credit-card text-xl"></i>
                        </div>
                        <span class="text-lg font-bold">Card</span>
                    </a>
                </div>
                <div>
                    <a href="#"
                        class="flex flex-col items-center gap-2 text-[#052e16] hover:text-[#389e63] hover:scale-110 transition-transform group">
                        <div
                            class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center group-hover:bg-white/30 transition-colors">
                            <i class="fas fa-gift text-xl"></i>
                        </div>
                        <span class="text-lg font-bold">Gifts</span>
                    </a>
                </div>
                <div>
                    <a href="#"
                        class="flex flex-col items-center gap-2 text-[#052e16] hover:text-[#389e63] hover:scale-110 transition-transform group">
                        <div
                            class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center group-hover:bg-white/30 transition-colors">
                            <i class="fas fa-leaf text-xl"></i>
                        </div>
                        <span class="text-lg font-bold">Herbs</span>
                    </a>
                </div>
                <div>
                    <a href="#"
                        class="flex flex-col items-center gap-2 text-[#052e16] hover:text-[#389e63] hover:scale-110 transition-transform group">
                        <div
                            class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center group-hover:bg-white/30 transition-colors">
                            <i class="fas fa-leaf text-xl"></i>
                        </div>
                        <span class="text-lg font-bold">Herbs</span>
                    </a>
                </div>
                <div>
                    <a href="#"
                        class="flex flex-col items-center gap-2 text-[#052e16] hover:text-[#389e63] hover:scale-110 transition-transform group">
                        <div
                            class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center group-hover:bg-white/30 transition-colors">
                            <i class="fas fa-leaf text-xl"></i>
                        </div>
                        <span class="text-lg font-bold">Herbs</span>
                    </a>
                </div>
                <div>
                    <a href="#"
                        class="flex flex-col items-center gap-2 text-[#052e16] hover:text-[#389e63] hover:scale-110 transition-transform group">
                        <div
                            class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center group-hover:bg-white/30 transition-colors">
                            <i class="fas fa-leaf text-xl"></i>
                        </div>
                        <span class="text-lg font-bold">Herbs</span>
                    </a>
                </div>
                <div>
                    <a href="#"
                        class="flex flex-col items-center gap-2 text-[#052e16] hover:text-[#389e63] hover:scale-110 transition-transform group">
                        <div
                            class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center group-hover:bg-white/30 transition-colors">
                            <i class="fas fa-leaf text-xl"></i>
                        </div>
                        <span class="text-lg font-bold">Herbs</span>
                    </a>
                </div>
                <div>
                    <a href="#"
                        class="flex flex-col items-center gap-2 text-[#052e16] hover:text-[#389e63] hover:scale-110 transition-transform group">
                        <div
                            class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center group-hover:bg-white/30 transition-colors">
                            <i class="fas fa-leaf text-xl"></i>
                        </div>
                        <span class="text-lg font-bold">Herbs</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Our Best Sellers Section -->
    <section class="py-5 bg-white">
        <div class="container-ds">
            <h2 class="text-3xl font-bold text-[#212529] mb-8 uppercase tracking-wider">OUR BEST SELLERS</h2>
            <div class="bestsellers-slider product-slider">
                <!-- Product Card -->
                <div class="bg-transparent rounded-lg shadow-md border-1 border-gray-50 overflow-hidden group">
                    <div class="relativ p-8">
                        <a href="#">
                            <img src="https://prd.place/400" alt="Spray Dried Beetroot Powder"
                                class="w-full h-64 object-contain">
                        </a>
                    </div>
                    <div class="bg-[#F2F2F2] flex">
                        <button
                            class="flex-1 py-3 flex items-center justify-center border-r hover:cursor-pointer border-gray-200">
                            <i class="fa-regular fa-eye"></i>
                        </button>
                        <button class="flex-1 py-3 flex items-center justify-center hover:cursor-pointer">
                            <i class="fas fa-shopping-cart text-lg md:text-xl"></i>
                        </button>
                    </div>
                    <div class="p-4">
                        <a href="#">
                            <h3 class="text-sm font-bold text-[#222222] mb-2 line-clamp-2">স্প্রে ড্রাইড বিটরুট পাউডার |
                                Spray
                                Dried Beetroot Powder</h3>
                        </a>
                        <div class="flex items-center gap-2">
                            <span class="text-2xl font-bold text-[#669900]">৳1,050</span>
                            <span class="text-medium text-[#afb4be] line-through">৳1,550</span>
                        </div>
                    </div>
                </div>

                <!-- Product Card -->
                <div class="bg-transparent rounded-lg shadow-md border-1 border-gray-50 overflow-hidden group">
                    <div class="relativ p-8">
                        <a href="#">
                            <img src="https://prd.place/400" alt="Spray Dried Beetroot Powder"
                                class="w-full h-64 object-contain">
                        </a>
                    </div>
                    <div class="bg-[#F2F2F2] flex">
                        <button
                            class="flex-1 py-3 flex items-center justify-center border-r hover:cursor-pointer border-gray-200">
                            <i class="fa-regular fa-eye"></i>
                        </button>
                        <button class="flex-1 py-3 flex items-center justify-center hover:cursor-pointer">
                            <i class="fas fa-shopping-cart text-lg md:text-xl"></i>
                        </button>
                    </div>
                    <div class="p-4">
                        <a href="#">
                            <h3 class="text-sm font-bold text-[#222222] mb-2 line-clamp-2">স্প্রে ড্রাইড বিটরুট পাউডার |
                                Spray
                                Dried Beetroot Powder</h3>
                        </a>
                        <div class="flex items-center gap-2">
                            <span class="text-2xl font-bold text-[#669900]">৳1,050</span>
                            <span class="text-medium text-[#afb4be] line-through">৳1,550</span>
                        </div>
                    </div>
                </div>

                <!-- Product Card -->
                <div class="bg-transparent rounded-lg shadow-md border-1 border-gray-50 overflow-hidden group">
                    <div class="relativ p-8">
                        <a href="#">
                            <img src="https://prd.place/400" alt="Spray Dried Beetroot Powder"
                                class="w-full h-64 object-contain">
                        </a>
                    </div>
                    <div class="bg-[#F2F2F2] flex">
                        <button
                            class="flex-1 py-3 flex items-center justify-center border-r hover:cursor-pointer border-gray-200">
                            <i class="fa-regular fa-eye"></i>
                        </button>
                        <button class="flex-1 py-3 flex items-center justify-center hover:cursor-pointer">
                            <i class="fas fa-shopping-cart text-lg md:text-xl"></i>
                        </button>
                    </div>
                    <div class="p-4">
                        <a href="#">
                            <h3 class="text-sm font-bold text-[#222222] mb-2 line-clamp-2">স্প্রে ড্রাইড বিটরুট পাউডার |
                                Spray
                                Dried Beetroot Powder</h3>
                        </a>
                        <div class="flex items-center gap-2">
                            <span class="text-2xl font-bold text-[#669900]">৳1,050</span>
                            <span class="text-medium text-[#afb4be] line-through">৳1,550</span>
                        </div>
                    </div>
                </div>

                <!-- Product Card -->
                <div class="bg-transparent rounded-lg shadow-md border-1 border-gray-50 overflow-hidden group">
                    <div class="relativ p-8">
                        <a href="#">
                            <img src="https://prd.place/400" alt="Spray Dried Beetroot Powder"
                                class="w-full h-64 object-contain">
                        </a>
                    </div>
                    <div class="bg-[#F2F2F2] flex">
                        <button
                            class="flex-1 py-3 flex items-center justify-center border-r hover:cursor-pointer border-gray-200">
                            <i class="fa-regular fa-eye"></i>
                        </button>
                        <button class="flex-1 py-3 flex items-center justify-center hover:cursor-pointer">
                            <i class="fas fa-shopping-cart text-lg md:text-xl"></i>
                        </button>
                    </div>
                    <div class="p-4">
                        <a href="#">
                            <h3 class="text-sm font-bold text-[#222222] mb-2 line-clamp-2">স্প্রে ড্রাইড বিটরুট পাউডার |
                                Spray
                                Dried Beetroot Powder</h3>
                        </a>
                        <div class="flex items-center gap-2">
                            <span class="text-2xl font-bold text-[#669900]">৳1,050</span>
                            <span class="text-medium text-[#afb4be] line-through">৳1,550</span>
                        </div>
                    </div>
                </div>

                <!-- Product Card -->
                <div class="bg-transparent rounded-lg shadow-md border-1 border-gray-50 overflow-hidden group">
                    <div class="relativ p-8">
                        <a href="#">
                            <img src="https://prd.place/400" alt="Spray Dried Beetroot Powder"
                                class="w-full h-64 object-contain">
                        </a>
                    </div>
                    <div class="bg-[#F2F2F2] flex">
                        <button
                            class="flex-1 py-3 flex items-center justify-center border-r hover:cursor-pointer border-gray-200">
                            <i class="fa-regular fa-eye"></i>
                        </button>
                        <button class="flex-1 py-3 flex items-center justify-center hover:cursor-pointer">
                            <i class="fas fa-shopping-cart text-lg md:text-xl"></i>
                        </button>
                    </div>
                    <div class="p-4">
                        <a href="#">
                            <h3 class="text-sm font-bold text-[#222222] mb-2 line-clamp-2">স্প্রে ড্রাইড বিটরুট পাউডার |
                                Spray
                                Dried Beetroot Powder</h3>
                        </a>
                        <div class="flex items-center gap-2">
                            <span class="text-2xl font-bold text-[#669900]">৳1,050</span>
                            <span class="text-medium text-[#afb4be] line-through">৳1,550</span>
                        </div>
                    </div>
                </div>

                <!-- Product Card -->
                <div class="bg-transparent rounded-lg shadow-md border-1 border-gray-50 overflow-hidden group">
                    <div class="relativ p-8">
                        <a href="#">
                            <img src="https://prd.place/400" alt="Spray Dried Beetroot Powder"
                                class="w-full h-64 object-contain">
                        </a>
                    </div>
                    <div class="bg-[#F2F2F2] flex">
                        <button
                            class="flex-1 py-3 flex items-center justify-center border-r hover:cursor-pointer border-gray-200">
                            <i class="fa-regular fa-eye"></i>
                        </button>
                        <button class="flex-1 py-3 flex items-center justify-center hover:cursor-pointer">
                            <i class="fas fa-shopping-cart text-lg md:text-xl"></i>
                        </button>
                    </div>
                    <div class="p-4">
                        <a href="#">
                            <h3 class="text-sm font-bold text-[#222222] mb-2 line-clamp-2">স্প্রে ড্রাইড বিটরুট পাউডার |
                                Spray
                                Dried Beetroot Powder</h3>
                        </a>
                        <div class="flex items-center gap-2">
                            <span class="text-2xl font-bold text-[#669900]">৳1,050</span>
                            <span class="text-medium text-[#afb4be] line-through">৳1,550</span>
                        </div>
                    </div>
                </div>

                <!-- Product Card -->
                <div class="bg-transparent rounded-lg shadow-md border-1 border-gray-50 overflow-hidden group">
                    <div class="relativ p-8">
                        <a href="#">
                            <img src="https://prd.place/400" alt="Spray Dried Beetroot Powder"
                                class="w-full h-64 object-contain">
                        </a>
                    </div>
                    <div class="bg-[#F2F2F2] flex">
                        <button
                            class="flex-1 py-3 flex items-center justify-center border-r hover:cursor-pointer border-gray-200">
                            <i class="fa-regular fa-eye"></i>
                        </button>
                        <button class="flex-1 py-3 flex items-center justify-center hover:cursor-pointer">
                            <i class="fas fa-shopping-cart text-lg md:text-xl"></i>
                        </button>
                    </div>
                    <div class="p-4">
                        <a href="#">
                            <h3 class="text-sm font-bold text-[#222222] mb-2 line-clamp-2">স্প্রে ড্রাইড বিটরুট পাউডার |
                                Spray
                                Dried Beetroot Powder</h3>
                        </a>
                        <div class="flex items-center gap-2">
                            <span class="text-2xl font-bold text-[#669900]">৳1,050</span>
                            <span class="text-medium text-[#afb4be] line-through">৳1,550</span>
                        </div>
                    </div>
                </div>

                <!-- Product Card -->
                <div class="bg-transparent rounded-lg shadow-md border-1 border-gray-50 overflow-hidden group">
                    <div class="relativ p-8">
                        <a href="#">
                            <img src="https://prd.place/400" alt="Spray Dried Beetroot Powder"
                                class="w-full h-64 object-contain">
                        </a>
                    </div>
                    <div class="bg-[#F2F2F2] flex">
                        <button
                            class="flex-1 py-3 flex items-center justify-center border-r hover:cursor-pointer border-gray-200">
                            <i class="fa-regular fa-eye"></i>
                        </button>
                        <button class="flex-1 py-3 flex items-center justify-center hover:cursor-pointer">
                            <i class="fas fa-shopping-cart text-lg md:text-xl"></i>
                        </button>
                    </div>
                    <div class="p-4">
                        <a href="#">
                            <h3 class="text-sm font-bold text-[#222222] mb-2 line-clamp-2">স্প্রে ড্রাইড বিটরুট পাউডার |
                                Spray
                                Dried Beetroot Powder</h3>
                        </a>
                        <div class="flex items-center gap-2">
                            <span class="text-2xl font-bold text-[#669900]">৳1,050</span>
                            <span class="text-medium text-[#afb4be] line-through">৳1,550</span>
                        </div>
                    </div>
                </div>

                <!-- Product Card -->
                <div class="bg-transparent rounded-lg shadow-md border-1 border-gray-50 overflow-hidden group">
                    <div class="relativ p-8">
                        <a href="#">
                            <img src="https://prd.place/400" alt="Spray Dried Beetroot Powder"
                                class="w-full h-64 object-contain">
                        </a>
                    </div>
                    <div class="bg-[#F2F2F2] flex">
                        <button
                            class="flex-1 py-3 flex items-center justify-center border-r hover:cursor-pointer border-gray-200">
                            <i class="fa-regular fa-eye"></i>
                        </button>
                        <button class="flex-1 py-3 flex items-center justify-center hover:cursor-pointer">
                            <i class="fas fa-shopping-cart text-lg md:text-xl"></i>
                        </button>
                    </div>
                    <div class="p-4">
                        <a href="#">
                            <h3 class="text-sm font-bold text-[#222222] mb-2 line-clamp-2">স্প্রে ড্রাইড বিটরুট পাউডার |
                                Spray
                                Dried Beetroot Powder</h3>
                        </a>
                        <div class="flex items-center gap-2">
                            <span class="text-2xl font-bold text-[#669900]">৳1,050</span>
                            <span class="text-medium text-[#afb4be] line-through">৳1,550</span>
                        </div>
                    </div>
                </div>

                <!-- Product Card -->
                <div class="bg-transparent rounded-lg shadow-md border-1 border-gray-50 overflow-hidden group">
                    <div class="relativ p-8">
                        <a href="#">
                            <img src="https://prd.place/400" alt="Spray Dried Beetroot Powder"
                                class="w-full h-64 object-contain">
                        </a>
                    </div>
                    <div class="bg-[#F2F2F2] flex">
                        <button
                            class="flex-1 py-3 flex items-center justify-center border-r hover:cursor-pointer border-gray-200">
                            <i class="fa-regular fa-eye"></i>
                        </button>
                        <button class="flex-1 py-3 flex items-center justify-center hover:cursor-pointer">
                            <i class="fas fa-shopping-cart text-lg md:text-xl"></i>
                        </button>
                    </div>
                    <div class="p-4">
                        <a href="#">
                            <h3 class="text-sm font-bold text-[#222222] mb-2 line-clamp-2">স্প্রে ড্রাইড বিটরুট পাউডার |
                                Spray
                                Dried Beetroot Powder</h3>
                        </a>
                        <div class="flex items-center gap-2">
                            <span class="text-2xl font-bold text-[#669900]">৳1,050</span>
                            <span class="text-medium text-[#afb4be] line-through">৳1,550</span>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </section>

    <!-- Honey Section -->
    <section class="py-12 bg-neutral-off-white">
        <div class="container-ds">
            <h2 class="text-3xl font-bold text-[#212529] mb-8 uppercase tracking-wider">Honey</h2>
            <div class="honey-slider product-slider">
                <!-- Product Card -->
                <div class="bg-transparent rounded-lg shadow-md border-1 border-gray-50 overflow-hidden group">
                    <div class="relativ p-8">
                        <a href="#">
                            <img src="https://prd.place/400" alt="Spray Dried Beetroot Powder"
                                class="w-full h-64 object-contain">
                        </a>
                    </div>
                    <div class="bg-[#F2F2F2] flex">
                        <button
                            class="flex-1 py-3 flex items-center justify-center border-r hover:cursor-pointer border-gray-200">
                            <i class="fa-regular fa-eye"></i>
                        </button>
                        <button class="flex-1 py-3 flex items-center justify-center hover:cursor-pointer">
                            <i class="fas fa-shopping-cart text-lg md:text-xl"></i>
                        </button>
                    </div>
                    <div class="p-4">
                        <a href="#">
                            <h3 class="text-sm font-bold text-[#222222] mb-2 line-clamp-2">স্প্রে ড্রাইড বিটরুট পাউডার |
                                Spray
                                Dried Beetroot Powder</h3>
                        </a>
                        <div class="flex items-center gap-2">
                            <span class="text-2xl font-bold text-[#669900]">৳1,050</span>
                            <span class="text-medium text-[#afb4be] line-through">৳1,550</span>
                        </div>
                    </div>
                </div>

                <!-- Product Card -->
                <div class="bg-transparent rounded-lg shadow-md border-1 border-gray-50 overflow-hidden group">
                    <div class="relativ p-8">
                        <a href="#">
                            <img src="https://prd.place/400" alt="Spray Dried Beetroot Powder"
                                class="w-full h-64 object-contain">
                        </a>
                    </div>
                    <div class="bg-[#F2F2F2] flex">
                        <button
                            class="flex-1 py-3 flex items-center justify-center border-r hover:cursor-pointer border-gray-200">
                            <i class="fa-regular fa-eye"></i>
                        </button>
                        <button class="flex-1 py-3 flex items-center justify-center hover:cursor-pointer">
                            <i class="fas fa-shopping-cart text-lg md:text-xl"></i>
                        </button>
                    </div>
                    <div class="p-4">
                        <a href="#">
                            <h3 class="text-sm font-bold text-[#222222] mb-2 line-clamp-2">স্প্রে ড্রাইড বিটরুট পাউডার |
                                Spray
                                Dried Beetroot Powder</h3>
                        </a>
                        <div class="flex items-center gap-2">
                            <span class="text-2xl font-bold text-[#669900]">৳1,050</span>
                            <span class="text-medium text-[#afb4be] line-through">৳1,550</span>
                        </div>
                    </div>
                </div>

                <!-- Product Card -->
                <div class="bg-transparent rounded-lg shadow-md border-1 border-gray-50 overflow-hidden group">
                    <div class="relativ p-8">
                        <a href="#">
                            <img src="https://prd.place/400" alt="Spray Dried Beetroot Powder"
                                class="w-full h-64 object-contain">
                        </a>
                    </div>
                    <div class="bg-[#F2F2F2] flex">
                        <button
                            class="flex-1 py-3 flex items-center justify-center border-r hover:cursor-pointer border-gray-200">
                            <i class="fa-regular fa-eye"></i>
                        </button>
                        <button class="flex-1 py-3 flex items-center justify-center hover:cursor-pointer">
                            <i class="fas fa-shopping-cart text-lg md:text-xl"></i>
                        </button>
                    </div>
                    <div class="p-4">
                        <a href="#">
                            <h3 class="text-sm font-bold text-[#222222] mb-2 line-clamp-2">স্প্রে ড্রাইড বিটরুট পাউডার |
                                Spray
                                Dried Beetroot Powder</h3>
                        </a>
                        <div class="flex items-center gap-2">
                            <span class="text-2xl font-bold text-[#669900]">৳1,050</span>
                            <span class="text-medium text-[#afb4be] line-through">৳1,550</span>
                        </div>
                    </div>
                </div>

                <!-- Product Card -->
                <div class="bg-transparent rounded-lg shadow-md border-1 border-gray-50 overflow-hidden group">
                    <div class="relativ p-8">
                        <a href="#">
                            <img src="https://prd.place/400" alt="Spray Dried Beetroot Powder"
                                class="w-full h-64 object-contain">
                        </a>
                    </div>
                    <div class="bg-[#F2F2F2] flex">
                        <button
                            class="flex-1 py-3 flex items-center justify-center border-r hover:cursor-pointer border-gray-200">
                            <i class="fa-regular fa-eye"></i>
                        </button>
                        <button class="flex-1 py-3 flex items-center justify-center hover:cursor-pointer">
                            <i class="fas fa-shopping-cart text-lg md:text-xl"></i>
                        </button>
                    </div>
                    <div class="p-4">
                        <a href="#">
                            <h3 class="text-sm font-bold text-[#222222] mb-2 line-clamp-2">স্প্রে ড্রাইড বিটরুট পাউডার |
                                Spray
                                Dried Beetroot Powder</h3>
                        </a>
                        <div class="flex items-center gap-2">
                            <span class="text-2xl font-bold text-[#669900]">৳1,050</span>
                            <span class="text-medium text-[#afb4be] line-through">৳1,550</span>
                        </div>
                    </div>
                </div>

                <!-- Product Card -->
                <div class="bg-transparent rounded-lg shadow-md border-1 border-gray-50 overflow-hidden group">
                    <div class="relativ p-8">
                        <a href="#">
                            <img src="https://prd.place/400" alt="Spray Dried Beetroot Powder"
                                class="w-full h-64 object-contain">
                        </a>
                    </div>
                    <div class="bg-[#F2F2F2] flex">
                        <button
                            class="flex-1 py-3 flex items-center justify-center border-r hover:cursor-pointer border-gray-200">
                            <i class="fa-regular fa-eye"></i>
                        </button>
                        <button class="flex-1 py-3 flex items-center justify-center hover:cursor-pointer">
                            <i class="fas fa-shopping-cart text-lg md:text-xl"></i>
                        </button>
                    </div>
                    <div class="p-4">
                        <a href="#">
                            <h3 class="text-sm font-bold text-[#222222] mb-2 line-clamp-2">স্প্রে ড্রাইড বিটরুট পাউডার |
                                Spray
                                Dried Beetroot Powder</h3>
                        </a>
                        <div class="flex items-center gap-2">
                            <span class="text-2xl font-bold text-[#669900]">৳1,050</span>
                            <span class="text-medium text-[#afb4be] line-through">৳1,550</span>
                        </div>
                    </div>
                </div>

                <!-- Product Card -->
                <div class="bg-transparent rounded-lg shadow-md border-1 border-gray-50 overflow-hidden group">
                    <div class="relativ p-8">
                        <a href="#">
                            <img src="https://prd.place/400" alt="Spray Dried Beetroot Powder"
                                class="w-full h-64 object-contain">
                        </a>
                    </div>
                    <div class="bg-[#F2F2F2] flex">
                        <button
                            class="flex-1 py-3 flex items-center justify-center border-r hover:cursor-pointer border-gray-200">
                            <i class="fa-regular fa-eye"></i>
                        </button>
                        <button class="flex-1 py-3 flex items-center justify-center hover:cursor-pointer">
                            <i class="fas fa-shopping-cart text-lg md:text-xl"></i>
                        </button>
                    </div>
                    <div class="p-4">
                        <a href="#">
                            <h3 class="text-sm font-bold text-[#222222] mb-2 line-clamp-2">স্প্রে ড্রাইড বিটরুট পাউডার |
                                Spray
                                Dried Beetroot Powder</h3>
                        </a>
                        <div class="flex items-center gap-2">
                            <span class="text-2xl font-bold text-[#669900]">৳1,050</span>
                            <span class="text-medium text-[#afb4be] line-through">৳1,550</span>
                        </div>
                    </div>
                </div>

                <!-- Product Card -->
                <div class="bg-transparent rounded-lg shadow-md border-1 border-gray-50 overflow-hidden group">
                    <div class="relativ p-8">
                        <a href="#">
                            <img src="https://prd.place/400" alt="Spray Dried Beetroot Powder"
                                class="w-full h-64 object-contain">
                        </a>
                    </div>
                    <div class="bg-[#F2F2F2] flex">
                        <button
                            class="flex-1 py-3 flex items-center justify-center border-r hover:cursor-pointer border-gray-200">
                            <i class="fa-regular fa-eye"></i>
                        </button>
                        <button class="flex-1 py-3 flex items-center justify-center hover:cursor-pointer">
                            <i class="fas fa-shopping-cart text-lg md:text-xl"></i>
                        </button>
                    </div>
                    <div class="p-4">
                        <a href="#">
                            <h3 class="text-sm font-bold text-[#222222] mb-2 line-clamp-2">স্প্রে ড্রাইড বিটরুট পাউডার |
                                Spray
                                Dried Beetroot Powder</h3>
                        </a>
                        <div class="flex items-center gap-2">
                            <span class="text-2xl font-bold text-[#669900]">৳1,050</span>
                            <span class="text-medium text-[#afb4be] line-through">৳1,550</span>
                        </div>
                    </div>
                </div>

                <!-- Product Card -->
                <div class="bg-transparent rounded-lg shadow-md border-1 border-gray-50 overflow-hidden group">
                    <div class="relativ p-8">
                        <a href="#">
                            <img src="https://prd.place/400" alt="Spray Dried Beetroot Powder"
                                class="w-full h-64 object-contain">
                        </a>
                    </div>
                    <div class="bg-[#F2F2F2] flex">
                        <button
                            class="flex-1 py-3 flex items-center justify-center border-r hover:cursor-pointer border-gray-200">
                            <i class="fa-regular fa-eye"></i>
                        </button>
                        <button class="flex-1 py-3 flex items-center justify-center hover:cursor-pointer">
                            <i class="fas fa-shopping-cart text-lg md:text-xl"></i>
                        </button>
                    </div>
                    <div class="p-4">
                        <a href="#">
                            <h3 class="text-sm font-bold text-[#222222] mb-2 line-clamp-2">স্প্রে ড্রাইড বিটরুট পাউডার |
                                Spray
                                Dried Beetroot Powder</h3>
                        </a>
                        <div class="flex items-center gap-2">
                            <span class="text-2xl font-bold text-[#669900]">৳1,050</span>
                            <span class="text-medium text-[#afb4be] line-through">৳1,550</span>
                        </div>
                    </div>
                </div>

                <!-- Product Card -->
                <div class="bg-transparent rounded-lg shadow-md border-1 border-gray-50 overflow-hidden group">
                    <div class="relativ p-8">
                        <a href="#">
                            <img src="https://prd.place/400" alt="Spray Dried Beetroot Powder"
                                class="w-full h-64 object-contain">
                        </a>
                    </div>
                    <div class="bg-[#F2F2F2] flex">
                        <button
                            class="flex-1 py-3 flex items-center justify-center border-r hover:cursor-pointer border-gray-200">
                            <i class="fa-regular fa-eye"></i>
                        </button>
                        <button class="flex-1 py-3 flex items-center justify-center hover:cursor-pointer">
                            <i class="fas fa-shopping-cart text-lg md:text-xl"></i>
                        </button>
                    </div>
                    <div class="p-4">
                        <a href="#">
                            <h3 class="text-sm font-bold text-[#222222] mb-2 line-clamp-2">স্প্রে ড্রাইড বিটরুট পাউডার |
                                Spray
                                Dried Beetroot Powder</h3>
                        </a>
                        <div class="flex items-center gap-2">
                            <span class="text-2xl font-bold text-[#669900]">৳1,050</span>
                            <span class="text-medium text-[#afb4be] line-through">৳1,550</span>
                        </div>
                    </div>
                </div>

                <!-- Product Card -->
                <div class="bg-transparent rounded-lg shadow-md border-1 border-gray-50 overflow-hidden group">
                    <div class="relativ p-8">
                        <a href="#">
                            <img src="https://prd.place/400" alt="Spray Dried Beetroot Powder"
                                class="w-full h-64 object-contain">
                        </a>
                    </div>
                    <div class="bg-[#F2F2F2] flex">
                        <button
                            class="flex-1 py-3 flex items-center justify-center border-r hover:cursor-pointer border-gray-200">
                            <i class="fa-regular fa-eye"></i>
                        </button>
                        <button class="flex-1 py-3 flex items-center justify-center hover:cursor-pointer">
                            <i class="fas fa-shopping-cart text-lg md:text-xl"></i>
                        </button>
                    </div>
                    <div class="p-4">
                        <a href="#">
                            <h3 class="text-sm font-bold text-[#222222] mb-2 line-clamp-2">স্প্রে ড্রাইড বিটরুট পাউডার |
                                Spray
                                Dried Beetroot Powder</h3>
                        </a>
                        <div class="flex items-center gap-2">
                            <span class="text-2xl font-bold text-[#669900]">৳1,050</span>
                            <span class="text-medium text-[#afb4be] line-through">৳1,550</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Wellness Section -->
    <section class="py-12 bg-white">
        <div class="container-ds">
            <h2 class="text-3xl font-bold text-[#212529] mb-8 uppercase tracking-wider">Wellness</h2>
            <div class="wellness-slider product-slider">
                <!-- Product Card -->
                <div class="bg-transparent rounded-lg shadow-md border-1 border-gray-50 overflow-hidden group">
                    <div class="relativ p-8">
                        <a href="#">
                            <img src="https://prd.place/400" alt="Spray Dried Beetroot Powder"
                                class="w-full h-64 object-contain">
                        </a>
                    </div>
                    <div class="bg-[#F2F2F2] flex">
                        <button
                            class="flex-1 py-3 flex items-center justify-center border-r hover:cursor-pointer border-gray-200">
                            <i class="fa-regular fa-eye"></i>
                        </button>
                        <button class="flex-1 py-3 flex items-center justify-center hover:cursor-pointer">
                            <i class="fas fa-shopping-cart text-lg md:text-xl"></i>
                        </button>
                    </div>
                    <div class="p-4">
                        <a href="#">
                            <h3 class="text-sm font-bold text-[#222222] mb-2 line-clamp-2">স্প্রে ড্রাইড বিটরুট পাউডার |
                                Spray
                                Dried Beetroot Powder</h3>
                        </a>
                        <div class="flex items-center gap-2">
                            <span class="text-2xl font-bold text-[#669900]">৳1,050</span>
                            <span class="text-medium text-[#afb4be] line-through">৳1,550</span>
                        </div>
                    </div>
                </div>

                <!-- Product Card -->
                <div class="bg-transparent rounded-lg shadow-md border-1 border-gray-50 overflow-hidden group">
                    <div class="relativ p-8">
                        <a href="#">
                            <img src="https://prd.place/400" alt="Spray Dried Beetroot Powder"
                                class="w-full h-64 object-contain">
                        </a>
                    </div>
                    <div class="bg-[#F2F2F2] flex">
                        <button
                            class="flex-1 py-3 flex items-center justify-center border-r hover:cursor-pointer border-gray-200">
                            <i class="fa-regular fa-eye"></i>
                        </button>
                        <button class="flex-1 py-3 flex items-center justify-center hover:cursor-pointer">
                            <i class="fas fa-shopping-cart text-lg md:text-xl"></i>
                        </button>
                    </div>
                    <div class="p-4">
                        <a href="#">
                            <h3 class="text-sm font-bold text-[#222222] mb-2 line-clamp-2">স্প্রে ড্রাইড বিটরুট পাউডার |
                                Spray
                                Dried Beetroot Powder</h3>
                        </a>
                        <div class="flex items-center gap-2">
                            <span class="text-2xl font-bold text-[#669900]">৳1,050</span>
                            <span class="text-medium text-[#afb4be] line-through">৳1,550</span>
                        </div>
                    </div>
                </div>

                <!-- Product Card -->
                <div class="bg-transparent rounded-lg shadow-md border-1 border-gray-50 overflow-hidden group">
                    <div class="relativ p-8">
                        <a href="#">
                            <img src="https://prd.place/400" alt="Spray Dried Beetroot Powder"
                                class="w-full h-64 object-contain">
                        </a>
                    </div>
                    <div class="bg-[#F2F2F2] flex">
                        <button
                            class="flex-1 py-3 flex items-center justify-center border-r hover:cursor-pointer border-gray-200">
                            <i class="fa-regular fa-eye"></i>
                        </button>
                        <button class="flex-1 py-3 flex items-center justify-center hover:cursor-pointer">
                            <i class="fas fa-shopping-cart text-lg md:text-xl"></i>
                        </button>
                    </div>
                    <div class="p-4">
                        <a href="#">
                            <h3 class="text-sm font-bold text-[#222222] mb-2 line-clamp-2">স্প্রে ড্রাইড বিটরুট পাউডার |
                                Spray
                                Dried Beetroot Powder</h3>
                        </a>
                        <div class="flex items-center gap-2">
                            <span class="text-2xl font-bold text-[#669900]">৳1,050</span>
                            <span class="text-medium text-[#afb4be] line-through">৳1,550</span>
                        </div>
                    </div>
                </div>

                <!-- Product Card -->
                <div class="bg-transparent rounded-lg shadow-md border-1 border-gray-50 overflow-hidden group">
                    <div class="relativ p-8">
                        <a href="#">
                            <img src="https://prd.place/400" alt="Spray Dried Beetroot Powder"
                                class="w-full h-64 object-contain">
                        </a>
                    </div>
                    <div class="bg-[#F2F2F2] flex">
                        <button
                            class="flex-1 py-3 flex items-center justify-center border-r hover:cursor-pointer border-gray-200">
                            <i class="fa-regular fa-eye"></i>
                        </button>
                        <button class="flex-1 py-3 flex items-center justify-center hover:cursor-pointer">
                            <i class="fas fa-shopping-cart text-lg md:text-xl"></i>
                        </button>
                    </div>
                    <div class="p-4">
                        <a href="#">
                            <h3 class="text-sm font-bold text-[#222222] mb-2 line-clamp-2">স্প্রে ড্রাইড বিটরুট পাউডার |
                                Spray
                                Dried Beetroot Powder</h3>
                        </a>
                        <div class="flex items-center gap-2">
                            <span class="text-2xl font-bold text-[#669900]">৳1,050</span>
                            <span class="text-medium text-[#afb4be] line-through">৳1,550</span>
                        </div>
                    </div>
                </div>

                <!-- Product Card -->
                <div class="bg-transparent rounded-lg shadow-md border-1 border-gray-50 overflow-hidden group">
                    <div class="relativ p-8">
                        <a href="#">
                            <img src="https://prd.place/400" alt="Spray Dried Beetroot Powder"
                                class="w-full h-64 object-contain">
                        </a>
                    </div>
                    <div class="bg-[#F2F2F2] flex">
                        <button
                            class="flex-1 py-3 flex items-center justify-center border-r hover:cursor-pointer border-gray-200">
                            <i class="fa-regular fa-eye"></i>
                        </button>
                        <button class="flex-1 py-3 flex items-center justify-center hover:cursor-pointer">
                            <i class="fas fa-shopping-cart text-lg md:text-xl"></i>
                        </button>
                    </div>
                    <div class="p-4">
                        <a href="#">
                            <h3 class="text-sm font-bold text-[#222222] mb-2 line-clamp-2">স্প্রে ড্রাইড বিটরুট পাউডার |
                                Spray
                                Dried Beetroot Powder</h3>
                        </a>
                        <div class="flex items-center gap-2">
                            <span class="text-2xl font-bold text-[#669900]">৳1,050</span>
                            <span class="text-medium text-[#afb4be] line-through">৳1,550</span>
                        </div>
                    </div>
                </div>

                <!-- Product Card -->
                <div class="bg-transparent rounded-lg shadow-md border-1 border-gray-50 overflow-hidden group">
                    <div class="relativ p-8">
                        <a href="#">
                            <img src="https://prd.place/400" alt="Spray Dried Beetroot Powder"
                                class="w-full h-64 object-contain">
                        </a>
                    </div>
                    <div class="bg-[#F2F2F2] flex">
                        <button
                            class="flex-1 py-3 flex items-center justify-center border-r hover:cursor-pointer border-gray-200">
                            <i class="fa-regular fa-eye"></i>
                        </button>
                        <button class="flex-1 py-3 flex items-center justify-center hover:cursor-pointer">
                            <i class="fas fa-shopping-cart text-lg md:text-xl"></i>
                        </button>
                    </div>
                    <div class="p-4">
                        <a href="#">
                            <h3 class="text-sm font-bold text-[#222222] mb-2 line-clamp-2">স্প্রে ড্রাইড বিটরুট পাউডার |
                                Spray
                                Dried Beetroot Powder</h3>
                        </a>
                        <div class="flex items-center gap-2">
                            <span class="text-2xl font-bold text-[#669900]">৳1,050</span>
                            <span class="text-medium text-[#afb4be] line-through">৳1,550</span>
                        </div>
                    </div>
                </div>

                <!-- Product Card -->
                <div class="bg-transparent rounded-lg shadow-md border-1 border-gray-50 overflow-hidden group">
                    <div class="relativ p-8">
                        <a href="#">
                            <img src="https://prd.place/400" alt="Spray Dried Beetroot Powder"
                                class="w-full h-64 object-contain">
                        </a>
                    </div>
                    <div class="bg-[#F2F2F2] flex">
                        <button
                            class="flex-1 py-3 flex items-center justify-center border-r hover:cursor-pointer border-gray-200">
                            <i class="fa-regular fa-eye"></i>
                        </button>
                        <button class="flex-1 py-3 flex items-center justify-center hover:cursor-pointer">
                            <i class="fas fa-shopping-cart text-lg md:text-xl"></i>
                        </button>
                    </div>
                    <div class="p-4">
                        <a href="#">
                            <h3 class="text-sm font-bold text-[#222222] mb-2 line-clamp-2">স্প্রে ড্রাইড বিটরুট পাউডার |
                                Spray
                                Dried Beetroot Powder</h3>
                        </a>
                        <div class="flex items-center gap-2">
                            <span class="text-2xl font-bold text-[#669900]">৳1,050</span>
                            <span class="text-medium text-[#afb4be] line-through">৳1,550</span>
                        </div>
                    </div>
                </div>

                <!-- Product Card -->
                <div class="bg-transparent rounded-lg shadow-md border-1 border-gray-50 overflow-hidden group">
                    <div class="relativ p-8">
                        <a href="#">
                            <img src="https://prd.place/400" alt="Spray Dried Beetroot Powder"
                                class="w-full h-64 object-contain">
                        </a>
                    </div>
                    <div class="bg-[#F2F2F2] flex">
                        <button
                            class="flex-1 py-3 flex items-center justify-center border-r hover:cursor-pointer border-gray-200">
                            <i class="fa-regular fa-eye"></i>
                        </button>
                        <button class="flex-1 py-3 flex items-center justify-center hover:cursor-pointer">
                            <i class="fas fa-shopping-cart text-lg md:text-xl"></i>
                        </button>
                    </div>
                    <div class="p-4">
                        <a href="#">
                            <h3 class="text-sm font-bold text-[#222222] mb-2 line-clamp-2">স্প্রে ড্রাইড বিটরুট পাউডার |
                                Spray
                                Dried Beetroot Powder</h3>
                        </a>
                        <div class="flex items-center gap-2">
                            <span class="text-2xl font-bold text-[#669900]">৳1,050</span>
                            <span class="text-medium text-[#afb4be] line-through">৳1,550</span>
                        </div>
                    </div>
                </div>

                <!-- Product Card -->
                <div class="bg-transparent rounded-lg shadow-md border-1 border-gray-50 overflow-hidden group">
                    <div class="relativ p-8">
                        <a href="#">
                            <img src="https://prd.place/400" alt="Spray Dried Beetroot Powder"
                                class="w-full h-64 object-contain">
                        </a>
                    </div>
                    <div class="bg-[#F2F2F2] flex">
                        <button
                            class="flex-1 py-3 flex items-center justify-center border-r hover:cursor-pointer border-gray-200">
                            <i class="fa-regular fa-eye"></i>
                        </button>
                        <button class="flex-1 py-3 flex items-center justify-center hover:cursor-pointer">
                            <i class="fas fa-shopping-cart text-lg md:text-xl"></i>
                        </button>
                    </div>
                    <div class="p-4">
                        <a href="#">
                            <h3 class="text-sm font-bold text-[#222222] mb-2 line-clamp-2">স্প্রে ড্রাইড বিটরুট পাউডার |
                                Spray
                                Dried Beetroot Powder</h3>
                        </a>
                        <div class="flex items-center gap-2">
                            <span class="text-2xl font-bold text-[#669900]">৳1,050</span>
                            <span class="text-medium text-[#afb4be] line-through">৳1,550</span>
                        </div>
                    </div>
                </div>

                <!-- Product Card -->
                <div class="bg-transparent rounded-lg shadow-md border-1 border-gray-50 overflow-hidden group">
                    <div class="relativ p-8">
                        <a href="#">
                            <img src="https://prd.place/400" alt="Spray Dried Beetroot Powder"
                                class="w-full h-64 object-contain">
                        </a>
                    </div>
                    <div class="bg-[#F2F2F2] flex">
                        <button
                            class="flex-1 py-3 flex items-center justify-center border-r hover:cursor-pointer border-gray-200">
                            <i class="fa-regular fa-eye"></i>
                        </button>
                        <button class="flex-1 py-3 flex items-center justify-center hover:cursor-pointer">
                            <i class="fas fa-shopping-cart text-lg md:text-xl"></i>
                        </button>
                    </div>
                    <div class="p-4">
                        <a href="#">
                            <h3 class="text-sm font-bold text-[#222222] mb-2 line-clamp-2">স্প্রে ড্রাইড বিটরুট পাউডার |
                                Spray
                                Dried Beetroot Powder</h3>
                        </a>
                        <div class="flex items-center gap-2">
                            <span class="text-2xl font-bold text-[#669900]">৳1,050</span>
                            <span class="text-medium text-[#afb4be] line-through">৳1,550</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- All Products Section -->
    <section class="py-12 bg-neutral-off-white">
        <div class="container-ds">
            <h2 class="text-3xl font-bold text-[#212529] mb-8 uppercase tracking-wider">All Products</h2>
            <div class="grid grid-cols-1 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-4 gap-6">
                <!-- Product Card -->
                <div class="bg-transparent rounded-lg shadow-md border-1 border-gray-50 overflow-hidden group">
                    <div class="relativ p-8">
                        <a href="#">
                            <img src="https://prd.place/400" alt="Spray Dried Beetroot Powder"
                                class="w-full h-64 object-contain">
                        </a>
                    </div>
                    <div class="bg-[#F2F2F2] flex">
                        <button
                            class="flex-1 py-3 flex items-center justify-center border-r hover:cursor-pointer border-gray-200">
                            <i class="fa-regular fa-eye"></i>
                        </button>
                        <button class="flex-1 py-3 flex items-center justify-center hover:cursor-pointer">
                            <i class="fas fa-shopping-cart text-lg md:text-xl"></i>
                        </button>
                    </div>
                    <div class="p-4">
                        <a href="#">
                            <h3 class="text-sm font-bold text-[#222222] mb-2 line-clamp-2">স্প্রে ড্রাইড বিটরুট পাউডার |
                                Spray
                                Dried Beetroot Powder</h3>
                        </a>
                        <div class="flex items-center gap-2">
                            <span class="text-2xl font-bold text-[#669900]">৳1,050</span>
                            <span class="text-medium text-[#afb4be] line-through">৳1,550</span>
                        </div>
                    </div>
                </div>

                <!-- Product Card -->
                <div class="bg-transparent rounded-lg shadow-md border-1 border-gray-50 overflow-hidden group">
                    <div class="relativ p-8">
                        <a href="#">
                            <img src="https://prd.place/400" alt="Spray Dried Beetroot Powder"
                                class="w-full h-64 object-contain">
                        </a>
                    </div>
                    <div class="bg-[#F2F2F2] flex">
                        <button
                            class="flex-1 py-3 flex items-center justify-center border-r hover:cursor-pointer border-gray-200">
                            <i class="fa-regular fa-eye"></i>
                        </button>
                        <button class="flex-1 py-3 flex items-center justify-center hover:cursor-pointer">
                            <i class="fas fa-shopping-cart text-lg md:text-xl"></i>
                        </button>
                    </div>
                    <div class="p-4">
                        <a href="#">
                            <h3 class="text-sm font-bold text-[#222222] mb-2 line-clamp-2">স্প্রে ড্রাইড বিটরুট পাউডার |
                                Spray
                                Dried Beetroot Powder</h3>
                        </a>
                        <div class="flex items-center gap-2">
                            <span class="text-2xl font-bold text-[#669900]">৳1,050</span>
                            <span class="text-medium text-[#afb4be] line-through">৳1,550</span>
                        </div>
                    </div>
                </div>

                <!-- Product Card -->
                <div class="bg-transparent rounded-lg shadow-md border-1 border-gray-50 overflow-hidden group">
                    <div class="relativ p-8">
                        <a href="#">
                            <img src="https://prd.place/400" alt="Spray Dried Beetroot Powder"
                                class="w-full h-64 object-contain">
                        </a>
                    </div>
                    <div class="bg-[#F2F2F2] flex">
                        <button
                            class="flex-1 py-3 flex items-center justify-center border-r hover:cursor-pointer border-gray-200">
                            <i class="fa-regular fa-eye"></i>
                        </button>
                        <button class="flex-1 py-3 flex items-center justify-center hover:cursor-pointer">
                            <i class="fas fa-shopping-cart text-lg md:text-xl"></i>
                        </button>
                    </div>
                    <div class="p-4">
                        <a href="#">
                            <h3 class="text-sm font-bold text-[#222222] mb-2 line-clamp-2">স্প্রে ড্রাইড বিটরুট পাউডার |
                                Spray
                                Dried Beetroot Powder</h3>
                        </a>
                        <div class="flex items-center gap-2">
                            <span class="text-2xl font-bold text-[#669900]">৳1,050</span>
                            <span class="text-medium text-[#afb4be] line-through">৳1,550</span>
                        </div>
                    </div>
                </div>

                <!-- Product Card -->
                <div class="bg-transparent rounded-lg shadow-md border-1 border-gray-50 overflow-hidden group">
                    <div class="relativ p-8">
                        <a href="#">
                            <img src="https://prd.place/400" alt="Spray Dried Beetroot Powder"
                                class="w-full h-64 object-contain">
                        </a>
                    </div>
                    <div class="bg-[#F2F2F2] flex">
                        <button
                            class="flex-1 py-3 flex items-center justify-center border-r hover:cursor-pointer border-gray-200">
                            <i class="fa-regular fa-eye"></i>
                        </button>
                        <button class="flex-1 py-3 flex items-center justify-center hover:cursor-pointer">
                            <i class="fas fa-shopping-cart text-lg md:text-xl"></i>
                        </button>
                    </div>
                    <div class="p-4">
                        <a href="#">
                            <h3 class="text-sm font-bold text-[#222222] mb-2 line-clamp-2">স্প্রে ড্রাইড বিটরুট পাউডার |
                                Spray
                                Dried Beetroot Powder</h3>
                        </a>
                        <div class="flex items-center gap-2">
                            <span class="text-2xl font-bold text-[#669900]">৳1,050</span>
                            <span class="text-medium text-[#afb4be] line-through">৳1,550</span>
                        </div>
                    </div>
                </div>

                <!-- Product Card -->
                <div class="bg-transparent rounded-lg shadow-md border-1 border-gray-50 overflow-hidden group">
                    <div class="relativ p-8">
                        <a href="#">
                            <img src="https://prd.place/400" alt="Spray Dried Beetroot Powder"
                                class="w-full h-64 object-contain">
                        </a>
                    </div>
                    <div class="bg-[#F2F2F2] flex">
                        <button
                            class="flex-1 py-3 flex items-center justify-center border-r hover:cursor-pointer border-gray-200">
                            <i class="fa-regular fa-eye"></i>
                        </button>
                        <button class="flex-1 py-3 flex items-center justify-center hover:cursor-pointer">
                            <i class="fas fa-shopping-cart text-lg md:text-xl"></i>
                        </button>
                    </div>
                    <div class="p-4">
                        <a href="#">
                            <h3 class="text-sm font-bold text-[#222222] mb-2 line-clamp-2">স্প্রে ড্রাইড বিটরুট পাউডার |
                                Spray
                                Dried Beetroot Powder</h3>
                        </a>
                        <div class="flex items-center gap-2">
                            <span class="text-2xl font-bold text-[#669900]">৳1,050</span>
                            <span class="text-medium text-[#afb4be] line-through">৳1,550</span>
                        </div>
                    </div>
                </div>

                <!-- Product Card -->
                <div class="bg-transparent rounded-lg shadow-md border-1 border-gray-50 overflow-hidden group">
                    <div class="relativ p-8">
                        <a href="#">
                            <img src="https://prd.place/400" alt="Spray Dried Beetroot Powder"
                                class="w-full h-64 object-contain">
                        </a>
                    </div>
                    <div class="bg-[#F2F2F2] flex">
                        <button
                            class="flex-1 py-3 flex items-center justify-center border-r hover:cursor-pointer border-gray-200">
                            <i class="fa-regular fa-eye"></i>
                        </button>
                        <button class="flex-1 py-3 flex items-center justify-center hover:cursor-pointer">
                            <i class="fas fa-shopping-cart text-lg md:text-xl"></i>
                        </button>
                    </div>
                    <div class="p-4">
                        <a href="#">
                            <h3 class="text-sm font-bold text-[#222222] mb-2 line-clamp-2">স্প্রে ড্রাইড বিটরুট পাউডার |
                                Spray
                                Dried Beetroot Powder</h3>
                        </a>
                        <div class="flex items-center gap-2">
                            <span class="text-2xl font-bold text-[#669900]">৳1,050</span>
                            <span class="text-medium text-[#afb4be] line-through">৳1,550</span>
                        </div>
                    </div>
                </div>

                <!-- Product Card -->
                <div class="bg-transparent rounded-lg shadow-md border-1 border-gray-50 overflow-hidden group">
                    <div class="relativ p-8">
                        <a href="#">
                            <img src="https://prd.place/400" alt="Spray Dried Beetroot Powder"
                                class="w-full h-64 object-contain">
                        </a>
                    </div>
                    <div class="bg-[#F2F2F2] flex">
                        <button
                            class="flex-1 py-3 flex items-center justify-center border-r hover:cursor-pointer border-gray-200">
                            <i class="fa-regular fa-eye"></i>
                        </button>
                        <button class="flex-1 py-3 flex items-center justify-center hover:cursor-pointer">
                            <i class="fas fa-shopping-cart text-lg md:text-xl"></i>
                        </button>
                    </div>
                    <div class="p-4">
                        <a href="#">
                            <h3 class="text-sm font-bold text-[#222222] mb-2 line-clamp-2">স্প্রে ড্রাইড বিটরুট পাউডার |
                                Spray
                                Dried Beetroot Powder</h3>
                        </a>
                        <div class="flex items-center gap-2">
                            <span class="text-2xl font-bold text-[#669900]">৳1,050</span>
                            <span class="text-medium text-[#afb4be] line-through">৳1,550</span>
                        </div>
                    </div>
                </div>

                <!-- Product Card -->
                <div class="bg-transparent rounded-lg shadow-md border-1 border-gray-50 overflow-hidden group">
                    <div class="relativ p-8">
                        <a href="#">
                            <img src="https://prd.place/400" alt="Spray Dried Beetroot Powder"
                                class="w-full h-64 object-contain">
                        </a>
                    </div>
                    <div class="bg-[#F2F2F2] flex">
                        <button
                            class="flex-1 py-3 flex items-center justify-center border-r hover:cursor-pointer border-gray-200">
                            <i class="fa-regular fa-eye"></i>
                        </button>
                        <button class="flex-1 py-3 flex items-center justify-center hover:cursor-pointer">
                            <i class="fas fa-shopping-cart text-lg md:text-xl"></i>
                        </button>
                    </div>
                    <div class="p-4">
                        <a href="#">
                            <h3 class="text-sm font-bold text-[#222222] mb-2 line-clamp-2">স্প্রে ড্রাইড বিটরুট পাউডার |
                                Spray
                                Dried Beetroot Powder</h3>
                        </a>
                        <div class="flex items-center gap-2">
                            <span class="text-2xl font-bold text-[#669900]">৳1,050</span>
                            <span class="text-medium text-[#afb4be] line-through">৳1,550</span>
                        </div>
                    </div>
                </div>

                <!-- Product Card -->
                <div class="bg-transparent rounded-lg shadow-md border-1 border-gray-50 overflow-hidden group">
                    <div class="relativ p-8">
                        <a href="#">
                            <img src="https://prd.place/400" alt="Spray Dried Beetroot Powder"
                                class="w-full h-64 object-contain">
                        </a>
                    </div>
                    <div class="bg-[#F2F2F2] flex">
                        <button
                            class="flex-1 py-3 flex items-center justify-center border-r hover:cursor-pointer border-gray-200">
                            <i class="fa-regular fa-eye"></i>
                        </button>
                        <button class="flex-1 py-3 flex items-center justify-center hover:cursor-pointer">
                            <i class="fas fa-shopping-cart text-lg md:text-xl"></i>
                        </button>
                    </div>
                    <div class="p-4">
                        <a href="#">
                            <h3 class="text-sm font-bold text-[#222222] mb-2 line-clamp-2">স্প্রে ড্রাইড বিটরুট পাউডার |
                                Spray
                                Dried Beetroot Powder</h3>
                        </a>
                        <div class="flex items-center gap-2">
                            <span class="text-2xl font-bold text-[#669900]">৳1,050</span>
                            <span class="text-medium text-[#afb4be] line-through">৳1,550</span>
                        </div>
                    </div>
                </div>

                <!-- Product Card -->
                <div class="bg-transparent rounded-lg shadow-md border-1 border-gray-50 overflow-hidden group">
                    <div class="relativ p-8">
                        <a href="#">
                            <img src="https://prd.place/400" alt="Spray Dried Beetroot Powder"
                                class="w-full h-64 object-contain">
                        </a>
                    </div>
                    <div class="bg-[#F2F2F2] flex">
                        <button
                            class="flex-1 py-3 flex items-center justify-center border-r hover:cursor-pointer border-gray-200">
                            <i class="fa-regular fa-eye"></i>
                        </button>
                        <button class="flex-1 py-3 flex items-center justify-center hover:cursor-pointer">
                            <i class="fas fa-shopping-cart text-lg md:text-xl"></i>
                        </button>
                    </div>
                    <div class="p-4">
                        <a href="#">
                            <h3 class="text-sm font-bold text-[#222222] mb-2 line-clamp-2">স্প্রে ড্রাইড বিটরুট পাউডার |
                                Spray
                                Dried Beetroot Powder</h3>
                        </a>
                        <div class="flex items-center gap-2">
                            <span class="text-2xl font-bold text-[#669900]">৳1,050</span>
                            <span class="text-medium text-[#afb4be] line-through">৳1,550</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Recently Viewed Section -->
    <section class="py-12 bg-white">
        <div class="container-ds">
            <h2 class="text-3xl font-bold text-[#212529] mb-8 uppercase tracking-wider">Recently Viewed</h2>
            <div class="recently-viewed-slider product-slider">
                <!-- Product Card -->
                <div class="bg-transparent rounded-lg shadow-md border-1 border-gray-50 overflow-hidden group">
                    <div class="relativ p-8">
                        <a href="#">
                            <img src="https://prd.place/400" alt="Spray Dried Beetroot Powder"
                                class="w-full h-64 object-contain">
                        </a>
                    </div>
                    <div class="bg-[#F2F2F2] flex">
                        <button
                            class="flex-1 py-3 flex items-center justify-center border-r hover:cursor-pointer border-gray-200">
                            <i class="fa-regular fa-eye"></i>
                        </button>
                        <button class="flex-1 py-3 flex items-center justify-center hover:cursor-pointer">
                            <i class="fas fa-shopping-cart text-lg md:text-xl"></i>
                        </button>
                    </div>
                    <div class="p-4">
                        <a href="#">
                            <h3 class="text-sm font-bold text-[#222222] mb-2 line-clamp-2">স্প্রে ড্রাইড বিটরুট পাউডার |
                                Spray
                                Dried Beetroot Powder</h3>
                        </a>
                        <div class="flex items-center gap-2">
                            <span class="text-2xl font-bold text-[#669900]">৳1,050</span>
                            <span class="text-medium text-[#afb4be] line-through">৳1,550</span>
                        </div>
                    </div>
                </div>

                <!-- Product Card -->
                <div class="bg-transparent rounded-lg shadow-md border-1 border-gray-50 overflow-hidden group">
                    <div class="relativ p-8">
                        <a href="#">
                            <img src="https://prd.place/400" alt="Spray Dried Beetroot Powder"
                                class="w-full h-64 object-contain">
                        </a>
                    </div>
                    <div class="bg-[#F2F2F2] flex">
                        <button
                            class="flex-1 py-3 flex items-center justify-center border-r hover:cursor-pointer border-gray-200">
                            <i class="fa-regular fa-eye"></i>
                        </button>
                        <button class="flex-1 py-3 flex items-center justify-center hover:cursor-pointer">
                            <i class="fas fa-shopping-cart text-lg md:text-xl"></i>
                        </button>
                    </div>
                    <div class="p-4">
                        <a href="#">
                            <h3 class="text-sm font-bold text-[#222222] mb-2 line-clamp-2">স্প্রে ড্রাইড বিটরুট পাউডার |
                                Spray
                                Dried Beetroot Powder</h3>
                        </a>
                        <div class="flex items-center gap-2">
                            <span class="text-2xl font-bold text-[#669900]">৳1,050</span>
                            <span class="text-medium text-[#afb4be] line-through">৳1,550</span>
                        </div>
                    </div>
                </div>

                <!-- Product Card -->
                <div class="bg-transparent rounded-lg shadow-md border-1 border-gray-50 overflow-hidden group">
                    <div class="relativ p-8">
                        <a href="#">
                            <img src="https://prd.place/400" alt="Spray Dried Beetroot Powder"
                                class="w-full h-64 object-contain">
                        </a>
                    </div>
                    <div class="bg-[#F2F2F2] flex">
                        <button
                            class="flex-1 py-3 flex items-center justify-center border-r hover:cursor-pointer border-gray-200">
                            <i class="fa-regular fa-eye"></i>
                        </button>
                        <button class="flex-1 py-3 flex items-center justify-center hover:cursor-pointer">
                            <i class="fas fa-shopping-cart text-lg md:text-xl"></i>
                        </button>
                    </div>
                    <div class="p-4">
                        <a href="#">
                            <h3 class="text-sm font-bold text-[#222222] mb-2 line-clamp-2">স্প্রে ড্রাইড বিটরুট পাউডার |
                                Spray
                                Dried Beetroot Powder</h3>
                        </a>
                        <div class="flex items-center gap-2">
                            <span class="text-2xl font-bold text-[#669900]">৳1,050</span>
                            <span class="text-medium text-[#afb4be] line-through">৳1,550</span>
                        </div>
                    </div>
                </div>

                <!-- Product Card -->
                <div class="bg-transparent rounded-lg shadow-md border-1 border-gray-50 overflow-hidden group">
                    <div class="relativ p-8">
                        <a href="#">
                            <img src="https://prd.place/400" alt="Spray Dried Beetroot Powder"
                                class="w-full h-64 object-contain">
                        </a>
                    </div>
                    <div class="bg-[#F2F2F2] flex">
                        <button
                            class="flex-1 py-3 flex items-center justify-center border-r hover:cursor-pointer border-gray-200">
                            <i class="fa-regular fa-eye"></i>
                        </button>
                        <button class="flex-1 py-3 flex items-center justify-center hover:cursor-pointer">
                            <i class="fas fa-shopping-cart text-lg md:text-xl"></i>
                        </button>
                    </div>
                    <div class="p-4">
                        <a href="#">
                            <h3 class="text-sm font-bold text-[#222222] mb-2 line-clamp-2">স্প্রে ড্রাইড বিটরুট পাউডার |
                                Spray
                                Dried Beetroot Powder</h3>
                        </a>
                        <div class="flex items-center gap-2">
                            <span class="text-2xl font-bold text-[#669900]">৳1,050</span>
                            <span class="text-medium text-[#afb4be] line-through">৳1,550</span>
                        </div>
                    </div>
                </div>

                <!-- Product Card -->
                <div class="bg-transparent rounded-lg shadow-md border-1 border-gray-50 overflow-hidden group">
                    <div class="relativ p-8">
                        <a href="#">
                            <img src="https://prd.place/400" alt="Spray Dried Beetroot Powder"
                                class="w-full h-64 object-contain">
                        </a>
                    </div>
                    <div class="bg-[#F2F2F2] flex">
                        <button
                            class="flex-1 py-3 flex items-center justify-center border-r hover:cursor-pointer border-gray-200">
                            <i class="fa-regular fa-eye"></i>
                        </button>
                        <button class="flex-1 py-3 flex items-center justify-center hover:cursor-pointer">
                            <i class="fas fa-shopping-cart text-lg md:text-xl"></i>
                        </button>
                    </div>
                    <div class="p-4">
                        <a href="#">
                            <h3 class="text-sm font-bold text-[#222222] mb-2 line-clamp-2">স্প্রে ড্রাইড বিটরুট পাউডার |
                                Spray
                                Dried Beetroot Powder</h3>
                        </a>
                        <div class="flex items-center gap-2">
                            <span class="text-2xl font-bold text-[#669900]">৳1,050</span>
                            <span class="text-medium text-[#afb4be] line-through">৳1,550</span>
                        </div>
                    </div>
                </div>

                <!-- Product Card -->
                <div class="bg-transparent rounded-lg shadow-md border-1 border-gray-50 overflow-hidden group">
                    <div class="relativ p-8">
                        <a href="#">
                            <img src="https://prd.place/400" alt="Spray Dried Beetroot Powder"
                                class="w-full h-64 object-contain">
                        </a>
                    </div>
                    <div class="bg-[#F2F2F2] flex">
                        <button
                            class="flex-1 py-3 flex items-center justify-center border-r hover:cursor-pointer border-gray-200">
                            <i class="fa-regular fa-eye"></i>
                        </button>
                        <button class="flex-1 py-3 flex items-center justify-center hover:cursor-pointer">
                            <i class="fas fa-shopping-cart text-lg md:text-xl"></i>
                        </button>
                    </div>
                    <div class="p-4">
                        <a href="#">
                            <h3 class="text-sm font-bold text-[#222222] mb-2 line-clamp-2">স্প্রে ড্রাইড বিটরুট পাউডার |
                                Spray
                                Dried Beetroot Powder</h3>
                        </a>
                        <div class="flex items-center gap-2">
                            <span class="text-2xl font-bold text-[#669900]">৳1,050</span>
                            <span class="text-medium text-[#afb4be] line-through">৳1,550</span>
                        </div>
                    </div>
                </div>

                <!-- Product Card -->
                <div class="bg-transparent rounded-lg shadow-md border-1 border-gray-50 overflow-hidden group">
                    <div class="relativ p-8">
                        <a href="#">
                            <img src="https://prd.place/400" alt="Spray Dried Beetroot Powder"
                                class="w-full h-64 object-contain">
                        </a>
                    </div>
                    <div class="bg-[#F2F2F2] flex">
                        <button
                            class="flex-1 py-3 flex items-center justify-center border-r hover:cursor-pointer border-gray-200">
                            <i class="fa-regular fa-eye"></i>
                        </button>
                        <button class="flex-1 py-3 flex items-center justify-center hover:cursor-pointer">
                            <i class="fas fa-shopping-cart text-lg md:text-xl"></i>
                        </button>
                    </div>
                    <div class="p-4">
                        <a href="#">
                            <h3 class="text-sm font-bold text-[#222222] mb-2 line-clamp-2">স্প্রে ড্রাইড বিটরুট পাউডার |
                                Spray
                                Dried Beetroot Powder</h3>
                        </a>
                        <div class="flex items-center gap-2">
                            <span class="text-2xl font-bold text-[#669900]">৳1,050</span>
                            <span class="text-medium text-[#afb4be] line-through">৳1,550</span>
                        </div>
                    </div>
                </div>

                <!-- Product Card -->
                <div class="bg-transparent rounded-lg shadow-md border-1 border-gray-50 overflow-hidden group">
                    <div class="relativ p-8">
                        <a href="#">
                            <img src="https://prd.place/400" alt="Spray Dried Beetroot Powder"
                                class="w-full h-64 object-contain">
                        </a>
                    </div>
                    <div class="bg-[#F2F2F2] flex">
                        <button
                            class="flex-1 py-3 flex items-center justify-center border-r hover:cursor-pointer border-gray-200">
                            <i class="fa-regular fa-eye"></i>
                        </button>
                        <button class="flex-1 py-3 flex items-center justify-center hover:cursor-pointer">
                            <i class="fas fa-shopping-cart text-lg md:text-xl"></i>
                        </button>
                    </div>
                    <div class="p-4">
                        <a href="#">
                            <h3 class="text-sm font-bold text-[#222222] mb-2 line-clamp-2">স্প্রে ড্রাইড বিটরুট পাউডার |
                                Spray
                                Dried Beetroot Powder</h3>
                        </a>
                        <div class="flex items-center gap-2">
                            <span class="text-2xl font-bold text-[#669900]">৳1,050</span>
                            <span class="text-medium text-[#afb4be] line-through">৳1,550</span>
                        </div>
                    </div>
                </div>

                <!-- Product Card -->
                <div class="bg-transparent rounded-lg shadow-md border-1 border-gray-50 overflow-hidden group">
                    <div class="relativ p-8">
                        <a href="#">
                            <img src="https://prd.place/400" alt="Spray Dried Beetroot Powder"
                                class="w-full h-64 object-contain">
                        </a>
                    </div>
                    <div class="bg-[#F2F2F2] flex">
                        <button
                            class="flex-1 py-3 flex items-center justify-center border-r hover:cursor-pointer border-gray-200">
                            <i class="fa-regular fa-eye"></i>
                        </button>
                        <button class="flex-1 py-3 flex items-center justify-center hover:cursor-pointer">
                            <i class="fas fa-shopping-cart text-lg md:text-xl"></i>
                        </button>
                    </div>
                    <div class="p-4">
                        <a href="#">
                            <h3 class="text-sm font-bold text-[#222222] mb-2 line-clamp-2">স্প্রে ড্রাইড বিটরুট পাউডার |
                                Spray
                                Dried Beetroot Powder</h3>
                        </a>
                        <div class="flex items-center gap-2">
                            <span class="text-2xl font-bold text-[#669900]">৳1,050</span>
                            <span class="text-medium text-[#afb4be] line-through">৳1,550</span>
                        </div>
                    </div>
                </div>

                <!-- Product Card -->
                <div class="bg-transparent rounded-lg shadow-md border-1 border-gray-50 overflow-hidden group">
                    <div class="relativ p-8">
                        <a href="#">
                            <img src="https://prd.place/400" alt="Spray Dried Beetroot Powder"
                                class="w-full h-64 object-contain">
                        </a>
                    </div>
                    <div class="bg-[#F2F2F2] flex">
                        <button
                            class="flex-1 py-3 flex items-center justify-center border-r hover:cursor-pointer border-gray-200">
                            <i class="fa-regular fa-eye"></i>
                        </button>
                        <button class="flex-1 py-3 flex items-center justify-center hover:cursor-pointer">
                            <i class="fas fa-shopping-cart text-lg md:text-xl"></i>
                        </button>
                    </div>
                    <div class="p-4">
                        <a href="#">
                            <h3 class="text-sm font-bold text-[#222222] mb-2 line-clamp-2">স্প্রে ড্রাইড বিটরুট পাউডার |
                                Spray
                                Dried Beetroot Powder</h3>
                        </a>
                        <div class="flex items-center gap-2">
                            <span class="text-2xl font-bold text-[#669900]">৳1,050</span>
                            <span class="text-medium text-[#afb4be] line-through">৳1,550</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            // Hero Slider
            if ($('.hero-slider').length) {
                $('.hero-slider').slick({
                    dots: false,
                    infinite: true,
                    speed: 500,
                    fade: true,
                    cssEase: 'linear',
                    autoplay: true,
                    autoplaySpeed: 3000,
                    arrows: false
                });
            }

            // Category Slider
            if ($('.category-slider').length) {
                $('.category-slider').slick({
                    dots: false,
                    infinite: true,
                    speed: 300,
                    slidesToShow: 8,
                    slidesToScroll: 1,
                    autoplay: true,
                    autoplaySpeed: 2000,
                    arrows: false,
                    responsive: [{
                            breakpoint: 1024,
                            settings: {
                                slidesToShow: 6,
                                slidesToScroll: 1
                            }
                        },
                        {
                            breakpoint: 768,
                            settings: {
                                slidesToShow: 4,
                                slidesToScroll: 1
                            }
                        },
                        {
                            breakpoint: 640,
                            settings: {
                                slidesToShow: 3,
                                slidesToScroll: 1
                            }
                        }
                    ]
                });
            }

            // Product Sliders
            $('.product-slider').each(function() {
                if ($(this).length) {
                    $(this).slick({
                        dots: false,
                        infinite: true,
                        speed: 300,
                        slidesToShow: 4,
                        slidesToScroll: 1,
                        autoplay: true,
                        autoplaySpeed: 3000,
                        arrows: false,
                        responsive: [{
                                breakpoint: 1024,
                                settings: {
                                    slidesToShow: 4,
                                    slidesToScroll: 1
                                }
                            },
                            {
                                breakpoint: 768,
                                settings: {
                                    slidesToShow: 3,
                                    slidesToScroll: 1
                                }
                            },
                            {
                                breakpoint: 640,
                                settings: {
                                    slidesToShow: 2,
                                    slidesToScroll: 1
                                }
                            }
                        ]
                    });
                }
            });

            // Quick View
            $('.quick-view-btn').on('click', function() {
                var productId = $(this).data('product-id');
                if (productId && typeof quickView !== 'undefined') {
                    quickView(productId);
                }
            });

            // Add to Cart
            $('.add-to-cart-btn').on('click', function() {
                var productId = $(this).data('product-id');
                if (productId && typeof addToCart !== 'undefined') {
                    addToCart(productId);
                }
            });
        });
    </script>
@endpush
