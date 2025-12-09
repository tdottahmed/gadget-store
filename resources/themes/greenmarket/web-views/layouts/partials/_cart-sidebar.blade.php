@php
  use App\Utils\CartManager;
  use App\Models\Product;
  $cart = CartManager::getCartListQuery();
  $cartTotal = CartManager::getCartListTotalAppliedDiscount($cart);
@endphp

<!-- Cart Sidebar Overlay -->
<div id="cart-sidebar-overlay"
     class="fixed inset-0 z-[9998] hidden bg-black bg-opacity-50 transition-opacity duration-300"></div>

<!-- Cart Sidebar -->
<div id="cart-sidebar"
     class="fixed right-0 top-0 z-[9999] flex h-full w-full translate-x-full transform flex-col bg-white shadow-2xl transition-transform duration-300 ease-in-out md:w-[420px] lg:w-[450px]">
  <!-- Cart Header -->
  <div class="flex items-center justify-between border-b border-gray-200 bg-white px-4 py-4">
    <div class="flex items-center gap-3">
      <a href="{{ route('home') }}" class="flex items-center gap-2 text-gray-600 transition-colors hover:text-gray-900">
        <i class="fas fa-arrow-left text-lg"></i>
        <span
              class="hidden text-sm font-medium sm:inline">{{ translate('continue_shopping') ?? 'Continue Shopping' }}</span>
      </a>
    </div>
    <div class="flex items-center gap-4">
      <h2 class="text-lg font-bold text-black">{{ translate('your_cart') ?? 'Your Cart' }}</h2>
      <div class="flex h-8 w-8 items-center justify-center rounded-full bg-gray-100">
        <span class="cart-count-badge text-sm font-bold text-gray-700">{{ $cart->count() }}</span>
      </div>
    </div>
  </div>

  <!-- Cart Content -->
  <div class="flex-1 overflow-y-auto">
    @if ($cart->count() > 0)
      <div class="space-y-4 p-4" id="cart-items-container">
        @foreach ($cart as $cartItem)
          @php
            $product = Product::find($cartItem['product_id'] ?? ($cartItem->product_id ?? null));
            if ($product) {
                $productImage = getStorageImages(
                    path: $product->thumbnail_full_url ?? ($product->thumbnail ?? ''),
                    type: 'product',
                );
                if (empty($productImage) || $productImage == asset('')) {
                    $productImage = asset('themes/greenmarket/assets/images/placeholder.png');
                }
            } else {
                $productImage = asset('themes/greenmarket/assets/images/placeholder.png');
            }
            $productName = $product ? $product->name : 'Product';
            $price = $cartItem['price'] ?? ($cartItem->price ?? 0);
            $discount = $cartItem['discount'] ?? ($cartItem->discount ?? 0);
            $quantity = $cartItem['quantity'] ?? ($cartItem->quantity ?? 1);
            $subtotal = ($price - $discount) * $quantity;
            $cartId = $cartItem['id'] ?? ($cartItem->id ?? '');

            // Get max quantity based on product stock
            $maxQuantity = $product ? $product->current_stock : 999;
            if ($product && $product->variation && $cartItem['variant']) {
                $variations = json_decode($product->variation, true);
                foreach ($variations as $variation) {
                    if (isset($variation['type']) && $variation['type'] == $cartItem['variant']) {
                        $maxQuantity = $variation['qty'] ?? $product->current_stock;
                        break;
                    }
                }
            }
          @endphp
          <div class="cart-item flex items-start gap-3 border-b border-gray-100 pb-4" data-cart-id="{{ $cartId }}"
               data-product-id="{{ $product ? $product->id : '' }}" data-max-quantity="{{ $maxQuantity }}">
            <!-- Product Image -->
            <div
                 class="h-20 w-20 flex-shrink-0 overflow-hidden rounded-lg border border-gray-200 bg-gray-50 md:h-24 md:w-24">
              <img src="{{ $productImage }}" alt="{{ $productName }}" class="h-full w-full object-contain">
            </div>

            <!-- Product Details -->
            <div class="min-w-0 flex-1">
              <h3 class="mb-2 line-clamp-2 text-sm font-semibold text-black">{{ $productName }}</h3>

              <!-- Quantity Controls -->
              <div class="mb-3 flex items-center gap-2">
                <button class="decrease-quantity {{ $quantity <= 1 ? 'opacity-50 cursor-not-allowed' : '' }} flex h-8 w-8 items-center justify-center rounded border border-gray-300 text-gray-600 transition-colors hover:bg-gray-50"
                        data-cart-id="{{ $cartId }}" {{ $quantity <= 1 ? 'disabled' : '' }}>
                  <i class="fas fa-minus text-xs pointer-events-none"></i>
                </button>
                <div class="relative">
                  <input type="number" value="{{ $quantity }}" min="1" max="{{ $maxQuantity }}" readonly
                         class="quantity-input h-8 w-10 rounded border border-gray-300 text-center text-sm font-medium text-gray-700"
                         data-cart-id="{{ $cartId }}" data-max="{{ $maxQuantity }}">
                  <div class="quantity-loader absolute inset-0 hidden items-center justify-center rounded border border-gray-300 bg-white bg-opacity-90"
                       data-cart-id="{{ $cartId }}">
                    <svg class="h-4 w-4 animate-spin text-gray-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                         viewBox="0 0 24 24">
                      <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                              stroke-width="4"></circle>
                      <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                      </path>
                    </svg>
                  </div>
                </div>
                <button class="increase-quantity {{ $quantity >= $maxQuantity ? 'opacity-50 cursor-not-allowed' : '' }} flex h-8 w-8 items-center justify-center rounded border border-gray-300 text-gray-600 transition-colors hover:bg-gray-50"
                        data-cart-id="{{ $cartId }}" data-max="{{ $maxQuantity }}"
                        {{ $quantity >= $maxQuantity ? 'disabled' : '' }}>
                  <i class="fas fa-plus text-xs pointer-events-none"></i>
                </button>
              </div>
              @if ($quantity >= $maxQuantity)
                <p class="mb-2 text-xs text-red-500">
                  {{ translate('max_quantity_reached') ?? 'Maximum quantity reached' }}</p>
              @endif

              <!-- Price and Delete -->
              <div class="flex items-center justify-between">
                <span class="cart-item-subtotal text-base font-bold text-black" data-cart-id="{{ $cartId }}"
                      data-unit-price="{{ $price - $discount }}">{{ webCurrencyConverter(amount: $subtotal) }}</span>
                <button class="greenmarket-remove-cart-item text-red-500 transition-colors hover:text-red-700"
                        data-cart-id="{{ $cartId }}">
                  <i class="fas fa-trash text-sm"></i>
                </button>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    @else
      <!-- Empty Cart -->
      <div class="flex h-full flex-col items-center justify-center px-4 py-12">
        <div class="mb-4 flex h-24 w-24 items-center justify-center rounded-full bg-gray-100">
          <i class="fas fa-shopping-cart text-4xl text-gray-400"></i>
        </div>
        <h3 class="mb-2 text-lg font-semibold text-gray-700">
          {{ translate('your_cart_is_empty') ?? 'Your cart is empty' }}</h3>
        <p class="mb-6 text-center text-sm text-gray-500">
          {{ translate('add_items_to_cart') ?? 'Add items to your cart to continue shopping' }}</p>
        <a href="{{ route('home') }}"
           class="bg-primary-dynamic rounded-md px-6 py-2 font-semibold text-white transition-colors">
          {{ translate('continue_shopping') ?? 'Continue Shopping' }}
        </a>
      </div>
    @endif
  </div>

  <!-- Cart Footer -->
  @if ($cart->count() > 0)
    <div class="space-y-4 border-t border-gray-200 bg-white p-4">
      <!-- Total -->
      <div class="flex items-center justify-between">
        <span class="text-base font-bold text-black">{{ translate('total') ?? 'Total' }}</span>
        <span class="text-xl font-bold text-black"
              id="cart-total-price">{{ webCurrencyConverter(amount: $cartTotal) }}</span>
      </div>

      <!-- Order Button -->
      <button onclick="openCheckoutModal()"
              class="bg-primary-dynamic block w-full rounded-lg px-6 py-3 text-center font-bold text-white transition-colors">
        {{ 'অর্ডার করুন' }}
      </button>
    </div>
  @endif
