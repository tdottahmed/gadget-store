@extends('web-views.layouts.app')

@section('title', 'সিগনেচার হানি কম্বো | Signature Honey Combo - ' . $web_config['company_name'])

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
            background: linear-gradient(135deg, #2d8659 0%, #1a5f3f 100%);
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
            color: #2d8659;
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
            color: #2d8659;
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
            background-color: #000f06 !important;
        }

        .main-header-bg,
        .footer-bg,
        .whatsapp-bg {
            background-color: #003315 !important;
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
    @php
        $productId = $product->id ?? null;
        $productSlug = $product->slug ?? '';
        $productName = $product->name ?? '';
        $productImage = $product ? getStorageImages(path: $product->thumbnail_full_url ?? '', type: 'product') : '';
        $productPrice = $product ? getProductPriceByType(product: $product, type: 'discounted_unit_price', result: 'string') : '';
    @endphp
    <div id="product-details-page" 
         data-product-id="{{ $productId }}"
         data-product-slug="{{ $productSlug }}"
         data-product-name="{{ $productName }}"
         data-product-image="{{ $productImage }}"
         data-product-price="{{ $productPrice }}"
         style="display: none;">
    </div>

    <!-- Main Content -->
    <main class="container-ds">
        <!-- Product Section -->
        <section class=" mx-auto px-4 py-8">
            <div class="grid grid-cols-1 bg-white p-10 md:grid-cols-2 gap-12 py-8">
                <!-- Product Gallery -->
                <div class="relative top-20 md:top-20">
                    <div class="flex flex-col gap-4">
                        <div
                            class="w-full aspect-square bg-white border border-[#F0F0F0] rounded-lg p-8 flex items-center justify-center">
                            <img id="main-product-image"
                                src="{{ $productImage ?: 'https://pub-b80211003304448e8a7f0edc480f0608.r2.dev/product-page/01_KMG5dpqlvj.webp' }}"
                                alt="{{ $productName ?: 'সিগনেচার হানি কম্বো' }}" class="w-full h-full object-contain">
                        </div>
                        <div
                            class="flex flex-row gap-3 justify-center flex-wrap overflow-x-auto pb-2">
                            <div class="product-thumbnail min-w-[70px] md:w-20 w-[70px] h-[70px] md:h-20 border-[3px] border-[#FA582C] rounded-md p-2 cursor-pointer transition-all duration-300 bg-white flex items-center justify-center flex-shrink-0"
                                data-image="https://pub-b80211003304448e8a7f0edc480f0608.r2.dev/product-page/01_KMG5dpqlvj.webp">
                                <img src="https://pub-b80211003304448e8a7f0edc480f0608.r2.dev/product-page/01_KMG5dpqlvj.webp"
                                    alt="Thumbnail 1" class="w-full h-full object-contain">
                            </div>
                            <div class="product-thumbnail min-w-[70px] md:w-20 w-[70px] h-[70px] md:h-20 border-2 border-[#E0E0E0] rounded-md p-2 cursor-pointer transition-all duration-300 bg-white flex items-center justify-center flex-shrink-0 hover:border-[#FA582C]"
                                data-image="https://pub-b80211003304448e8a7f0edc480f0608.r2.dev/product-page/02_KMGme6vvb.webp">
                                <img src="https://pub-b80211003304448e8a7f0edc480f0608.r2.dev/product-page/02_KMGme6vvb.webp"
                                    alt="Thumbnail 2" class="w-full h-full object-contain">
                            </div>
                            <div class="product-thumbnail min-w-[70px] md:w-20 w-[70px] h-[70px] md:h-20 border-2 border-[#E0E0E0] rounded-md p-2 cursor-pointer transition-all duration-300 bg-white flex items-center justify-center flex-shrink-0 hover:border-[#FA582C]"
                                data-image="https://pub-b80211003304448e8a7f0edc480f0608.r2.dev/product-page/03_KMG2b3nx.webp">
                                <img src="https://pub-b80211003304448e8a7f0edc480f0608.r2.dev/product-page/03_KMG2b3nx.webp"
                                    alt="Thumbnail 3" class="w-full h-full object-contain">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product Info -->
                <div class="py-4 mt-14 md:mt-0">
                    <h1 id="product-name" class="text-xl md:text-xl lg:text-3xl font-semibold text-black mb-4 leading-tight">
                        {{ $productName ?: 'সিগনেচার হানি কম্বো | Signature Honey Combo' }}
                    </h1>

                    <div class="flex items-center gap-3 mb-6">
                        @if($product && getProductPriceByType(product: $product, type: 'discount', result: 'value') > 0)
                            <span class="text-lg font-semibold text-[#666666] line-through">{{ webCurrencyConverter(amount: $product->unit_price) }}</span>
                        @endif
                        <span id="product-price" class="text-xl md:text-2xl font-semibold text-[#FA582C]">
                            {{ $productPrice ?: '৳1,800' }}
                        </span>
                        @if($product && getProductPriceByType(product: $product, type: 'discount', result: 'value') > 0)
                            <span class="inline-block px-2 py-1 bg-[#DD3737] text-white rounded-2xl text-sm font-semibold">
                                {{ getProductPriceByType(product: $product, type: 'discount', result: 'value') }}% OFF
                            </span>
                        @endif
                    </div>

                    <!-- Weight/Variant Selection -->
                    <div class="mb-6">
                        <label class="block font-semibold text-[#333333] mb-3">বাছাই করুন:</label>
                        <div class="flex gap-4 flex-wrap md:flex-row flex-col">
                            <button
                                class="relative px-4 py-2 border-2 border-[#96C43C] rounded-md text-[#333333] text-sm font-semibold cursor-pointer flex items-center gap-2 md:w-auto w-full justify-between"
                                data-variant="600g">
                                <span class="text-base font-semibold">৬০০ গ্রাম</span>
                                <span
                                    class="bg-gray-100 text-[#DD3737] px-2 rounded-3xl text-[10px] font-bold  top-[-22px] -right-[0px]">32%
                                    OFF</span>
                            </button>
                            <button
                                class="relative px-4 py-2 rounded-md bg-white text-[#333333] text-sm font-semibold cursor-pointer flex items-center gap-2 md:w-auto w-full justify-between border-2 border-[#E0E0E0]"
                                data-variant="250g">
                                <span class="text-base font-semibold">২৫০ গ্রাম</span>
                                <span
                                    class="bg-gray-100 text-[#DD3737] px-2 rounded-3xl text-[10px] font-bold  top-[-22px] -right-[0px]">17%
                                    OFF</span>
                            </button>
                        </div>
                    </div>

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
                            class="w-full px-6 py-3 bg-[#FA582C] text-white border-none rounded-md text-base font-bold cursor-pointer transition-all duration-300 flex items-center justify-center gap-2 hover:bg-[#FF5520] hover:-translate-y-0.5 hover:shadow-[0_4px_12px_rgba(255,107,53,0.3)]">
                            <i class="fas fa-shopping-bag"></i>
                            <span>অর্ডার করুন</span>
                        </button>
                    </div>

                    <a href="tel:09639812525"
                        class="text-black py-3 px-6 border-black border-2 rounded-md flex items-center gap-2 w-full justify-center cursor-pointer mt-3 "><span
                            class="text-[14px] font-semibold">কল অর্ডার: 09639812525</span></a>

                    <div class="inline-flex items-center gap-2 text-sm text-[#666666] mt-10 py-2">
                        <span class="font-semibold text-black">ক্যাটাগরি:</span>
                        <a href="#" class="text-[#2D5F3F] no-underline hover:underline">Combo</a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Product Description Section -->
        <section class="bg-[#F9F9F9] py-12 mt-12">
            <div class="max-w-[1400px] mx-auto px-4">
                <h2 class="text-3xl font-bold text-black mb-8 flex items-center gap-2">
                    <span>🍯</span>
                    <span>সিগনেচার হানি কম্বো</span>
                </h2>
                <div class="bg-white p-8 rounded-lg shadow-[0_2px_8px_rgba(0,0,0,0.05)]">
                    <p class="text-[0.95rem] leading-[1.8] text-[#333333] mb-4">
                        <strong>৪ ধরনের ফুল, ৪টি স্বাম, ৪টি গুণ—এক সাথে এক কম্বোতে!</strong>
                    </p>

                    <h3 class="text-lg font-bold text-black mt-6 mb-4 flex items-center gap-2">কম্বোতে যা থাকবে:</h3>
                    <ul class="list-none p-0 m-0 flex flex-col gap-4">
                        <li class="text-[0.95rem] leading-[1.6] text-[#333333] flex items-start gap-3 py-2">
                            <i class="fas fa-check-circle text-xl mt-0.5 flex-shrink-0 text-[#00A651]"></i>
                            <span>কালোজিরা ফুলের মধু- ৫০০ গ্রাম</span>
                        </li>
                        <li class="text-[0.95rem] leading-[1.6] text-[#333333] flex items-start gap-3 py-2">
                            <i class="fas fa-check-circle text-xl mt-0.5 flex-shrink-0 text-[#00A651]"></i>
                            <span>সুন্দরবনের খলিশা ফুলের মধু- ৫০০ গ্রাম</span>
                        </li>
                        <li class="text-[0.95rem] leading-[1.6] text-[#333333] flex items-start gap-3 py-2">
                            <i class="fas fa-check-circle text-xl mt-0.5 flex-shrink-0 text-[#00A651]"></i>
                            <span>সরিষা ফুলের মধু- ৫০০ গ্রাম</span>
                        </li>
                        <li class="text-[0.95rem] leading-[1.6] text-[#333333] flex items-start gap-3 py-2">
                            <i class="fas fa-check-circle text-xl mt-0.5 flex-shrink-0 text-[#00A651]"></i>
                            <span>ধনিয়া-মিশ্র ফুলের মধু- ৫০০ গ্রাম</span>
                        </li>
                    </ul>

                    <p class="text-[0.95rem] leading-[1.8] text-[#333333] mb-4">
                        <strong>প্রাকৃতিকভাবে সংগ্রহকৃত বিশুদ্ধ যাঁচি মধু</strong><br>
                        আমাদের এই মধু সম্পূর্ণ প্রাকৃতিকভাবে সংগ্রহ করা হয়েছে। কোনো রাসায়নিক, প্রিজারভেটিভ বা কৃত্রিম
                        উপাদান নেই।
                        প্রতিটি বোতল ল্যাব টেস্ট করা হয়েছে এবং ১০০% বিশুদ্ধতা নিশ্চিত করা হয়েছে।
                    </p>

                    <h3 class="text-lg font-bold text-black mt-6 mb-4 flex items-center gap-2">মধুর উপকারিতা:</h3>
                    <ul class="list-none p-0 m-0 flex flex-col gap-4">
                        <li class="text-[0.95rem] leading-[1.6] text-[#333333] flex items-start gap-3 py-2">
                            <i class="fas fa-check-circle text-xl mt-0.5 flex-shrink-0 text-[#00A651]"></i>
                            <span>রোগ প্রতিরোধ ক্ষমতা বৃদ্ধি</span>
                        </li>
                        <li class="text-[0.95rem] leading-[1.6] text-[#333333] flex items-start gap-3 py-2">
                            <i class="fas fa-check-circle text-xl mt-0.5 flex-shrink-0 text-[#00A651]"></i>
                            <span>হজমে সহায়তা</span>
                        </li>
                        <li class="text-[0.95rem] leading-[1.6] text-[#333333] flex items-start gap-3 py-2">
                            <i class="fas fa-check-circle text-xl mt-0.5 flex-shrink-0 text-[#00A651]"></i>
                            <span>গলা ব্যথা ও কাশিতে উপকারী</span>
                        </li>
                        <li class="text-[0.95rem] leading-[1.6] text-[#333333] flex items-start gap-3 py-2">
                            <i class="fas fa-check-circle text-xl mt-0.5 flex-shrink-0 text-[#00A651]"></i>
                            <span>শক্তি ও প্রাণশক্তি বৃদ্ধি</span>
                        </li>
                        <li class="text-[0.95rem] leading-[1.6] text-[#333333] flex items-start gap-3 py-2">
                            <i class="fas fa-check-circle text-xl mt-0.5 flex-shrink-0 text-[#00A651]"></i>
                            <span>পাকৃতিক অ্যান্টি-অক্সিডেন্টে ভরপুর</span>
                        </li>
                    </ul>

                    <h3 class="text-lg font-bold text-black mt-6 mb-4 flex items-center gap-2">কেন এই কম্বো?</h3>
                    <ul class="list-none p-0 m-0 flex flex-col gap-4">
                        <li class="text-[0.95rem] leading-[1.6] text-[#333333] flex items-start gap-3 py-2">
                            <i class="fas fa-check-circle text-xl mt-0.5 flex-shrink-0 text-[#00A651]"></i>
                            <span>একসাথে ৪ ধরনের ফুলের ভিন্ন স্বাদের মধু</span>
                        </li>
                        <li class="text-[0.95rem] leading-[1.6] text-[#333333] flex items-start gap-3 py-2">
                            <i class="fas fa-check-circle text-xl mt-0.5 flex-shrink-0 text-[#00A651]"></i>
                            <span>প্রাকৃতিকভাবে উৎপাদিত ও ল্যাব টেস্টেও</span>
                        </li>
                        <li class="text-[0.95rem] leading-[1.6] text-[#333333] flex items-start gap-3 py-2">
                            <i class="fas fa-check-circle text-xl mt-0.5 flex-shrink-0 text-[#00A651]"></i>
                            <span>নিজে খাওয়ার জন্য বা উপহার দেওয়ার জন্য উপযুক্ত</span>
                        </li>
                    </ul>

                    <h3 class="text-lg font-bold text-black mt-6 mb-4 flex items-center gap-2"># শতভাগ প্রাকৃতিক:</h3>
                    <p class="text-[0.95rem] leading-[1.8] text-[#333333] mb-4">
                        আমাদের মধুতে কোনো রাসায়নিক, প্রিজারভেটিভ বা কৃত্রিম উপাদান নেই। সম্পূর্ণ প্রাকৃতিক এবং বিশুদ্ধ।
                    </p>

                    <h3 class="text-lg font-bold text-black mt-6 mb-4 flex items-center gap-2"># নির্ভরযোগ্য
                        প্রক্রিয়াজাতকরণ:</h3>
                    <p class="text-[0.95rem] leading-[1.8] text-[#333333] mb-4">
                        প্রতিটি বোতল ল্যাব টেস্ট করা হয়েছে এবং বিশুদ্ধতা নিশ্চিত করা হয়েছে। নিরাপদ এবং স্বাস্থ্যসম্মত
                        প্রক্রিয়াজাতকরণ।
                    </p>

                    <h3 class="text-lg font-bold text-black mt-6 mb-4 flex items-center gap-2"># প্রাকৃতিক পণ্যে
                        অঙ্গীকারবদ্ধ:</h3>
                    <p class="text-[0.95rem] leading-[1.8] text-[#333333] mb-4">
                        NATURO "BACK TO NATURE" অঙ্গীকারের সাথে সম্পূর্ণ প্রাকৃতিক পণ্য সরবরাহ করে। আমরা প্রকৃতির
                        শক্তিতে বিশ্বাস করি।
                    </p>

                    <h3 class="text-lg font-bold text-black mt-6 mb-4 flex items-center gap-2"># গ্রাহক সন্তুষ্টি:</h3>
                    <p class="text-[0.95rem] leading-[1.8] text-[#333333] mb-4">
                        আমাদের হাজার হাজার সন্তুষ্ট গ্রাহক আমাদের পণ্যের গুণমান এবং সেবার সাক্ষী। আপনার সন্তুষ্টিই
                        আমাদের সাফল্য।
                    </p>
                </div>
            </div>
        </section>

        <!-- Related Products Section -->
        {{-- <section class="py-12 bg-white">
            <div class="max-w-[1400px] mx-auto px-4">
                <div class="flex justify-between items-center mb-8">
                    <h2 class="text-2xl font-bold text-black">Related Products</h2>
                    <div class="flex items-center gap-4">
                        <a href="#"
                            class="text-sm text-[#2D5F3F] no-underline flex items-center gap-1 font-medium hover:underline">
                            <span>Combo</span>
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
                </div>
                <div class="related-products-slider">
                    @include('web-views.partials.product-card')
                    @include('web-views.partials.product-card')
                    @include('web-views.partials.product-card')
                    @include('web-views.partials.product-card')
                    @include('web-views.partials.product-card')
                    @include('web-views.partials.product-card')
                </div>
            </div>
        </section> --}}

        <!-- Recently Viewed Section -->
        <section class="py-12 bg-[#F9F9F9]">
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
        const variantButtons = document.querySelectorAll('[data-variant]');
        let selectedVariant = null;

        variantButtons.forEach(button => {
            button.addEventListener('click', () => {
                // Remove active state from all buttons
                variantButtons.forEach(btn => {
                    btn.classList.remove('border-[#96C43C]', 'border-2');
                    btn.classList.add('border-[#E0E0E0]', 'border-2');
                });
                // Add active state to clicked button
                button.classList.remove('border-[#E0E0E0]');
                button.classList.add('border-[#96C43C]', 'border-2');

                selectedVariant = button.getAttribute('data-variant');
                console.log('Selected variant:', selectedVariant);
                // You can update price based on variant here
            });
        });

        // Add to Cart Button Handler
        $('#btn-add-to-cart').on('click', function() {
            const productId = $(this).data('product-id');
            const quantity = parseInt($('#quantity-display').text());
            const variant = selectedVariant;
            
            if (productId && typeof addToCartGreenmarket !== 'undefined') {
                addToCartGreenmarket(productId, quantity, variant);
            } else {
                // Fallback to form submission if function not available
                console.error('addToCartGreenmarket function not found');
            }
        });

        // Initialize Sliders
        $(document).ready(function() {
            // Initialize Related Products Slider
            // $('.related-products-slider').slick({
            //     slidesToShow: 4,
            //     slidesToScroll: 1,
            //     infinite: true,
            //     arrows: false,
            //     dots: false,
            //     responsive: [{
            //             breakpoint: 992,
            //             settings: {
            //                 slidesToShow: 3
            //             }
            //         },
            //         {
            //             breakpoint: 768,
            //             settings: {
            //                 slidesToShow: 2
            //             }
            //         },
            //         {
            //             breakpoint: 576,
            //             settings: {
            //                 slidesToShow: 1
            //             }
            //         }
            //     ]
            // });

            $('.related-prev').click(function() {
                $('.related-products-slider').slick('slickPrev');
            });

            $('.related-next').click(function() {
                $('.related-products-slider').slick('slickNext');
            });

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
