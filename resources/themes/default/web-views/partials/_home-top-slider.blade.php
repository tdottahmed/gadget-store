@if (count($bannerTypeMainBanner) > 0)
  <section class="bg-transparent py-3">
    <div class="position-relative container">
      <div class="row align-items-stretch">
        <div class="col-12 col-lg-9 col-xl-9">
          <div class="{{ Session::get('direction') === 'rtl' ? 'pe-xl-2' : 'ps-xl-2' }}">
            <div class="owl-carousel owl-theme hero-slider h-100"
                 data-loop="{{ count($bannerTypeMainBanner) > 1 ? 1 : 0 }}">
              @foreach ($bannerTypeMainBanner as $banner)
                <a href="{{ $banner['url'] }}" class="d-block h-100" target="_blank">
                  <img class="w-100 h-100 object-fit-cover main-banner-img rounded"
                       src="{{ getStorageImages(path: $banner->photo_full_url, type: 'banner') }}" alt="Main Banner">
                </a>
              @endforeach
            </div>
          </div>
        </div>
        @if ($bannerTypeMainSideBannerTop || $bannerTypeMainSideBannerBottom)
          <div class="col-12 col-lg-3 col-xl-3 d-flex flex-column side-banner-wrapper">
            @if ($bannerTypeMainSideBannerTop)
              <a href="{{ $bannerTypeMainSideBannerTop['url'] }}" target="_blank" class="d-block side-banner-item mb-3">
                <img class="w-100 h-100 object-fit-cover rounded"
                     src="{{ getStorageImages(path: $bannerTypeMainSideBannerTop->photo_full_url, type: 'banner') }}"
                     alt="Top Banner">
              </a>
            @endif
            @if ($bannerTypeMainSideBannerBottom)
              <a href="{{ $bannerTypeMainSideBannerBottom['url'] }}" target="_blank" class="d-block side-banner-item">
                <img class="w-100 h-100 object-fit-cover rounded"
                     src="{{ getStorageImages(path: $bannerTypeMainSideBannerBottom->photo_full_url, type: 'banner') }}"
                     alt="Bottom Banner">
              </a>
            @endif
          </div>
        @endif

      </div>
    </div>
  </section>

  <style>
    .main-banner-img {
      max-height: 416px !important;
    }

    .side-banner-wrapper {
      height: 100%;
      max-height: 416px !important;
    }

    .side-banner-item {
      flex: 1 1 50%;
      overflow: hidden;
    }

    .side-banner-item img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    @media (max-width: 991.98px) {

      .main-banner-img,
      .side-banner-wrapper {
        max-height: none;
      }
    }
  </style>
@endif
