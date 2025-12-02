@extends('web-views.layouts.app')

@section('title', $web_config['company_name'] . ' ' . translate('Online_Shopping') . ' | ' . $web_config['company_name']
  . ' ' . translate('ecommerce'))

  @push('css_or_js')
    <meta property="og:image" content="{{ $web_config['web_logo']['path'] }}" />
    <meta property="og:title" content="Welcome To {{ $web_config['company_name'] }} Home" />
    <meta property="og:url" content="{{ env('APP_URL') }}">
    <meta property="og:description" content="{{ $web_config['meta_description'] }}">
    <meta name="description" content="{{ $web_config['meta_description'] }}">
    <meta property="twitter:card" content="{{ $web_config['web_logo']['path'] }}" />
    <meta property="twitter:title" content="Welcome To {{ $web_config['company_name'] }} Home" />
    <meta property="twitter:url" content="{{ env('APP_URL') }}">
    <meta property="twitter:description" content="{{ $web_config['meta_description'] }}">
  @endpush

@section('content')
  {{-- Hero Slider --}}
  @include(VIEW_FILE_NAMES['hero_slider'])

  <h1 class="text-3xl">Hello World</h1>

@endsection

@push('script')
  <script>
    $(document).ready(function() {
      // Hero Slider
      if ($('.hero-slider').length) {
        $('.hero-slider').slick({
          dots: true,
          infinite: true,
          speed: 500,
          fade: true,
          cssEase: 'linear',
          autoplay: true,
          autoplaySpeed: 3000,
          arrows: true
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
          arrows: true,
          responsive: [{
              breakpoint: 1024,
              settings: {
                slidesToShow: 6,
                slidesToScroll: 1
              }
            },
            {
              breakpoint: 768,
              settings: {
                slidesToShow: 4,
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
            slidesToShow: 5,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 3000,
            arrows: true,
            responsive: [{
                breakpoint: 1024,
                settings: {
                  slidesToShow: 4,
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
                  slidesToShow: 2,
                  slidesToScroll: 1
                }
              }
            ]
          });
        }
      });

      // Quick View
      $('.quick-view-btn').on('click', function() {
        var productId = $(this).data('product-id');
        if (productId && typeof quickView !== 'undefined') {
          quickView(productId);
        }
      });

      // Add to Cart
      $('.add-to-cart-btn').on('click', function() {
        var productId = $(this).data('product-id');
        if (productId && typeof addToCart !== 'undefined') {
          addToCart(productId);
        }
      });
    });
  </script>
@endpush
