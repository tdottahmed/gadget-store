<!-- Featured Products Section -->
<section class="bg-white py-12">
  <div class="container-ds">
    <h2 class="mb-8 text-3xl font-bold uppercase tracking-wider text-[#212529]">
      {{ translate('featured_products') ?? 'Featured Products' }}</h2>
    <div class="featured-products-slider product-slider">
      @php
        $featuredProducts = $featuredProductsList ?? collect([]);
        $decimal_point_settings = $decimal_point_settings ?? (getWebConfig(name: 'decimal_point_settings') ?? 0);
      @endphp
      @if ($featuredProducts->count() > 0)
        @foreach ($featuredProducts->take(12) as $product)
          @include('web-views.partials.product-card', [
              'product' => $product,
              'decimal_point_settings' => $decimal_point_settings,
          ])
        @endforeach
      @else
        @for ($i = 0; $i < 12; $i++)
          @include('web-views.partials.product-card')
        @endfor
      @endif
    </div>
  </div>
</section>
