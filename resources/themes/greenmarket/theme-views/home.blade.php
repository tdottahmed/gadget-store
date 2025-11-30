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
    <section class="bg-gradient-to-r from-green-600 to-green-800 text-white py-20">
        <div class="container mx-auto px-4">
            <div class="text-center">
                <h1 class="text-5xl font-bold mb-4">{{ translate('welcome_to') }} {{ $web_config['company_name'] }}</h1>
                <p class="text-xl mb-8">{{ translate('your_one_stop_shop_for_all_your_needs') }}</p>
                <a href="{{ route('products') }}" class="bg-white text-green-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors inline-block">
                    {{ translate('shop_now') }}
                </a>
            </div>
        </div>
    </section>

    <!-- Featured Categories -->
    <section class="py-12 bg-white">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-8">{{ translate('shop_by_category') }}</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-6">
                @for($i = 1; $i <= 6; $i++)
                    <div class="text-center">
                        <div class="bg-gray-100 rounded-lg p-6 mb-4 hover:shadow-lg transition-shadow cursor-pointer">
                            <div class="w-16 h-16 bg-green-500 rounded-full mx-auto mb-4 flex items-center justify-center">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                </svg>
                            </div>
                            <h3 class="font-semibold text-gray-800">{{ translate('category') }} {{ $i }}</h3>
                        </div>
                    </div>
                @endfor
            </div>
        </div>
    </section>

    <!-- Flash Deals -->
    @if (isset($flashDeal['flashDeal']) && $flashDeal['flashDeal'] && isset($flashDeal['flashDealProducts']) && $flashDeal['flashDealProducts'] && count($flashDeal['flashDealProducts']) > 0)
    <section class="py-12 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-3xl font-bold">{{ translate('flash_deals') }}</h2>
                @if(isset($flashDeal['flashDeal']->id))
                    <a href="{{ route('flash-deals', ['id' => $flashDeal['flashDeal']->id]) }}" class="text-green-600 hover:text-green-700 font-semibold">
                        {{ translate('view_all') }} →
                    </a>
                @else
                    <a href="{{ route('products') }}" class="text-green-600 hover:text-green-700 font-semibold">
                        {{ translate('view_all') }} →
                    </a>
                @endif
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-6">
                @foreach($flashDeal['flashDealProducts']->take(6) as $product)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow">
                        <div class="aspect-square bg-gray-200 relative">
                            <img src="{{ getStorageImages(path: $product->thumbnail_full_url ?? null, type: 'product') }}" 
                                 alt="{{ $product->name ?? 'Product' }}" class="w-full h-full object-cover">
                            @if(isset($product->discount) && $product->discount > 0)
                                <span class="absolute top-2 right-2 bg-red-500 text-white px-2 py-1 rounded text-xs font-semibold">
                                    -{{ $product->discount }}%
                                </span>
                            @endif
                        </div>
                        <div class="p-4">
                            <h3 class="font-semibold text-gray-800 mb-2 line-clamp-2">{{ $product->name ?? 'Product' }}</h3>
                            <div class="flex items-center justify-between">
                                <span class="text-green-600 font-bold">{{ session('currency_symbol') ?? '$' }}{{ $product->unit_price ?? 0 }}</span>
                                @if(isset($product->unit_price) && $product->unit_price > 0)
                                    <span class="text-gray-400 line-through text-sm">{{ session('currency_symbol') ?? '$' }}{{ $product->unit_price }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Featured Products -->
    <section class="py-12 bg-white">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-3xl font-bold">{{ translate('featured_products') }}</h2>
                <a href="{{ route('products', ['data_from' => 'featured', 'page' => 1]) }}" class="text-green-600 hover:text-green-700 font-semibold">
                    {{ translate('view_all') }} →
                </a>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-6">
                @if(isset($featuredProductsList) && $featuredProductsList->count() > 0)
                    @foreach($featuredProductsList->take(6) as $product)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow">
                            <div class="aspect-square bg-gray-200 relative">
                                <img src="{{ getStorageImages(path: $product->thumbnail_full_url ?? null, type: 'product') }}" 
                                     alt="{{ $product->name ?? 'Product' }}" class="w-full h-full object-cover">
                            </div>
                            <div class="p-4">
                                <h3 class="font-semibold text-gray-800 mb-2 line-clamp-2">{{ $product->name ?? 'Product' }}</h3>
                                <p class="text-green-600 font-bold mb-2">{{ session('currency_symbol') ?? '$' }}{{ $product->unit_price ?? 0 }}</p>
                                <a href="{{ route('product', ['slug' => $product->slug ?? '#']) }}" class="block w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 transition-colors text-center">
                                    {{ translate('view_details') }}
                                </a>
                            </div>
                        </div>
                    @endforeach
                @else
                    @for($i = 1; $i <= 6; $i++)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow">
                            <div class="aspect-square bg-gray-200">
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="p-4">
                                <h3 class="font-semibold text-gray-800 mb-2">{{ translate('product') }} {{ $i }}</h3>
                                <p class="text-green-600 font-bold mb-2">{{ session('currency_symbol') ?? '$' }}99.99</p>
                                <button class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 transition-colors">
                                    {{ translate('add_to_cart') }}
                                </button>
                            </div>
                        </div>
                    @endfor
                @endif
            </div>
        </div>
    </section>

    <!-- Banner Section -->
    @if (isset($bannerTypeMainSectionBanner) && !empty($bannerTypeMainSectionBanner))
    <section class="py-12 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="relative rounded-lg overflow-hidden">
                <img src="{{ getStorageImages(path: $bannerTypeMainSectionBanner->photo_full_url ?? null, type: 'banner') }}" 
                     alt="Banner" class="w-full h-64 object-cover">
                <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center">
                    <div class="text-center text-white">
                        <h2 class="text-4xl font-bold mb-4">{{ translate('do_not_miss_today`s_deal') }}!</h2>
                        <a href="{{ isset($bannerTypeMainSectionBanner->url) && $bannerTypeMainSectionBanner->url ? $bannerTypeMainSectionBanner->url : route('products') }}" 
                           class="bg-white text-green-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors inline-block">
                            {{ translate('shop_now') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    <!-- Newsletter Section -->
    <section class="py-12 bg-green-600 text-white">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold mb-4">{{ translate('subscribe_to_our_newsletter') }}</h2>
            <p class="mb-6">{{ translate('get_the_latest_updates_and_offers') }}</p>
            <form class="max-w-md mx-auto flex gap-2">
                <input type="email" placeholder="{{ translate('enter_your_email') }}" 
                       class="flex-1 px-4 py-3 rounded-lg text-gray-800 focus:outline-none focus:ring-2 focus:ring-white">
                <button type="submit" class="bg-white text-green-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
                    {{ translate('subscribe') }}
                </button>
            </form>
        </div>
    </section>
@endsection

