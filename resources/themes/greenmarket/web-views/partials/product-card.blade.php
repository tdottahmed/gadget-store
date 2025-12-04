@php
    // Accept product data dynamically
    $product = $product ?? null;
    $productId = $product->id ?? null;
    $productSlug = $product->slug ?? 'signature-honey-combo';
    $productName = $product->name ?? 'স্প্রে ড্রাইড বিটরুট পাউডার | Spray Dried Beetroot Powder';
    $productImage = $product ? getStorageImages(path: $product->thumbnail_full_url ?? '', type: 'product') : 'https://prd.place/400';
    
    // Get product prices using Laravel helper functions
    if ($product) {
        $productPrice = getProductPriceByType(product: $product, type: 'discounted_unit_price', result: 'string');
        $productDiscountPrice = getProductPriceByType(product: $product, type: 'discount', result: 'value') > 0 
            ? webCurrencyConverter(amount: $product->unit_price) 
            : null;
    } else {
        $productPrice = '৳1,050';
        $productDiscountPrice = '৳1,550';
    }
    
    $decimalPointSettings = $decimal_point_settings ?? getWebConfig(name: 'decimal_point_settings') ?? 0;
@endphp

<!-- Product Card -->
<div class="bg-transparent rounded-lg shadow-md border-1 border-gray-50 overflow-hidden group">
    <div class="relativ p-8">
        <a href="{{ route('product', ['slug' => $productSlug]) }}">
            <img src="{{ $productImage }}" alt="{{ $productName }}"
                class="w-full h-64 object-contain">
        </a>
    </div>
    <div class="bg-[#F2F2F2] flex">
        <a href="{{ route('product', ['slug' => $productSlug]) }}" class="flex-1 py-3 flex items-center justify-center border-r hover:cursor-pointer border-gray-200"
                >
            <i class="fa-regular fa-eye"></i>
        </a>
        <button class="flex-1 py-3 flex items-center justify-center hover:cursor-pointer add-to-cart-btn"
                data-product-id="{{ $productId }}"
                data-product-slug="{{ $productSlug }}">
            <i class="fas fa-shopping-cart text-lg md:text-xl"></i>
        </button>
    </div>
    <div class="p-4">
        <a href="{{ route('product', ['slug' => $productSlug]) }}">
            <h3 class="text-sm font-bold text-[#222222] mb-2 line-clamp-2">{{ $productName }}</h3>
        </a>
        <div class="flex items-center gap-2">
            <span class="text-2xl font-bold text-[#669900]">{{ $productPrice }}</span>
            @if($productDiscountPrice && $productDiscountPrice != $productPrice)
                <span class="text-medium text-[#afb4be] line-through">{{ $productDiscountPrice }}</span>
            @endif
        </div>
    </div>
</div>
