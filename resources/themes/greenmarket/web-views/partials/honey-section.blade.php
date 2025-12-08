<!-- Honey Section -->
<section class="py-12 bg-neutral-off-white">
    <div class="container-ds">
        <h2 class="text-3xl font-bold text-[#212529] mb-8 uppercase tracking-wider">Honey</h2>
        <div class="honey-slider product-slider">
            @php
                $honeyProducts = $honeyProducts ?? collect([]);
                $decimal_point_settings = $decimal_point_settings ?? getWebConfig(name: 'decimal_point_settings') ?? 0;
            @endphp
            @if($honeyProducts->count() > 0)
                @foreach($honeyProducts->take(10) as $product)
                    @include('web-views.partials.product-card', ['product' => $product, 'decimal_point_settings' => $decimal_point_settings])
                @endforeach
            @else
                {{-- Fallback: Use featured products if no honey products --}}
                @php
                    $fallbackProducts = $featuredProductsList ?? collect([]);
                @endphp
                @if($fallbackProducts->count() > 0)
                    @foreach($fallbackProducts->take(10) as $product)
                        @include('web-views.partials.product-card', ['product' => $product, 'decimal_point_settings' => $decimal_point_settings])
                    @endforeach
                @else
                    @for($i = 0; $i < 10; $i++)
                        @include('web-views.partials.product-card')
                    @endfor
                @endif
            @endif
        </div>
    </div>
</section>

