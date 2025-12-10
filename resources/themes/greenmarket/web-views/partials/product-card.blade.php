@php

    // dd($product);
    // Accept product data dynamically
    $product = $product ?? null;
    $productId = $product->id ?? null;
    $productSlug = $product->slug ?? '';
    $productName = $product->name ?? '';
    $productImage = $product ? getStorageImages(path: $product->thumbnail_full_url ?? '', type: 'product') : 'https://placehold.co/400';
    
    // Get product prices using Laravel helper functions
    if ($product) {
        $productPrice = getProductPriceByType(product: $product, type: 'discounted_unit_price', result: 'string');
        $productDiscountPrice = getProductPriceByType(product: $product, type: 'discount', result: 'value') > 0 
            ? webCurrencyConverter(amount: $product->unit_price) 
            : null;
    } else {
        $productPrice = '0';
        $productDiscountPrice = '0';
    }
    
    $decimalPointSettings = $decimal_point_settings ?? getWebConfig(name: 'decimal_point_settings') ?? 0;
@endphp

<!-- Product Card -->
<div class="bg-transparent rounded-lg shadow-md border-1 border-gray-50 overflow-hidden group flex flex-col h-full">
    <div class="relative p-8 flex-shrink-0" style="height: 256px;">
        <a href="{{ route('product', ['slug' => $productSlug]) }}" class="block h-full">
            <img src="{{ $productImage }}" alt="{{ $productName }}"
                class="w-full h-full object-contain">
        </a>
    </div>
    <div class="flex flex-shrink-0">
        <a href="{{ route('product', ['slug' => $productSlug]) }}" class="flex-1 py-3 flex items-center justify-center border-r hover:cursor-pointer border-gray-200 text-white text-sm font-medium transition-colors bg-primary-dynamic hover:opacity-90"
                >
            ভিউ করুন
        </a>
        <button class="flex-1 py-3 flex items-center justify-center hover:cursor-pointer greenmarket-add-to-cart-btn text-white text-sm font-medium transition-colors hover:opacity-90"
                style="background-color: var(--secondary-color);"
                data-product-id="{{ $productId }}"
                data-product-slug="{{ $productSlug }}">
            কার্টে যোগ করুন
        </button>
    </div>
    <div class="p-4 flex-shrink-0 flex flex-col flex-grow">
        <a href="{{ route('product', ['slug' => $productSlug]) }}" class="flex-shrink-0">
            <h3 class="text-sm font-bold text-[#222222] mb-2 line-clamp-2 min-h-[2.5rem]">{{ $productName }}</h3>
        </a>
        <div class="flex items-center gap-2 mt-auto">
            <span class="text-2xl font-bold text-primary-dynamic">{{ $productPrice }}</span>
            @if($productDiscountPrice && $productDiscountPrice != $productPrice)
                <span class="text-medium text-[#afb4be] line-through">{{ $productDiscountPrice }}</span>
            @endif
        </div>
    </div>
</div>
