<!-- Wellness Section -->
<section class="py-12 bg-white">
    <div class="container-ds">
        <h2 class="text-3xl font-bold text-[#212529] mb-8 uppercase tracking-wider">Wellness</h2>
        <div class="wellness-slider product-slider">
            @php
                $wellnessProducts = $wellnessProducts ?? collect([]);
                $decimal_point_settings = $decimal_point_settings ?? getWebConfig(name: 'decimal_point_settings') ?? 0;
            @endphp
            @if($wellnessProducts->count() > 0)
                @foreach($wellnessProducts->take(10) as $product)
                    @include('web-views.partials.product-card', ['product' => $product, 'decimal_point_settings' => $decimal_point_settings])
                @endforeach
            @else
                {{-- Fallback: Use latest products if no wellness products --}}
                @php
                    $fallbackProducts = $latestProductsList ?? collect([]);
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