</div>

@push('script')
  <script>
    // Ensure jQuery is loaded
    if (typeof jQuery === 'undefined') {
      console.error('jQuery is not loaded!');
    } else {
      console.log('jQuery version:', jQuery.fn.jquery);
    }

    $(document).ready(function() {
      // Open cart sidebar
      function openCartSidebar() {
        $('#cart-sidebar-overlay').removeClass('hidden');
        $('#cart-sidebar').removeClass('translate-x-full');
        $('body').addClass('overflow-hidden');
      }

      // Close cart sidebar
      function closeCartSidebar() {
        $('#cart-sidebar-overlay').addClass('hidden');
        $('#cart-sidebar').addClass('translate-x-full');
        $('body').removeClass('overflow-hidden');
      }


      // Close cart sidebar
      $('#cart-sidebar-overlay').on('click', function() {
        closeCartSidebar();
      });

      // Prevent closing when clicking inside sidebar (but allow clicks on buttons to propagate)
      $('#cart-sidebar').on('click', function(e) {
        // Don't stop propagation for buttons - let them handle their own events
        if ($(e.target).is(
            'button, a, input, .greenmarket-remove-cart-item, .increase-quantity, .decrease-quantity'
          )) {
          return; // Let the event bubble up to document level handlers
        }
        e.stopPropagation();
      });

      // Quantity increase - Use more specific selector and ensure it works
      // Handle clicks on both button and icon elements
      $(document).on('click', '#cart-sidebar .increase-quantity, #cart-sidebar .increase-quantity i', function(e) {
        e.preventDefault();
        e.stopPropagation();
        e.stopImmediatePropagation();

        // Get the button element (in case click was on icon, get parent button)
        const $btn = $(this).closest('.increase-quantity').length ? $(this).closest('.increase-quantity') : $(this);
        
        if ($btn.prop('disabled')) {
          return false;
        }

        const cartId = $btn.data('cart-id');
        const maxQty = parseInt($btn.data('max')) || 999;
        const $cartItem = $btn.closest('.cart-item');
        const $quantityInput = $cartItem.find('.quantity-input');
        const currentQty = parseInt($quantityInput.val()) || 1;

        if (currentQty < maxQty) {
          updateQuantity(cartId, currentQty + 1);
        } else {
          if (typeof toastr !== 'undefined') {
            toastr.warning(
              '{{ translate('max_quantity_reached') ?? 'Maximum quantity reached' }}');
          }
        }
        return false;
      });

      // Quantity decrease - Use more specific selector and ensure it works
      // Handle clicks on both button and icon elements
      $(document).on('click', '#cart-sidebar .decrease-quantity, #cart-sidebar .decrease-quantity i', function(e) {
        e.preventDefault();
        e.stopPropagation();
        e.stopImmediatePropagation();

        // Get the button element (in case click was on icon, get parent button)
        const $btn = $(this).closest('.decrease-quantity').length ? $(this).closest('.decrease-quantity') : $(this);
        
        if ($btn.prop('disabled')) {
          return false;
        }

        const cartId = $btn.data('cart-id');
        const $cartItem = $btn.closest('.cart-item');
        const $quantityInput = $cartItem.find('.quantity-input');
        const currentQty = parseInt($quantityInput.val()) || 1;

        if (currentQty > 1) {
          updateQuantity(cartId, currentQty - 1);
        }
        return false;
      });

      // Remove item - Use event delegation on document to catch dynamically loaded buttons
      // Also attach directly to cart sidebar for immediate binding
      function attachRemoveHandlers() {
        // Remove existing handlers to prevent duplicates
        $(document).off('click', '.greenmarket-remove-cart-item');
        $('#cart-sidebar').off('click', '.greenmarket-remove-cart-item');

        // Attach to document (for dynamically loaded content)
        $(document).on('click', '.greenmarket-remove-cart-item', function(e) {
          handleRemoveClick(e, $(this));
        });

        // Also attach directly to cart sidebar (for immediate binding)
        $('#cart-sidebar').on('click', '.greenmarket-remove-cart-item', function(e) {
          handleRemoveClick(e, $(this));
        });
      }

      // Handle remove click
      function handleRemoveClick(e, $btn) {
        e.preventDefault();
        e.stopPropagation();
        e.stopImmediatePropagation();

        const cartId = $btn.data('cart-id');

        if (!cartId) {
          console.error('Cart ID not found on remove button');
          console.error('Button data attributes:', $btn.data());
          if (typeof toastr !== 'undefined') {
            toastr.error('Cart ID not found');
          }
          return false;
        }

        // Call remove function
        if (typeof window.removeCartItem === 'function') {
          window.removeCartItem(cartId);
        } else {
          console.error('removeCartItem function not defined');
          if (typeof toastr !== 'undefined') {
            toastr.error('Remove function not available');
          }
        }

        return false;
      }

      // Attach handlers on page load
      attachRemoveHandlers();

      // Also test if buttons exist in DOM
      setTimeout(function() {
        const $removeButtons = $('.greenmarket-remove-cart-item');
      }, 1000);

      // Update quantity function - Optimized with DOM updates and loading indicator
      function updateQuantity(cartId, quantity) {
        if (!cartId) {
          console.error('Cart ID is required');
          return;
        }

        const updateUrl = $('#route-data').data('route-cart-update') ||
          '{{ route('cart.updateQuantity') }}';
        const $cartItem = $('#cart-sidebar .cart-item[data-cart-id="' + cartId + '"]');

        if (!$cartItem.length) {
          console.error('Cart item not found for cart ID:', cartId);
          return;
        }

        const $quantityInput = $cartItem.find('.quantity-input');
        const $quantityLoader = $cartItem.find('.quantity-loader');
        const $increaseBtn = $cartItem.find('.increase-quantity');
        const $decreaseBtn = $cartItem.find('.decrease-quantity');
        const $subtotalElement = $cartItem.find('.cart-item-subtotal');
        const maxQty = parseInt($cartItem.data('max-quantity')) || 999;
        const unitPrice = parseFloat($subtotalElement.data('unit-price')) || 0;
        const oldQuantity = parseInt($quantityInput.val()) || 1;

        // Show loading indicator
        $quantityLoader.removeClass('hidden');
        $quantityInput.addClass('opacity-50');

        // Disable buttons during update
        $increaseBtn.prop('disabled', true).addClass('opacity-50 cursor-not-allowed');
        $decreaseBtn.prop('disabled', true).addClass('opacity-50 cursor-not-allowed');

        // Optimistically update quantity in UI
        $quantityInput.val(quantity);

        // Calculate new subtotal optimistically
        const newSubtotal = unitPrice * quantity;
        const formattedSubtotal = formatCurrency(newSubtotal);
        $subtotalElement.text(formattedSubtotal);

        $.ajax({
          url: updateUrl,
          method: 'POST',
          data: {
            _token: $('meta[name="_token"]').attr('content'),
            key: cartId,
            quantity: quantity
          },
          success: function(response) {
            // Hide loading indicator
            $quantityLoader.addClass('hidden');
            $quantityInput.removeClass('opacity-50');

            // Response can be HTML string (success) or JSON object (error)
            let isSuccess = false;
            let errorMessage = '';

            if (typeof response === 'string') {
              // HTML response means success - extract cart totals from response if possible
              isSuccess = true;
              try {
                const $responseHtml = $(response);
                const serverTotal = $responseHtml.find('#cart-total-price').text();
                if (serverTotal) {
                  $('#cart-total-price').text(serverTotal);
                }
              } catch (e) {
                // If parsing fails, will update via updateAllCartUI below
              }
              // Always update cart count and mobile app bar (debounced, so safe to call)
              updateAllCartUI();
            } else if (response && typeof response === 'object') {
              // JSON response - check status
              if (response.status === 0 || response.status === false) {
                isSuccess = false;
                errorMessage = response.message ||
                  '{{ translate('failed_to_update_quantity') ?? 'Failed to update quantity' }}';
                // Revert optimistic update
                $quantityInput.val(oldQuantity);
                const oldSubtotal = unitPrice * oldQuantity;
                $subtotalElement.text(formatCurrency(oldSubtotal));
              } else {
                isSuccess = true;
                // Update totals if provided in response
                if (response.total) {
                  $('#cart-total-price').text(formatCurrency(response.total));
                }
                // Always update cart count and mobile app bar (debounced)
                updateAllCartUI();
              }
            } else {
              // Assume success if we can't determine
              isSuccess = true;
              updateAllCartUI();
            }

            if (isSuccess) {
              // Update button states
              if (quantity >= maxQty) {
                $increaseBtn.prop('disabled', true).addClass('opacity-50 cursor-not-allowed');
              } else {
                $increaseBtn.prop('disabled', false).removeClass('opacity-50 cursor-not-allowed');
              }

              if (quantity <= 1) {
                $decreaseBtn.prop('disabled', true).addClass('opacity-50 cursor-not-allowed');
              } else {
                $decreaseBtn.prop('disabled', false).removeClass('opacity-50 cursor-not-allowed');
              }

              // Show success message (optional, can be removed for smoother UX)
              // if (typeof toastr !== 'undefined') {
              //   toastr.success('{{ translate('quantity_updated') ?? 'Quantity updated' }}', {
              //     timeOut: 1000,
              //     progressBar: true
              //   });
              // }
            } else {
              // Re-enable buttons on error
              $increaseBtn.prop('disabled', false).removeClass('opacity-50 cursor-not-allowed');
              $decreaseBtn.prop('disabled', false).removeClass('opacity-50 cursor-not-allowed');

              if (typeof toastr !== 'undefined') {
                toastr.error(errorMessage, {
                  CloseButton: true,
                  ProgressBar: true
                });
              }
            }
          },
          error: function(xhr) {
            // Hide loading indicator
            $quantityLoader.addClass('hidden');
            $quantityInput.removeClass('opacity-50');

            // Revert optimistic update
            $quantityInput.val(oldQuantity);
            const oldSubtotal = unitPrice * oldQuantity;
            $subtotalElement.text(formatCurrency(oldSubtotal));

            // Re-enable buttons
            $increaseBtn.prop('disabled', false).removeClass('opacity-50 cursor-not-allowed');
            $decreaseBtn.prop('disabled', false).removeClass('opacity-50 cursor-not-allowed');

            if (typeof toastr !== 'undefined') {
              toastr.error(xhr.responseJSON?.message ||
                '{{ translate('failed_to_update_quantity') ?? 'Failed to update quantity' }}', {
                  CloseButton: true,
                  ProgressBar: true
                });
            }
          }
        });
      }

      // Format currency helper function
      function formatCurrency(amount) {
        const currencySymbol = '{{ getCurrencySymbol() }}';
        const symbolPosition = '{{ getWebConfig('currency_symbol_position') ?? 'right' }}';
        const decimalPoints = {{ getWebConfig('decimal_point_settings') ?? 2 }};
        const formatted = parseFloat(amount).toFixed(decimalPoints).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
        return symbolPosition === 'left' ? currencySymbol + formatted : formatted + ' ' + currencySymbol;
      }

      // Remove cart item function - Make it globally available
      window.removeCartItem = function(cartId) {
        if (!cartId) {
          console.error('Cart ID is required');
          if (typeof toastr !== 'undefined') {
            toastr.error('Cart ID is required');
          }
          return;
        }

        if (confirm(
            '{{ translate('are_you_sure_remove') ?? 'Are you sure you want to remove this item?' }}'
          )) {
          const $cartItem = $('.cart-item[data-cart-id="' + cartId + '"]');
          const $routeData = $('#route-data');
          const removeUrl = $routeData.length ? $routeData.data('route-cart-remove') :
            '{{ route('cart.remove') }}';

          if (!$cartItem.length) {
            console.error('Cart item not found in DOM for cart ID:', cartId);
            console.error('Available cart items:', $('.cart-item').length);
            if (typeof toastr !== 'undefined') {
              toastr.error('Cart item not found');
            }
            return;
          }

          if (!removeUrl) {
            console.error('Remove URL not found');
            if (typeof toastr !== 'undefined') {
              toastr.error('Remove URL not configured');
            }
            return;
          }

          // Disable the button during request
          const $removeBtn = $cartItem.find('.greenmarket-remove-cart-item');
          $removeBtn.prop('disabled', true);

          const csrfToken = $('meta[name="_token"]').attr('content');
          if (!csrfToken) {
            console.error('CSRF token not found');
            $removeBtn.prop('disabled', false);
            if (typeof toastr !== 'undefined') {
              toastr.error('CSRF token not found');
            }
            return;
          }

          $.ajax({
            url: removeUrl,
            method: 'POST',
            data: {
              _token: csrfToken,
              key: cartId
            },
            success: function(response) {
              // Response should have 'data' and 'message' properties
              if (response && (response.message || response.data)) {
                // Remove item from DOM with animation
                $cartItem.fadeOut(300, function() {
                  $(this).remove();

                  // Reload cart sidebar content to get fresh data
                  if (typeof loadCartSidebar === 'function') {
                    loadCartSidebar();
                  }

                  // Update cart count
                  if (typeof updateCartCount === 'function') {
                    updateCartCount();
                  }

                  // Update mobile app bar before reload
                  if (typeof updateMobileAppBar === 'function') {
                    updateMobileAppBar();
                  }

                  if (typeof toastr !== 'undefined') {
                    toastr.success(response.message ||
                      '{{ translate('item_removed') ?? 'Item removed from cart' }}'
                    );
                  }
                });

                // Window Reload
                window.location.reload();
              } else {
                // If response doesn't have expected format, still try to remove
                console.warn('Unexpected response format, removing item anyway');
                $cartItem.fadeOut(300, function() {
                  $(this).remove();
                  if (typeof loadCartSidebar === 'function') {
                    loadCartSidebar();
                  }
                  if (typeof updateCartCount === 'function') {
                    updateCartCount();
                  }

                  // Update mobile app bar
                  if (typeof updateMobileAppBar === 'function') {
                    updateMobileAppBar();
                  }

                  if (typeof toastr !== 'undefined') {
                    toastr.success(
                      '{{ translate('item_removed') ?? 'Item removed from cart' }}'
                    );
                  }
                });

                // Window Reload
                window.location.reload();
              }
            },
            error: function(xhr, status, error) {
              console.error('Error removing cart item:', {
                xhr: xhr,
                status: status,
                error: error,
                responseText: xhr.responseText,
                statusCode: xhr.status
              });

              // Re-enable button on error
              $removeBtn.prop('disabled', false);

              if (typeof toastr !== 'undefined') {
                const errorMsg = xhr.responseJSON?.message || xhr.responseText ||
                  '{{ translate('failed_to_remove_item') ?? 'Failed to remove item' }}';
                toastr.error(errorMsg);
              }

              // Window Reload
              window.location.reload();
            }
          });
        }
      };

      // Recalculate cart totals from server - Optimized to calculate client-side first
      function recalculateCartTotals() {
        // First, calculate total client-side for instant feedback
        let calculatedTotal = 0;
        $('#cart-sidebar .cart-item').each(function() {
          const $item = $(this);
          const unitPrice = parseFloat($item.find('.cart-item-subtotal').data('unit-price')) || 0;
          const quantity = parseInt($item.find('.quantity-input').val()) || 1;
          calculatedTotal += unitPrice * quantity;
        });

        // Update total immediately for instant feedback
        $('#cart-total-price').text(formatCurrency(calculatedTotal));

        // Then verify with server for accuracy (discounts, taxes, etc.) - uses unified function
        updateAllCartUI();
      }

      // Load cart sidebar content dynamically - Make it globally available
      window.loadCartSidebar = function() {
        const navCartUrl = $('#route-data').data('route-cart-nav') || '{{ route('cart.nav-cart') }}';
        $.ajax({
          url: navCartUrl,
          method: 'POST',
          data: {
            _token: $('meta[name="_token"]').attr('content')
          },
          success: function(response) {
            if (response && response.data) {
              // Update cart sidebar with fresh data
              const $newContent = $(response.data);

              // Update cart items container
              if ($newContent.find('#cart-items-container').length) {
                $('#cart-items-container').html($newContent.find(
                  '#cart-items-container').html());
              }

              // Update cart footer
              const $newFooter = $newContent.find(
                '.border-t.border-gray-200.bg-white.p-4.space-y-4');
              const $currentFooter = $(
                '#cart-sidebar .border-t.border-gray-200.bg-white.p-4.space-y-4');
              if ($newFooter.length) {
                if ($currentFooter.length) {
                  $currentFooter.replaceWith($newFooter);
                } else {
                  $('#cart-sidebar').append($newFooter);
                }
              } else {
                $currentFooter.remove();
              }

              // Update cart total
              const serverTotal = $newContent.find('#cart-total-price').text();
              if (serverTotal) {
                $('#cart-total-price').text(serverTotal);
              }

              // Update cart count badge
              const cartCount = $newContent.find('.cart-count-badge').text() || '0';
              $('#cart-sidebar .cart-count-badge').text(cartCount);

              // Re-attach event handlers after content update
              if (typeof attachRemoveHandlers === 'function') {
                attachRemoveHandlers();
              }

              // Update checkout modal if open
              if (typeof loadCheckoutModalCartItems === 'function' && $('#checkout-modal').length && !$(
                  '#checkout-modal').hasClass('hidden')) {
                loadCheckoutModalCartItems();
              }

              // Update mobile app bar
              if (response.mobile_nav) {
                const $mobileAppBar = $('#mobile_app_bar');
                if ($mobileAppBar.length) {
                  $mobileAppBar.html(response.mobile_nav);
                }
              }
            }
          },
          error: function() {
            if (typeof toastr !== 'undefined') {
              toastr.error(
                '{{ translate('failed_to_load_cart') ?? 'Failed to load cart data' }}'
              );
            }
          }
        });
      }

      // Debounce timer for updateAllCartUI to prevent multiple rapid calls
      let updateAllCartUITimer = null;

      // Unified function to update all cart UI elements with a single AJAX call
      function updateAllCartUI() {
        // Clear any pending calls
        if (updateAllCartUITimer) {
          clearTimeout(updateAllCartUITimer);
        }

        // Debounce: wait 100ms before making the call to batch rapid updates
        updateAllCartUITimer = setTimeout(function() {
          const navCartUrl = '{{ route('cart.nav-cart') }}';
          $.ajax({
            url: navCartUrl,
            method: 'POST',
            data: {
              _token: $('meta[name="_token"]').attr('content')
            },
            success: function(response) {
              if (response) {
                // Update cart total from server response
                if (response.data) {
                  const $newContent = $(response.data);
                  const serverTotal = $newContent.find('#cart-total-price').text();
                  if (serverTotal) {
                    $('#cart-total-price').text(serverTotal);
                  }

                  // Update cart count badge
                  const cartCount = $newContent.find('.cart-count-badge').text() || '0';
                  const $headerBadge = $('.cart-count-badge');

                  if (parseInt(cartCount) > 0) {
                    if ($headerBadge.length) {
                      $headerBadge.text(cartCount);
                    } else {
                      // Add badge if it doesn't exist
                      $('a[href*="shop-cart"]').append(
                        '<span class="cart-count-badge absolute -top-2 left-3 flex h-5 w-5 items-center justify-center rounded-full bg-[#DC3545] text-xs font-bold text-white md:-top-3 md:left-4">' +
                        cartCount + '</span>');
                    }
                  } else {
                    $headerBadge.remove();
                  }
                }

                // Update mobile app bar with fresh cart count
                if (response.mobile_nav) {
                  const $mobileAppBar = $('#mobile_app_bar');
                  if ($mobileAppBar.length) {
                    $mobileAppBar.html(response.mobile_nav);
                  }
                }

                // Update checkout modal if it's open
                if (typeof loadCheckoutModalCartItems === 'function' && $('#checkout-modal').length && !$(
                    '#checkout-modal').hasClass('hidden')) {
                  loadCheckoutModalCartItems();
                }
              }
            },
            error: function() {
              console.error('Failed to update cart UI');
            },
            complete: function() {
              updateAllCartUITimer = null;
            }
          });
        }, 100); // 100ms debounce delay
      }

      // Update cart count in header (kept for backward compatibility, but uses updateAllCartUI internally)
      function updateCartCount() {
        updateAllCartUI();
      }

      // Update mobile app bar (kept for backward compatibility, but uses updateAllCartUI internally)
      function updateMobileAppBar() {
        updateAllCartUI();
      }

      // Load cart sidebar when opened
      $(document).on('click', 'a[href*="shop-cart"], a[href="{{ route('shop-cart') }}"]', function(e) {
        e.preventDefault();
        e.stopPropagation();
        e.stopImmediatePropagation();
        openCartSidebar();
        loadCartSidebar();
        return false;
      });
    });
  </script>
@endpush
