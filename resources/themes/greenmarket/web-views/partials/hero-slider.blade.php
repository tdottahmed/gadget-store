<!-- Hero Section -->
<section class="relative overflow-hidden">
  @if (isset($bannerTypeHeroSlider) && $bannerTypeHeroSlider && count($bannerTypeHeroSlider) > 0)
    <div class="hero-slider hero-slider-loading">
      @foreach ($bannerTypeHeroSlider as $banner)
        <div>
          @if ($banner->url)
            <a href="{{ $banner->url }}" class="d-block" target="_blank">
              <img src="{{ getStorageImages(path: $banner->photo_full_url, type: 'banner') }}"
                   alt="{{ $banner->title ?? 'Slider image' }}"
                   class="h-[300px] w-full object-cover sm:h-[400px] md:h-[500px] lg:h-[580px]">
            </a>
          @else
            <img src="{{ getStorageImages(path: $banner->photo_full_url, type: 'banner') }}"
                 alt="{{ $banner->title ?? 'Slider image' }}"
                 class="h-[300px] w-full object-cover sm:h-[400px] md:h-[500px] lg:h-[580px]">
          @endif
        </div>
      @endforeach
    </div>
  @endif
</section>
