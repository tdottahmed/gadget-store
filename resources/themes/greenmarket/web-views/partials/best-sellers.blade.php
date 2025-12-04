<!-- Our Best Sellers Section -->
<section class="py-5 bg-white">
    <div class="container-ds">
        <h2 class="text-3xl font-bold text-[#212529] mb-8 uppercase tracking-wider">OUR BEST SELLERS</h2>
        <div class="bestsellers-slider product-slider">
            @php
                $bestSellProducts = $bestSellProduct ?? collect([]);
                $decimal_point_settings = $decimal_point_settings ?? getWebConfig(name: 'decimal_point_settings') ?? 0;
            @endphp
            @if($bestSellProducts->count() > 0)
                @foreach($bestSellProducts->take(10) as $product)
                    @include('web-views.partials.product-card', ['product' => $product, 'decimal_point_settings' => $decimal_point_settings])
                @endforeach
            @else
                {{-- Fallback: Show placeholder products if no products available --}}
                @for($i = 0; $i < 10; $i++)
                    @include('web-views.partials.product-card')
                @endfor
            @endif
        </div>
    </div>
</section>

