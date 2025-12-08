@extends('web-views.layouts.app')

@section('title', ($product->name ?? 'Product Details') . ' - ' . $web_config['company_name'])

@php
    // Parse product data
    // Get product images (using model accessor) - storageLink returns array with 'path' key
    $productImagesRaw = $product->images_full_url ?? [];
    $productImages = [];
    
    // Extract path from each image (storageLink returns array with 'path' key)
    foreach ($productImagesRaw as $img) {
        if (is_array($img) && isset($img['path'])) {
            $productImages[] = $img['path'];
        } elseif (is_string($img)) {
            $productImages[] = $img;
        }
    }
    
    // If no images, use thumbnail
    if (empty($productImages) && $product->thumbnail_full_url) {
        $thumbnailResult = $product->thumbnail_full_url;
        if (is_array($thumbnailResult) && isset($thumbnailResult['path'])) {
            $productImages[] = $thumbnailResult['path'];
        } elseif (is_string($thumbnailResult)) {
            $productImages[] = $thumbnailResult;
        }
    }
    
    // Parse variations and colors
    $productVariations = json_decode($product->variation ?? '[]', true);
    $productColors = json_decode($product->colors ?? '[]', true);
    $productCategory = $product->category ?? null;
    
    // Get main image - ensure it's always a string
    $mainImage = !empty($productImages) ? (string)$productImages[0] : '';
    
    if (!$mainImage && $product->thumbnail_full_url) {
        $thumbnailResult = $product->thumbnail_full_url;
        if (is_array($thumbnailResult) && isset($thumbnailResult['path'])) {
            $mainImage = (string)$thumbnailResult['path'];
        } elseif (is_string($thumbnailResult)) {
            $mainImage = $thumbnailResult;
        }
    }
    
    if (!$mainImage) {
        $thumbnailResult = getStorageImages(path: $product->thumbnail ?? '', type: 'product');
        if (is_array($thumbnailResult) && isset($thumbnailResult['path'])) {
            $mainImage = (string)$thumbnailResult['path'];
        } elseif (is_string($thumbnailResult)) {
            $mainImage = $thumbnailResult;
        }
    }
    
    $mainImage = $mainImage ?: 'https://placehold.co/400';
    
    // Get pricing
    $discountValue = getProductPriceByType(product: $product, type: 'discount', result: 'value');
    $discountedPrice = getProductPriceByType(product: $product, type: 'discounted_unit_price', result: 'string');
    $originalPrice = webCurrencyConverter(amount: $product->unit_price ?? 0);
@endphp

@push('css_or_js')
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

        /* Line clamp utility for product titles */
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
@endpush

