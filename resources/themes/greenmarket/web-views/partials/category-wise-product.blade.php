@php
  // Accept category data dynamically
  $category = $category ?? null;
  $categoryId = $category->id ?? null;
  $categoryName = $category->name ?? translate('category');
  $categoryProducts = $category->products ?? collect([]);
  $decimal_point_settings = $decimal_point_settings ?? (getWebConfig(name: 'decimal_point_settings') ?? 0);
@endphp

@if ($category && $categoryProducts->count() > 0)
  <!-- Category Products Section -->
  <section class="bg-neutral-off-white py-12">
    <div class="container-ds">
      <div class="mb-8 flex items-center justify-between">
        <h2 class="text-3xl font-bold uppercase tracking-wider text-[#212529]">{{ $categoryName }}</h2>
        <a href="{{ route('category.view', ['id' => $categoryId]) }}"
           class="text-primary-dynamic flex items-center gap-2 text-sm font-semibold transition-colors hover:text-[#2d8659] md:text-base">
          {{ translate('view_more') ?? 'View More' }}
          <i class="fas fa-arrow-right"></i>
        </a>
      </div>
      <div class="product-slider">
        @foreach ($categoryProducts->take(12) as $product)
          @include('web-views.partials.product-card', [
              'product' => $product,
              'decimal_point_settings' => $decimal_point_settings,
          ])
        @endforeach
      </div>
    </div>
  </section>
@endif
