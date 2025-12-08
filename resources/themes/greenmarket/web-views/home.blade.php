@extends('web-views.layouts.app')

@section('title', $web_config['company_name'] . ' ' . translate('Online_Shopping') . ' | ' . $web_config['company_name']
  . ' ' . translate('ecommerce'))

  @push('css_or_js')
    @include('web-views.partials.home-styles')
  @endpush

@section('content')
  {{-- Hero Slider --}}
  @include('web-views.partials.hero-slider')

  {{-- Category Bar --}}
  @include('web-views.partials.category-bar')

  {{-- Featured Products --}}
  @include('web-views.partials.featured-products')

  {{-- Category-wise Products --}}
  @if (isset($homeCategories) && $homeCategories->count() > 0)
    @foreach ($homeCategories as $category)
      @if (isset($category->products) && $category->products->count() > 0)
        @include('web-views.partials.category-wise-product', [
            'category' => $category,
            'decimal_point_settings' => $decimal_point_settings,
        ])
      @endif
    @endforeach
  @endif

  {{-- All Products Section --}}
  @include('web-views.partials.all-products')

  {{-- Recently Viewed Section --}}
  @include('web-views.partials.recently-viewed')
@endsection

@push('script')
  <script>
    $(document).ready(function() {
      // Hero Slider
      if ($('.hero-slider').length) {
        $('.hero-slider').slick({
          dots: false,
          infinite: true,
          speed: 500,
          fade: true,
          cssEase: 'linear',
          autoplay: true,
          autoplaySpeed: 3000,
          arrows: false
        });
      }

      // Category Slider
      if ($('.category-slider').length) {
        $('.category-slider').slick({
          dots: false,
          infinite: true,
          speed: 300,
          slidesToShow: 8,
          slidesToScroll: 1,
          autoplay: true,
          autoplaySpeed: 2000,
          arrows: false,
          responsive: [{
              breakpoint: 1024,
              settings: {
                slidesToShow: 5,
                slidesToScroll: 1
              }
            },
            {
              breakpoint: 768,
              settings: {
                slidesToShow: 3,
                slidesToScroll: 1
              }
            },
            {
              breakpoint: 640,
              settings: {
                slidesToShow: 3,
                slidesToScroll: 1
              }
            }
          ]
        });
      }

      // Product Sliders
      $('.product-slider').each(function() {
        if ($(this).length) {
          $(this).slick({
            dots: false,
            infinite: true,
            speed: 300,
            slidesToShow: 4,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 3000,
            arrows: false,
            responsive: [{
                breakpoint: 1024,
                settings: {
                  slidesToShow: 3,
                  slidesToScroll: 1
                }
              },
              {
                breakpoint: 768,
                settings: {
                  slidesToShow: 2,
                  slidesToScroll: 1
                }
              },
              {
                breakpoint: 640,
                settings: {
                  slidesToShow: 1,
                  slidesToScroll: 1
                }
              }
            ]
          });
        }
      });
    });
  </script>
@endpush