@section('content')
    <!-- Product Data for Tracking (Hidden) -->
    <div id="product-details-page" 
         data-product-id="{{ $product->id ?? '' }}"
         data-product-slug="{{ $product->slug ?? '' }}"
         data-product-name="{{ $product->name ?? '' }}"
         data-product-image="{{ $mainImage }}"
         data-product-price="{{ is_string($discountedPrice) ? $discountedPrice : '' }}"
         style="display: none;">
    </div>

    <!-- Main Content -->
    <main class="container-ds">
        <!-- Product Section -->
        <section class=" mx-auto px-4 py-8">
            <div class="grid grid-cols-1 bg-white md:grid-cols-2 gap-12">
                <!-- Product Gallery -->
                <div class="relative top-20 md:top-20">
                    <div class="flex flex-col gap-4">
                        <div
                            class="w-full aspect-square bg-white border border-[#F0F0F0] rounded-lg p-8 flex items-center justify-center">
                            <img id="main-product-image"
                                src="{{ $mainImage }}"
                                alt="{{ $product->name ?? 'Product' }}" class="w-full h-full object-contain">
                        </div>
                        @if(count($productImages) > 1)
                            <div class="flex flex-row gap-3 justify-center flex-wrap overflow-x-auto pb-2">
                                @foreach($productImages as $index => $image)
                                    @php
                                        // Ensure image URL is always a string (already processed above)
                                        $imageUrl = (string)$image;
                                    @endphp
                                    @if($imageUrl)
                                        <div class="product-thumbnail min-w-[70px] md:w-20 w-[70px] h-[70px] md:h-20 {{ $index === 0 ? 'border-[3px] border-[#FA582C]' : 'border-2 border-[#E0E0E0]' }} rounded-md p-2 cursor-pointer transition-all duration-300 bg-white flex items-center justify-center flex-shrink-0 hover:border-[#FA582C]"
                                            data-image="{{ $imageUrl }}">
                                            <img src="{{ $imageUrl }}"
                                                alt="Thumbnail {{ $index + 1 }}" class="w-full h-full object-contain">
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Product Info -->
                <div class="py-4 mt-14 md:mt-0">
                    <h1 id="product-name" class="text-xl md:text-xl lg:text-3xl font-semibold text-black mb-4 leading-tight">
                        {{ $product->name ?? 'Product' }}
                    </h1>

                    <div class="flex items-center gap-3 mb-6">
                        @if($discountValue > 0)
                            <span class="text-lg font-semibold text-[#666666] line-through">{{ $originalPrice }}</span>
                        @endif
                        <span id="product-price" class="text-xl md:text-2xl font-semibold text-[#FA582C]">
                            {{ $discountedPrice }}
                        </span>
                        @if($discountValue > 0)
                            <span class="inline-block px-2 py-1 bg-[#DD3737] text-white rounded-2xl text-sm font-semibold">
                                @if($product->discount_type === 'percent')
                                    {{ $discountValue }}% OFF
                                @else
                                    {{ translate('save') }} {{ webCurrencyConverter(amount: $discountValue) }}
                                @endif
                            </span>
                        @endif
                    </div>

                    <!-- Color Selection (if available) -->
                    @if(count($productColors) > 0)
                        <div class="mb-6">
                            <label class="block font-semibold text-[#333333] mb-3">{{ translate('color') ?? 'Color' }}:</label>
                            <div class="flex gap-3 flex-wrap">
                                @foreach($productColors as $index => $color)
                                    <button
                                        class="w-10 h-10 rounded-full border-2 {{ $index === 0 ? 'border-[#96C43C]' : 'border-gray-300' }} cursor-pointer transition-all duration-300 product-color-btn"
                                        style="background-color: {{ $color }};"
                                        data-color="{{ $color }}"
                                        title="{{ $color }}">
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Variant Selection (if available) -->
                    @if(count($productVariations) > 0)
                        <div class="mb-6">
                            <label class="block font-semibold text-[#333333] mb-3">{{ translate('select_variant') ?? 'Select Variant' }}:</label>
                            <div class="flex gap-4 flex-wrap md:flex-row flex-col">
                                @foreach($productVariations as $index => $variation)
                                    @php
                                        $variantPrice = $variation['price'] ?? $product->unit_price;
                                        $variantDiscount = getProductPriceByType(product: $product, type: 'discounted_amount', result: 'value', price: $variantPrice);
                                        $variantDiscountedPrice = webCurrencyConverter(amount: $variantPrice - $variantDiscount);
                                        $variantOriginalPrice = webCurrencyConverter(amount: $variantPrice);
                                        $variantDiscountPercent = $variantPrice > 0 ? round(($variantDiscount / $variantPrice) * 100) : 0;
                                        $isInStock = ($variation['qty'] ?? 0) > 0;
                                    @endphp
                                    <button
                                        class="relative px-4 py-2 {{ $index === 0 ? 'border-2 border-[#96C43C]' : 'border-2 border-[#E0E0E0]' }} rounded-md text-[#333333] text-sm font-semibold cursor-pointer flex items-center gap-2 md:w-auto w-full justify-between product-variant-btn {{ !$isInStock ? 'opacity-50 cursor-not-allowed' : '' }}"
                                        data-variant="{{ $variation['type'] ?? '' }}"
                                        data-variant-price="{{ $variantPrice }}"
                                        data-variant-discounted-price="{{ $variantDiscountedPrice }}"
                                        data-variant-original-price="{{ $variantOriginalPrice }}"
                                        {{ !$isInStock ? 'disabled' : '' }}>
                                        <span class="text-base font-semibold">{{ $variation['type'] ?? 'Default' }}</span>
                                        @if($variantDiscountPercent > 0)
                                            <span class="bg-gray-100 text-[#DD3737] px-2 rounded-3xl text-[10px] font-bold">
                                                {{ $variantDiscountPercent }}% OFF
                                            </span>
                                        @endif
                                        @if(!$isInStock)
                                            <span class="text-xs text-red-500">{{ translate('out_of_stock') ?? 'Out of Stock' }}</span>
                                        @endif
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div class="flex items-center gap-2 mb-6 py-4">
                        <button
                            class="text-[22px] border rounded px-4 py-1 text-[#8b8b8b] h-[43px] w-[50px] flex items-center justify-center cursor-pointer hover:bg-gray-50 transition-colors"
                            id="decrease-quantity">-</button>
                        <span
                            class="text-[14px] border rounded px-4 py-1 text-[#8b8b8b] h-[43px] w-[50px] flex items-center justify-center"
                            id="quantity-display">1</span>
                        <button
                            class="text-[22px] border rounded px-4 py-1 text-[#8b8b8b] h-[43px] w-[50px] flex items-center justify-center cursor-pointer hover:bg-gray-50 transition-colors"
                            id="increase-quantity">+</button>
                    </div>

                    <div class="flex flex-col md:flex-row gap-4 mb-6">
                        <button
                            class="text-black py-3 px-6 border-2 border-black rounded-md flex items-center gap-2 w-full justify-center cursor-pointer hover:bg-black hover:text-white transition-all duration-300 add-to-cart-btn"
                            id="btn-add-to-cart"
                            data-product-id="{{ $product->id ?? '' }}"
                            data-product-slug="{{ $product->slug ?? '' }}">
                            <i class="fas fa-shopping-cart"></i>
                            <span>কার্টে যোগ করুন</span>
                        </button>
                        <button
                            class="w-full px-6 py-3 bg-[#FA582C] text-white border-none rounded-md text-base font-bold cursor-pointer transition-all duration-300 flex items-center justify-center gap-2 hover:bg-[#FF5520] hover:-translate-y-0.5 hover:shadow-[0_4px_12px_rgba(255,107,53,0.3)] buy-now-btn"
                            data-product-id="{{ $product->id ?? '' }}"
                            data-product-slug="{{ $product->slug ?? '' }}">
                            <i class="fas fa-shopping-bag"></i>
                            <span>{{ translate('order_now') ?? 'অর্ডার করুন' }}</span>
                        </button>
                    </div>

                    @php($phone = getWebConfig('phone') ?? '09639812525')
                    @if($phone)
                        <a href="tel:{{ $phone }}"
                            class="text-black py-3 px-6 border-black border-2 rounded-md flex items-center gap-2 w-full justify-center cursor-pointer mt-3">
                            <span class="text-[14px] font-semibold">{{ translate('call_order') ?? 'Call Order' }}: {{ $phone }}</span>
                        </a>
                    @endif

                    @if($productCategory)
                        <div class="inline-flex items-center gap-2 text-sm text-[#666666] mt-10 py-2">
                            <span class="font-semibold text-black">{{ translate('category') ?? 'Category' }}:</span>
                            <a href="{{ route('products', ['data_from' => 'category', 'id' => $productCategory->id]) }}" class="text-[#2D5F3F] no-underline hover:underline">
                                {{ $productCategory->name ?? 'N/A' }}
                            </a>
                        </div>
                    @endif

                    @if($product->current_stock > 0)
                        <div class="mt-4 text-sm text-[#666666]">
                            <span class="font-semibold text-black">{{ translate('stock') ?? 'Stock' }}:</span>
                            <span class="text-green-600 font-semibold">{{ $product->current_stock }} {{ translate('available') ?? 'available' }}</span>
                        </div>
                    @else
                        <div class="mt-4 text-sm">
                            <span class="text-red-600 font-semibold">{{ translate('out_of_stock') ?? 'Out of Stock' }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </section>

        <!-- Product Description Section -->
        @if($product->details)
            <section class="py-12 mt-12">
                <div class="max-w-[1400px] mx-auto px-4">
                    <h2 class="text-3xl font-bold text-black mb-8">
                        {{ translate('product_description') ?? 'Product Description' }}
                    </h2>
                    <div class="bg-white p-8 rounded-lg shadow-[0_2px_8px_rgba(0,0,0,0.05)]">
                        <div class="text-[0.95rem] leading-[1.8] text-[#333333] product-description">
                            {!! $product->details !!}
                        </div>
                    </div>
                </div>
            </section>
        @endif

        <!-- Related Products Section -->
        @if(isset($relatedProducts) && $relatedProducts->count() > 0)
            <section class="py-12 bg-white">
                <div class="max-w-[1400px] mx-auto px-4">
                    <div class="flex justify-between items-center mb-8">
                        <h2 class="text-2xl font-bold text-black">{{ translate('related_products') ?? 'Related Products' }}</h2>
                        @if($productCategory)
                            <div class="flex items-center gap-4">
                                <a href="{{ route('products', ['data_from' => 'category', 'id' => $productCategory->id]) }}"
                                    class="text-sm text-[#2D5F3F] no-underline flex items-center gap-1 font-medium hover:underline">
                                    <span>{{ $productCategory->name ?? '' }}</span>
                                    <i class="fas fa-chevron-right text-xs"></i>
                                </a>
                                <div class="flex gap-2">
                                    <button
                                        class="w-9 h-9 border border-[#E0E0E0] rounded-full bg-white cursor-pointer flex items-center justify-center transition-all duration-300 hover:bg-[#FA582C] hover:border-[#FA582C] hover:text-white related-prev">
                                        <i class="fas fa-chevron-left"></i>
                                    </button>
                                    <button
                                        class="w-9 h-9 border border-[#E0E0E0] rounded-full bg-white cursor-pointer flex items-center justify-center transition-all duration-300 hover:bg-[#FA582C] hover:border-[#FA582C] hover:text-white related-next">
                                        <i class="fas fa-chevron-right"></i>
                                    </button>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="related-products-slider product-slider">
                        @foreach($relatedProducts->take(10) as $relatedProduct)
                            @include('web-views.partials.product-card', ['product' => $relatedProduct, 'decimal_point_settings' => $decimalPointSettings ?? 0])
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        <!-- Recently Viewed Section -->
        <section class="py-12">
            <div class="max-w-[1400px] mx-auto px-4">
                <div class="flex justify-between items-center mb-8">
                    <h2 class="text-2xl font-bold text-black">Recently Viewed</h2>
                    <div class="flex gap-2">
                        <button
                            class="w-9 h-9 border border-[#E0E0E0] rounded-full bg-white cursor-pointer flex items-center justify-center transition-all duration-300 hover:bg-[#FA582C] hover:border-[#FA582C] hover:text-white recently-prev">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <button
                            class="w-9 h-9 border border-[#E0E0E0] rounded-full bg-white cursor-pointer flex items-center justify-center transition-all duration-300 hover:bg-[#FA582C] hover:border-[#FA582C] hover:text-white recently-next">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                </div>
                <div class="recently-viewed-slider" id="recently-viewed-container">
                    <!-- Products will be loaded dynamically from cookies via JavaScript -->
                    <div class="text-center py-8 text-gray-500">Loading recently viewed products...</div>
                </div>
            </div>
        </section>
    </main>
@endsection

@push('script')
    <script>
        // Track product view
        $(document).ready(function() {
            const productData = $('#product-details-page');
            if (productData.length) {
                const productId = productData.data('product-id');
                const productSlug = productData.data('product-slug');
                const productName = productData.data('product-name');
                const productImage = productData.data('product-image');
                const productPrice = productData.data('product-price');
                
                if (productId && typeof addToRecentlyViewed !== 'undefined') {
                    addToRecentlyViewed(productId, productSlug, productName, productImage, productPrice);
                }
            }
        });

        // Quantity Selector
        let quantity = 1;
        const quantityDisplay = document.getElementById('quantity-display');
        const increaseBtn = document.getElementById('increase-quantity');
        const decreaseBtn = document.getElementById('decrease-quantity');

        increaseBtn.addEventListener('click', () => {
            quantity++;
            quantityDisplay.textContent = quantity;
        });

        decreaseBtn.addEventListener('click', () => {
            if (quantity > 1) {
                quantity--;
                quantityDisplay.textContent = quantity;
            }
        });

        // Product Image Gallery
        const thumbnails = document.querySelectorAll('.product-thumbnail');
        const mainImage = document.getElementById('main-product-image');

        thumbnails.forEach(thumbnail => {
            thumbnail.addEventListener('click', () => {
                // Remove active class from all thumbnails
                thumbnails.forEach(t => {
                    t.classList.remove('border-[3px]', 'border-[#FA582C]');
                    t.classList.add('border-2', 'border-[#E0E0E0]');
                });
                // Add active class to clicked thumbnail
                thumbnail.classList.remove('border-2', 'border-[#E0E0E0]');
                thumbnail.classList.add('border-[3px]', 'border-[#FA582C]');
                // Update main image
                const imageSrc = thumbnail.getAttribute('data-image');
                mainImage.src = imageSrc;
            });
        });

        // Variant Selection
        const variantButtons = document.querySelectorAll('.product-variant-btn');
        let selectedVariant = null;
        let selectedVariantPrice = null;

        variantButtons.forEach(button => {
            button.addEventListener('click', function() {
                if ($(this).hasClass('opacity-50')) return; // Skip if out of stock
                
                // Remove active state from all buttons
                variantButtons.forEach(btn => {
                    btn.classList.remove('border-[#96C43C]');
                    btn.classList.add('border-[#E0E0E0]');
                });
                // Add active state to clicked button
                $(this).removeClass('border-[#E0E0E0]');
                $(this).addClass('border-[#96C43C]');

                selectedVariant = $(this).data('variant');
                selectedVariantPrice = $(this).data('variant-discounted-price');
                const originalPrice = $(this).data('variant-original-price');
                
                // Update displayed price
                $('#product-price').text(selectedVariantPrice);
                $('.text-lg.font-semibold.text-\\[\\#666666\\].line-through').text(originalPrice);
                
                console.log('Selected variant:', selectedVariant, 'Price:', selectedVariantPrice);
            });
        });

        // Color Selection
        const colorButtons = document.querySelectorAll('.product-color-btn');
        colorButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Remove active state from all color buttons
                colorButtons.forEach(btn => {
                    btn.classList.remove('border-[#96C43C]');
                    btn.classList.add('border-gray-300');
                });
                // Add active state to clicked button
                $(this).removeClass('border-gray-300');
                $(this).addClass('border-[#96C43C]');
                
                const selectedColor = $(this).data('color');
                console.log('Selected color:', selectedColor);
                // You can update product image based on color here if color_image is available
            });
        });

        // Add to Cart Button Handler
        $('#btn-add-to-cart').on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            e.stopImmediatePropagation();
            
            const $btn = $(this);
            const productId = $btn.data('product-id');
            const quantity = parseInt($('#quantity-display').text()) || 1;
            const variant = selectedVariant;
            
            if (!productId) {
                console.error('Product ID not found');
                if (typeof toastr !== 'undefined') {
                    toastr.error('Product ID not found');
                }
                return false;
            }
            
            // Disable button during request
            $btn.prop('disabled', true);
            
            const cartAddUrl = $('#route-data').data('route-cart-add') || '{{ route("cart.add") }}';
            
            $.ajax({
                url: cartAddUrl,
                method: 'POST',
                data: {
                    _token: $('meta[name="_token"]').attr('content'),
                    id: productId,
                    quantity: quantity,
                    variant: variant || null
                },
                success: function(response) {
                    $btn.prop('disabled', false);
                    
                    // Response can be object with status or just HTML string
                    let isSuccess = false;
                    if (typeof response === 'object' && response.status === 1) {
                        isSuccess = true;
                    } else if (typeof response === 'string') {
                        // HTML response means success
                        isSuccess = true;
                    }
                    
                    if (isSuccess) {
                        if (typeof toastr !== 'undefined') {
                            toastr.success('{{ translate("product_added_to_cart") ?? "Product added to cart successfully" }}');
                        }
                        
                        // Update cart count
                        if (typeof updateCartCountGreenmarket === 'function') {
                            updateCartCountGreenmarket();
                        }
                        
                        // Reload page to update cart sidebar
                        window.location.reload();
                    } else {
                        const errorMsg = (typeof response === 'object' && response.message) 
                            ? response.message 
                            : 'Failed to add product to cart';
                        if (typeof toastr !== 'undefined') {
                            toastr.error(errorMsg);
                        }
                    }
                },
                error: function(xhr) {
                    $btn.prop('disabled', false);
                    const errorMsg = xhr.responseJSON?.message || 'Failed to add product to cart';
                    if (typeof toastr !== 'undefined') {
                        toastr.error(errorMsg);
                    }
                }
            });
            
            return false;
        });

        // Check if product exists in cart
        function checkProductInCart(productId, variant, callback) {
            // First check the current cart sidebar DOM
            let productExists = false;
            const $cartItems = $('#cart-sidebar .cart-item');
            
            if ($cartItems.length > 0) {
                $cartItems.each(function() {
                    const $item = $(this);
                    const itemProductId = $item.data('product-id');
                    
                    // Check if product ID matches
                    if (itemProductId == productId) {
                        // If variant is specified, we should check it too
                        // For now, if product ID matches, consider it exists
                        // (The add to cart will handle variant updates if needed)
                        productExists = true;
                        return false; // Break loop
                    }
                });
            }
            
            // If found in DOM, return immediately
            if (productExists) {
                if (typeof callback === 'function') {
                    callback(true);
                }
                return;
            }
            
            // If not found in DOM, check via AJAX to get fresh cart data
            const navCartUrl = $('#route-data').data('route-cart-nav') || '{{ route("cart.nav-cart") }}';
            
            $.ajax({
                url: navCartUrl,
                method: 'POST',
                data: {
                    _token: $('meta[name="_token"]').attr('content')
                },
                success: function(response) {
                    let foundInCart = false;
                    
                    if (response && response.data) {
                        // Parse the cart HTML to check if product exists
                        const $cartHtml = $(response.data);
                        $cartHtml.find('.cart-item').each(function() {
                            const $item = $(this);
                            const itemProductId = $item.data('product-id');
                            
                            // Check if product ID matches
                            if (itemProductId == productId) {
                                foundInCart = true;
                                return false; // Break loop
                            }
                        });
                    }
                    
                    if (typeof callback === 'function') {
                        callback(foundInCart);
                    }
                },
                error: function() {
                    // On error, assume product doesn't exist and proceed
                    if (typeof callback === 'function') {
                        callback(false);
                    }
                }
            });
        }

        // Buy Now Button Handler - Check cart, add if needed, then open checkout modal
        $(document).on('click', '.buy-now-btn', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const $btn = $(this);
            const productId = $btn.data('product-id');
            const quantity = parseInt($('#quantity-display').text()) || 1;
            const variant = selectedVariant;
            
            if (!productId) {
                console.error('Product ID not found');
                if (typeof toastr !== 'undefined') {
                    toastr.error('Product ID not found');
                }
                return false;
            }
            
            // Disable button during request
            $btn.prop('disabled', true);
            
            // First, check if product already exists in cart
            checkProductInCart(productId, variant, function(productExists) {
                if (productExists) {
                    // Product already in cart, just open checkout modal
                    $btn.prop('disabled', false);
                    
                    // Update cart count
                    if (typeof updateCartCountGreenmarket === 'function') {
                        updateCartCountGreenmarket();
                    }
                    
                    // Open checkout modal
                    if (typeof openCheckoutModal === 'function') {
                        openCheckoutModal();
                    } else {
                        // Fallback to redirect if modal function not available
                        window.location.href = '{{ route("checkout-details") }}';
                    }
                } else {
                    // Product not in cart, add it first
                    const cartAddUrl = $('#route-data').data('route-cart-add') || '{{ route("cart.add") }}';
                    
                    $.ajax({
                        url: cartAddUrl,
                        method: 'POST',
                        data: {
                            _token: $('meta[name="_token"]').attr('content'),
                            id: productId,
                            quantity: quantity,
                            variant: variant || null
                        },
                        success: function(response) {
                            $btn.prop('disabled', false);
                            
                            // Response can be object with status or just HTML string
                            let isSuccess = false;
                            if (typeof response === 'object' && response.status === 1) {
                                isSuccess = true;
                            } else if (typeof response === 'string') {
                                // HTML response means success
                                isSuccess = true;
                            }
                            
                            if (isSuccess) {
                                // Update cart count
                                if (typeof updateCartCountGreenmarket === 'function') {
                                    updateCartCountGreenmarket();
                                }
                                
                                // Wait a bit for cart to update, then open checkout modal
                                setTimeout(function() {
                                    // Open checkout modal
                                    if (typeof openCheckoutModal === 'function') {
                                        openCheckoutModal();
                                    } else {
                                        // Fallback to redirect if modal function not available
                                        window.location.href = '{{ route("checkout-details") }}';
                                    }
                                }, 500);
                            } else {
                                const errorMsg = (typeof response === 'object' && response.message) 
                                    ? response.message 
                                    : 'Failed to add product to cart';
                                if (typeof toastr !== 'undefined') {
                                    toastr.error(errorMsg);
                                }
                            }
                        },
                        error: function(xhr) {
                            $btn.prop('disabled', false);
                            const errorMsg = xhr.responseJSON?.message || 'Failed to add product to cart';
                            if (typeof toastr !== 'undefined') {
                                toastr.error(errorMsg);
                            }
                        }
                    });
                }
            });
            
            return false;
        });

        // Initialize Sliders
        $(document).ready(function() {
            // Initialize Related Products Slider
            if ($('.related-products-slider').length && $('.related-products-slider').children().length > 0) {
                $('.related-products-slider').slick({
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
                        },
                        {
                            breakpoint: 768,
                            settings: {
                                slidesToShow: 2
                            }
                        },
                        {
                            breakpoint: 576,
                            settings: {
                                slidesToShow: 1
                            }
                        }
                    ]
                });

                $('.related-prev').click(function() {
                    $('.related-products-slider').slick('slickPrev');
                });

                $('.related-next').click(function() {
                    $('.related-products-slider').slick('slickNext');
                });
            }

            // Initialize Recently Viewed Slider
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
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 2
                        }
                    },
                    {
                        breakpoint: 576,
                        settings: {
                            slidesToShow: 1
                        }
                    }
                ]
            });

            $('.recently-prev').click(function() {
                $('.recently-viewed-slider').slick('slickPrev');
            });

            $('.recently-next').click(function() {
                $('.recently-viewed-slider').slick('slickNext');
            });
        });
    </script>
@endpush
