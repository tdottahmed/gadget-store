<!-- All Products Section -->
<section class="py-12 bg-neutral-off-white">
    <div class="container-ds">
        <h2 class="text-3xl font-bold text-[#212529] mb-8 uppercase tracking-wider">All Products</h2>
        <div class="grid grid-cols-1 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-4 gap-6">
            @php
                $allProducts = $latestProductsList ?? collect([]);
                $decimal_point_settings = $decimal_point_settings ?? getWebConfig(name: 'decimal_point_settings') ?? 0;
            @endphp
            @if($allProducts->count() > 0)
                @foreach($allProducts->take(12) as $product)
                    @include('web-views.partials.product-card', ['product' => $product, 'decimal_point_settings' => $decimal_point_settings])
                @endforeach
            @else
                @for($i = 0; $i < 12; $i++)
                    @include('web-views.partials.product-card')
                @endfor
            @endif
        </div>
    </div>
</section>

