@extends('theme-views.layouts.app')

@section('title', $web_config['company_name'] . ' ' . translate('Online_Shopping') . ' | ' . $web_config['company_name'] . ' ' . translate('ecommerce'))

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
    <!-- Hero Section -->
    <section class="relative overflow-hidden">
        <div class="hero-slider">
            @if(isset($bannerTypeMainSectionBanner) && $bannerTypeMainSectionBanner)
                <div>
                    <img src="{{ getStorageImages(path: $bannerTypeMainSectionBanner->photo_full_url ?? null, type: 'banner') }}" 
                         alt="Slider image 1"
                         class="w-full h-[300px] sm:h-[400px] md:h-[500px] lg:h-[580px] object-cover">
                </div>
            @else
                <!-- Use template slider images as fallback -->
                <div>
                    <img src="{{ asset('themes/greenmarket/assets/images/slider/Web Slider 01_KMGsqf98.webp') }}" 
                         alt="Slider image 1"
                         class="w-full h-[300px] sm:h-[400px] md:h-[500px] lg:h-[580px] object-cover">
                </div>
                <div>
                    <img src="{{ asset('themes/greenmarket/assets/images/slider/Web Slider 02_KMG5yaqx6.webp') }}" 
                         alt="Slider image 2"
                         class="w-full h-[300px] sm:h-[400px] md:h-[500px] lg:h-[580px] object-cover">
                </div>
            @endif
        </div>
    </section>

    <!-- Category Bar -->
    <section class="bg-[#d8f7e5] py-3">
        <div class="container-ds">
            <div class="category-slider">
                @if(isset($categories) && $categories->count() > 0)
                    @foreach($categories->take(12) as $category)
                        <div>
                            <a href="{{ route('products', ['data_from' => 'category', 'id' => $category->id]) }}"
                                class="flex flex-col items-center gap-2 text-[#389e63] hover:scale-110 transition-transform group">
                                <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center group-hover:bg-white/30 transition-colors">
                                    @if($category->icon)
                                        <img src="{{ getStorageImages(path: $category->icon, type: 'category') }}" alt="{{ $category->name }}" class="w-6 h-6">
                                    @else
                                        <i class="fas fa-th-large text-xl"></i>
                                    @endif
                                </div>
                                <span class="text-lg font-bold">{{ $category->name }}</span>
                            </a>
                        </div>
                    @endforeach
                @else
                    @for($i = 1; $i <= 8; $i++)
                        <div>
                            <a href="#"
                                class="flex flex-col items-center gap-2 text-[#389e63] hover:scale-110 transition-transform group">
                                <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center group-hover:bg-white/30 transition-colors">
                                    <i class="fas fa-leaf text-xl"></i>
                                </div>
                                <span class="text-lg font-bold">{{ translate('category') }} {{ $i }}</span>
                            </a>
                        </div>
                    @endfor
                @endif
            </div>
        </div>
    </section>

    <!-- Our Best Sellers Section -->
    @if(isset($flashDeal['flashDealProducts']) && $flashDeal['flashDealProducts']->count() > 0)
    <section class="py-5 bg-white">
        <div class="container-ds">
            <h2 class="text-3xl font-bold text-[#212529] mb-8 uppercase tracking-wider">{{ translate('flash_deals') }}</h2>
            <div class="bestsellers-slider product-slider">
                @foreach($flashDeal['flashDealProducts']->take(10) as $product)
                    <div class="bg-transparent rounded-lg shadow-md border-1 border-gray-50 overflow-hidden group">
                        <div class="relative p-8">
                            <a href="{{ route('product', ['slug' => $product->slug ?? '#']) }}">
                                <img src="{{ getStorageImages(path: $product->thumbnail_full_url ?? null, type: 'product') }}"
                                    alt="{{ $product->name ?? 'Product' }}" 
                                    class="w-full h-64 object-contain">
                            </a>
                        </div>
                        <div class="bg-[#F2F2F2] flex">
                            <button class="flex-1 py-3 flex items-center justify-center border-r hover:cursor-pointer border-gray-200 quick-view-btn" data-product-id="{{ $product->id ?? '' }}">
                                <i class="fa-regular fa-eye"></i>
                            </button>
                            <button class="flex-1 py-3 flex items-center justify-center hover:cursor-pointer add-to-cart-btn" data-product-id="{{ $product->id ?? '' }}">
                                <i class="fas fa-shopping-cart text-lg md:text-xl"></i>
                            </button>
                        </div>
                        <div class="p-4">
                            <a href="{{ route('product', ['slug' => $product->slug ?? '#']) }}">
                                <h3 class="text-sm font-bold text-[#222222] mb-2 line-clamp-2">{{ $product->name ?? translate('product') }}</h3>
                            </a>
                            <div class="flex items-center gap-2">
                                <span class="text-2xl font-bold text-[#669900]">{{ session('currency_symbol') ?? '৳' }}{{ number_format($product->unit_price ?? 0, 2) }}</span>
                                @if(isset($product->discount) && $product->discount > 0)
                                    @php
                                        $originalPrice = ($product->unit_price ?? 0) / (1 - ($product->discount / 100));
                                    @endphp
                                    <span class="text-medium text-[#afb4be] line-through">{{ session('currency_symbol') ?? '৳' }}{{ number_format($originalPrice, 2) }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Honey Section - Using Featured Products -->
    @if(isset($featuredProductsList) && $featuredProductsList->count() > 0)
    <section class="py-12 bg-[#f5f5f5]">
        <div class="container-ds">
            <h2 class="text-3xl font-bold text-[#212529] mb-8 uppercase tracking-wider">{{ translate('featured_products') }}</h2>
            <div class="honey-slider product-slider">
                @foreach($featuredProductsList->take(10) as $product)
                    <div class="bg-transparent rounded-lg shadow-md border-1 border-gray-50 overflow-hidden group">
                        <div class="relative p-8">
                            <a href="{{ route('product', ['slug' => $product->slug ?? '#']) }}">
                                <img src="{{ getStorageImages(path: $product->thumbnail_full_url ?? null, type: 'product') }}"
                                    alt="{{ $product->name ?? 'Product' }}" 
                                    class="w-full h-64 object-contain">
                            </a>
                        </div>
                        <div class="bg-[#F2F2F2] flex">
                            <button class="flex-1 py-3 flex items-center justify-center border-r hover:cursor-pointer border-gray-200 quick-view-btn" data-product-id="{{ $product->id ?? '' }}">
                                <i class="fa-regular fa-eye"></i>
                            </button>
                            <button class="flex-1 py-3 flex items-center justify-center hover:cursor-pointer add-to-cart-btn" data-product-id="{{ $product->id ?? '' }}">
                                <i class="fas fa-shopping-cart text-lg md:text-xl"></i>
                            </button>
                        </div>
                        <div class="p-4">
                            <a href="{{ route('product', ['slug' => $product->slug ?? '#']) }}">
                                <h3 class="text-sm font-bold text-[#222222] mb-2 line-clamp-2">{{ $product->name ?? translate('product') }}</h3>
                            </a>
                            <div class="flex items-center gap-2">
                                <span class="text-2xl font-bold text-[#669900]">{{ session('currency_symbol') ?? '৳' }}{{ number_format($product->unit_price ?? 0, 2) }}</span>
                                @if(isset($product->discount) && $product->discount > 0)
                                    @php
                                        $originalPrice = ($product->unit_price ?? 0) / (1 - ($product->discount / 100));
                                    @endphp
                                    <span class="text-medium text-[#afb4be] line-through">{{ session('currency_symbol') ?? '৳' }}{{ number_format($originalPrice, 2) }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Wellness Section - Using Latest Products -->
    @if(isset($featuredProductsList) && $featuredProductsList->count() > 0)
    <section class="py-12 bg-white">
        <div class="container-ds">
            <h2 class="text-3xl font-bold text-[#212529] mb-8 uppercase tracking-wider">{{ translate('wellness') }}</h2>
            <div class="wellness-slider product-slider">
                @foreach($featuredProductsList->skip(5)->take(10) as $product)
                    <div class="bg-transparent rounded-lg shadow-md border-1 border-gray-50 overflow-hidden group">
                        <div class="relative p-8">
                            <a href="{{ route('product', ['slug' => $product->slug ?? '#']) }}">
                                <img src="{{ getStorageImages(path: $product->thumbnail_full_url ?? null, type: 'product') }}"
                                    alt="{{ $product->name ?? 'Product' }}" 
                                    class="w-full h-64 object-contain">
                            </a>
                        </div>
                        <div class="bg-[#F2F2F2] flex">
                            <button class="flex-1 py-3 flex items-center justify-center border-r hover:cursor-pointer border-gray-200 quick-view-btn" data-product-id="{{ $product->id ?? '' }}">
                                <i class="fa-regular fa-eye"></i>
                            </button>
                            <button class="flex-1 py-3 flex items-center justify-center hover:cursor-pointer add-to-cart-btn" data-product-id="{{ $product->id ?? '' }}">
                                <i class="fas fa-shopping-cart text-lg md:text-xl"></i>
                            </button>
                        </div>
                        <div class="p-4">
                            <a href="{{ route('product', ['slug' => $product->slug ?? '#']) }}">
                                <h3 class="text-sm font-bold text-[#222222] mb-2 line-clamp-2">{{ $product->name ?? translate('product') }}</h3>
                            </a>
                            <div class="flex items-center gap-2">
                                <span class="text-2xl font-bold text-[#669900]">{{ session('currency_symbol') ?? '৳' }}{{ number_format($product->unit_price ?? 0, 2) }}</span>
                                @if(isset($product->discount) && $product->discount > 0)
                                    @php
                                        $originalPrice = ($product->unit_price ?? 0) / (1 - ($product->discount / 100));
                                    @endphp
                                    <span class="text-medium text-[#afb4be] line-through">{{ session('currency_symbol') ?? '৳' }}{{ number_format($originalPrice, 2) }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- All Products Section -->
    @if(isset($featuredProductsList) && $featuredProductsList->count() > 0)
    <section class="py-12 bg-[#f5f5f5]">
        <div class="container-ds">
            <h2 class="text-3xl font-bold text-[#212529] mb-8 uppercase tracking-wider">{{ translate('all_products') }}</h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6">
                @foreach($featuredProductsList->take(10) as $product)
                    <div class="bg-transparent rounded-lg shadow-md border-1 border-gray-50 overflow-hidden group">
                        <div class="relative p-8">
                            <a href="{{ route('product', ['slug' => $product->slug ?? '#']) }}">
                                <img src="{{ getStorageImages(path: $product->thumbnail_full_url ?? null, type: 'product') }}"
                                    alt="{{ $product->name ?? 'Product' }}" 
                                    class="w-full h-64 object-contain">
                            </a>
                        </div>
                        <div class="bg-[#F2F2F2] flex">
                            <button class="flex-1 py-3 flex items-center justify-center border-r hover:cursor-pointer border-gray-200 quick-view-btn" data-product-id="{{ $product->id ?? '' }}">
                                <i class="fa-regular fa-eye"></i>
                            </button>
                            <button class="flex-1 py-3 flex items-center justify-center hover:cursor-pointer add-to-cart-btn" data-product-id="{{ $product->id ?? '' }}">
                                <i class="fas fa-shopping-cart text-lg md:text-xl"></i>
                            </button>
                        </div>
                        <div class="p-4">
                            <a href="{{ route('product', ['slug' => $product->slug ?? '#']) }}">
                                <h3 class="text-sm font-bold text-[#222222] mb-2 line-clamp-2">{{ $product->name ?? translate('product') }}</h3>
                            </a>
                            <div class="flex items-center gap-2">
                                <span class="text-2xl font-bold text-[#669900]">{{ session('currency_symbol') ?? '৳' }}{{ number_format($product->unit_price ?? 0, 2) }}</span>
                                @if(isset($product->discount) && $product->discount > 0)
                                    @php
                                        $originalPrice = ($product->unit_price ?? 0) / (1 - ($product->discount / 100));
                                    @endphp
                                    <span class="text-medium text-[#afb4be] line-through">{{ session('currency_symbol') ?? '৳' }}{{ number_format($originalPrice, 2) }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Recently Viewed Section -->
    @if(isset($featuredProductsList) && $featuredProductsList->count() > 0)
    <section class="py-12 bg-white">
        <div class="container-ds">
            <h2 class="text-3xl font-bold text-[#212529] mb-8 uppercase tracking-wider">{{ translate('recently_viewed') }}</h2>
            <div class="recently-viewed-slider product-slider">
                @foreach($featuredProductsList->take(10) as $product)
                    <div class="bg-transparent rounded-lg shadow-md border-1 border-gray-50 overflow-hidden group">
                        <div class="relative p-8">
                            <a href="{{ route('product', ['slug' => $product->slug ?? '#']) }}">
                                <img src="{{ getStorageImages(path: $product->thumbnail_full_url ?? null, type: 'product') }}"
                                    alt="{{ $product->name ?? 'Product' }}" 
                                    class="w-full h-64 object-contain">
                            </a>
                        </div>
                        <div class="bg-[#F2F2F2] flex">
                            <button class="flex-1 py-3 flex items-center justify-center border-r hover:cursor-pointer border-gray-200 quick-view-btn" data-product-id="{{ $product->id ?? '' }}">
                                <i class="fa-regular fa-eye"></i>
                            </button>
                            <button class="flex-1 py-3 flex items-center justify-center hover:cursor-pointer add-to-cart-btn" data-product-id="{{ $product->id ?? '' }}">
                                <i class="fas fa-shopping-cart text-lg md:text-xl"></i>
                            </button>
                        </div>
                        <div class="p-4">
                            <a href="{{ route('product', ['slug' => $product->slug ?? '#']) }}">
                                <h3 class="text-sm font-bold text-[#222222] mb-2 line-clamp-2">{{ $product->name ?? translate('product') }}</h3>
                            </a>
                            <div class="flex items-center gap-2">
                                <span class="text-2xl font-bold text-[#669900]">{{ session('currency_symbol') ?? '৳' }}{{ number_format($product->unit_price ?? 0, 2) }}</span>
                                @if(isset($product->discount) && $product->discount > 0)
                                    @php
                                        $originalPrice = ($product->unit_price ?? 0) / (1 - ($product->discount / 100));
                                    @endphp
                                    <span class="text-medium text-[#afb4be] line-through">{{ session('currency_symbol') ?? '৳' }}{{ number_format($originalPrice, 2) }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- We Care Section -->
    <section class="we-care-section">
        <div class="container-ds text-center">
            <h2 class="text-3xl font-bold text-white mb-4">{{ translate('we_care') }}</h2>
            <p class="text-white/90 text-lg max-w-3xl mx-auto">{{ translate('our_mission_is_to_provide_the_best_quality_products') }}</p>
        </div>
    </section>
@endsection

@push('script')
<script>
    $(document).ready(function() {
        // Hero Slider
        if ($('.hero-slider').length) {
            $('.hero-slider').slick({
                dots: true,
                infinite: true,
                speed: 500,
                fade: true,
                cssEase: 'linear',
                autoplay: true,
                autoplaySpeed: 3000,
                arrows: true
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
                arrows: true,
                responsive: [
                    {
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
                    slidesToShow: 5,
                    slidesToScroll: 1,
                    autoplay: true,
                    autoplaySpeed: 3000,
                    arrows: true,
                    responsive: [
                        {
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
