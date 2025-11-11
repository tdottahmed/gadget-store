@php($overallRating = getOverallRating($product->reviews))
<div class="col-xl-3 col-sm-4 col-md-6 col-lg-4 col-6">
  <div>
    <div class="product-single-hover style--card">
      <div class="position-relative overflow-hidden">
        <div class="inline_product clickable d-flex justify-content-center">
          @if (getProductPriceByType(product: $product, type: 'discount', result: 'value') > 0)
            <div class="d-flex">
              <span class="for-discount-value fs-13 p-1 pl-2 pr-2 font-bold">
                <span class="direction-ltr d-block">
                  -{{ getProductPriceByType(product: $product, type: 'discount', result: 'string') }}
                </span>
              </span>
            </div>
          @else
            <div class="d-flex justify-content-end">
              <span class="for-discount-value-null"></span>
            </div>
          @endif
          <div class="p-10px pb-0">
            <a href="{{ route('product', $product->slug) }}" class="w-100">
              <img alt="" src="{{ getStorageImages(path: $product->thumbnail_full_url, type: 'product') }}">
            </a>
          </div>

          <div class="quick-view">
            <a class="btn-circle stopPropagation action-product-quick-view" href="javascript:"
               data-product-id="{{ $product->id }}">
              <i class="czi-eye align-middle"></i>
            </a>
          </div>
          @if ($product->product_type == 'physical' && $product->current_stock <= 0)
            <span class="out_fo_stock">{{ translate('out_of_stock') }}</span>
          @endif
        </div>
        <div class="single-product-details">
          @if ($overallRating[0] != 0)
            <div class="rating-show justify-content-between text-center">
              <span class="d-inline-block font-size-sm text-body">
                @for ($inc = 1; $inc <= 5; $inc++)
                  @if ($inc <= (int) $overallRating[0])
                    <i class="tio-star text-warning"></i>
                  @elseif ($overallRating[0] != 0 && $inc <= (int) $overallRating[0] + 1.1 && $overallRating[0] > ((int) $overallRating[0]))
                    <i class="tio-star-half text-warning"></i>
                  @else
                    <i class="tio-star-outlined text-warning"></i>
                  @endif
                @endfor
                <label class="badge-style">( {{ count($product->reviews) }} )</label>
              </span>
            </div>
          @endif
          <h3 class="letter-spacing-0 mb-1 text-center">
            <a href="{{ route('product', $product->slug) }}">
              {{ $product['name'] }}
            </a>
          </h3>
          <div class="justify-content-between text-center">
            <h4
                class="product-price d-flex justify-content-center align-items-center letter-spacing-0 mb-0 flex-wrap gap-8 text-center">
              @if (getProductPriceByType(product: $product, type: 'discount', result: 'value') > 0)
                <del class="category-single-product-price">
                  {{ webCurrencyConverter(amount: $product->unit_price) }}
                </del>
              @endif
              <span class="text-accent text-dark">
                {{ getProductPriceByType(product: $product, type: 'discounted_unit_price', result: 'string') }}
              </span>
            </h4>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
