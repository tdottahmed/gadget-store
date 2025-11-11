<section id="product-section" class="all_products py-5">
  <div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-8">
      <div class="flex-grow-1 w-0">
        <h5 class="text-dark fw-bold mb-1">{{ translate('all_products') }}</h5>
        <p class="text-muted small mb-0">{{ translate('browse_randomly_selected_products') }}</p>
      </div>
    </div>
    <div id="product-list" class="row g-3">
      <div id="loading-indicator" class="col-12 py-5 text-center">
        <div class="spinner-border text-primary" role="status"></div>
        <p class="text-secondary mb-0 mt-3">{{ translate('loading_products') }}...</p>
      </div>
    </div>
    <div class="mt-4 text-center">
      <button id="load-more-btn" class="btn btn-outline-primary d-none rounded-pill px-4 py-2 shadow-sm">
        {{ translate('load_more') }}
      </button>
    </div>
  </div>
</section>
@push('script')
  <script>
    $(function() {
      let skip = 0;
      const limit = 28;
      const $container = $('#product-list');
      const $button = $('#load-more-btn');
      const $loader = $('#loading-indicator');

      function fetchProducts(initial = false) {
        if (!initial) {
          $button.prop('disabled', true).text('{{ translate('loading...') }}');
        }

        $.ajax({
          url: "{{ route('products.fetch') }}",
          data: {
            skip,
            limit
          },
          dataType: "json",
          success: function(data) {
            if (initial) {
              $container.empty();
              $loader.addClass('d-none');
            }
            $container.append(data.html);
            skip += limit;

            if (typeof renderQuickViewFunction === 'function') {
              renderQuickViewFunction();
            }

            if (data.hasMore) {
              $button.removeClass('d-none').prop('disabled', false).text('{{ translate('load_more') }}');
            } else {
              $button.fadeOut(300, function() {
                $(this).remove();
              });
            }
          },
          error: function() {
            if (initial) {
              $loader.html('<p class="text-danger">{{ translate('failed_to_load_products') }}</p>');
            } else {
              $button.text('{{ translate('try_again') }}').prop('disabled', false);
            }
          }
        });
      }

      fetchProducts(true);

      $button.on('click', function() {
        fetchProducts();
      });
    });
  </script>
@endpush
