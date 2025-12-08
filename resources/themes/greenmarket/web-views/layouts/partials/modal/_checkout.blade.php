@php
  use App\Utils\CartManager;
  use App\Models\Product;
  use App\Models\ShippingMethod;

  $cart = CartManager::getCartListQuery();
  $cartTotal = CartManager::getCartListTotalAppliedDiscount($cart);

  // Get active admin shipping methods
  $shippingMethods = ShippingMethod::where('creator_type', 'admin')->where('status', 1)->orderBy('id', 'asc')->get();
@endphp

<!-- Checkout Modal Overlay -->
<div id="checkout-modal-overlay"
     class="fixed inset-0 z-[9998] hidden bg-black bg-opacity-50 transition-opacity duration-300"></div>

<!-- Checkout Modal -->
<div id="checkout-modal" class="fixed inset-0 z-[9999] hidden overflow-y-auto">
  <div class="flex min-h-screen items-center justify-center px-4 py-4">
    <!-- Overlay -->
    <div class="fixed inset-0 bg-black bg-opacity-50" onclick="closeCheckoutModal()"></div>

    <!-- Modal Container -->
    <div class="relative flex max-h-[90vh] w-full max-w-[700px] transform flex-col rounded-xl bg-white shadow-2xl transition-all duration-300"
         id="checkout-modal-container">
      <!-- Modal Header -->
      <div class="sticky top-0 z-10 flex items-center justify-between border-b border-gray-200 bg-white px-6 py-6">
        <h2 class="text-xl font-bold leading-tight text-black"
            style="font-family: 'Hind Siliguri', 'Noto Sans Bengali', sans-serif;">
          অর্ডার করুন - ক্যাশ অন ডেলিভারিতে
        </h2>
        <button onclick="closeCheckoutModal()"
                class="flex h-8 w-8 cursor-pointer items-center justify-center rounded-full border-none bg-transparent text-gray-600 transition-all duration-300 hover:bg-gray-100 hover:text-black"
                aria-label="Close checkout">
          <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>

      <!-- Modal Content -->
      <div class="flex-1 overflow-y-auto overflow-x-hidden px-6 py-6" id="checkout-modal-content">
        <!-- Order Summary Section - Loaded dynamically -->
        <div id="checkout-cart-summary">
          @include('web-views.layouts.partials.modal._checkout-cart-items')
        </div>

        <!-- Form Section -->
        <div class="mb-8">
          <h3 class="mb-6 text-center text-lg font-bold text-black"
              style="font-family: 'Hind Siliguri', 'Noto Sans Bengali', sans-serif;">
            অর্ডার করতে নিচের তথ্যগুলি দিন
          </h3>

          <div class="space-y-4">
            <!-- Name Field -->
            <div class="flex flex-col gap-2">
              <label class="flex items-center gap-2 text-sm font-semibold text-black"
                     style="font-family: 'Hind Siliguri', 'Noto Sans Bengali', sans-serif;">নাম
              </label>
              <input type="text" id="checkout-name" required placeholder="আপনার নাম"
                     class="focus:ring-3 w-full rounded-md border border-gray-200 bg-white px-4 py-3.5 text-sm text-black transition-all duration-300 placeholder:text-gray-300 focus:border-green-500 focus:outline-none focus:ring-green-100"
                     style="font-family: 'Hind Siliguri', 'Noto Sans Bengali', sans-serif;">
              <span class="hidden text-xs text-red-500" id="checkout-name-error"></span>
            </div>

            <!-- Mobile Number Field -->
            <div class="flex flex-col gap-2">
              <label class="flex items-center gap-2 text-sm font-semibold text-black"
                     style="font-family: 'Hind Siliguri', 'Noto Sans Bengali', sans-serif;">মোবাইল
                নাম্বার</label>
              <input type="tel" id="checkout-mobile" required placeholder="11 ডিজিট মোবাইল নাম্বার" maxlength="11"
                     class="focus:ring-3 w-full rounded-md border border-gray-200 bg-white px-4 py-3.5 text-sm text-black transition-all duration-300 placeholder:text-gray-300 focus:border-green-500 focus:outline-none focus:ring-green-100"
                     style="font-family: 'Inter', sans-serif;">
              <span class="hidden text-xs text-red-500" id="checkout-mobile-error"></span>
            </div>

            <!-- Email Field -->
            <div class="flex flex-col gap-2">
              <label class="flex items-center gap-2 text-sm font-semibold text-black"
                     style="font-family: 'Hind Siliguri', 'Noto Sans Bengali', sans-serif;">ইমেইল
                @if (!auth('customer')->check())
                  <span class="text-red-500">*</span>
                @endif
              </label>
              <input type="email" id="checkout-email" {{ !auth('customer')->check() ? 'required' : '' }}
                     placeholder="আপনার ইমেইল"
                     class="focus:ring-3 w-full rounded-md border border-gray-200 bg-white px-4 py-3.5 text-sm text-black transition-all duration-300 placeholder:text-gray-300 focus:border-green-500 focus:outline-none focus:ring-green-100"
                     style="font-family: 'Hind Siliguri', 'Noto Sans Bengali', sans-serif;">
              <span class="hidden text-xs text-red-500" id="checkout-email-error"></span>
            </div>

            <!-- City Field -->
            <div class="flex flex-col gap-2">
              <label class="flex items-center gap-2 text-sm font-semibold text-black"
                     style="font-family: 'Hind Siliguri', 'Noto Sans Bengali', sans-serif;">শহর
              </label>
              <input type="text" id="checkout-city" required placeholder="আপনার শহরের নাম"
                     class="focus:ring-3 w-full rounded-md border border-gray-200 bg-white px-4 py-3.5 text-sm text-black transition-all duration-300 placeholder:text-gray-300 focus:border-green-500 focus:outline-none focus:ring-green-100"
                     style="font-family: 'Hind Siliguri', 'Noto Sans Bengali', sans-serif;">
              <span class="hidden text-xs text-red-500" id="checkout-city-error"></span>
            </div>

            <!-- Address Field -->
            <div class="flex flex-col gap-2">
              <label class="flex items-center gap-2 text-sm font-semibold text-black"
                     style="font-family: 'Hind Siliguri', 'Noto Sans Bengali', sans-serif;">ঠিকানা
              </label>
              <textarea id="checkout-address" required placeholder="আপনার বাসার সম্পূর্ণ ঠিকানা" rows="3"
                        class="focus:ring-3 min-h-[100px] w-full resize-y rounded-md border border-gray-200 bg-white px-4 py-3.5 text-sm text-black transition-all duration-300 placeholder:text-gray-300 focus:border-green-500 focus:outline-none focus:ring-green-100"
                        style="font-family: 'Hind Siliguri', 'Noto Sans Bengali', sans-serif;"></textarea>
              <span class="hidden text-xs text-red-500" id="checkout-address-error"></span>
            </div>
          </div>
        </div>

        <!-- Delivery Options -->
        <div class="mb-8">
          <h3 class="mb-4 text-sm font-bold text-black"
              style="font-family: 'Hind Siliguri', 'Noto Sans Bengali', sans-serif;">
            {{ translate('delivery') ?? 'ডেলিভারি' }}</h3>

          @if ($shippingMethods->count() > 0)
            <div class="space-y-3" id="shipping-methods-container">
              @foreach ($shippingMethods as $index => $shippingMethod)
                @php
                  $shippingId = $shippingMethod->id;
                  $shippingTitle = $shippingMethod->title ?? (translate('delivery') ?? 'ডেলিভারি');
                  $shippingCost = $shippingMethod->cost ?? 0;
                  $shippingDuration = $shippingMethod->duration ?? '';
                  $isFirst = $index === 0;
                @endphp
                <div class="delivery-option {{ $isFirst ? 'selected' : '' }} flex cursor-pointer items-center justify-between rounded-lg border border-gray-200 bg-white p-4 transition-all duration-300 hover:border-green-500 hover:bg-green-50"
                     data-delivery="{{ $shippingId }}" data-shipping-id="{{ $shippingId }}"
                     data-price="{{ $shippingCost }}">
                  <div class="flex flex-1 items-center gap-3">
                    <div class="{{ $isFirst ? 'border-green-500' : 'border-gray-200' }} delivery-radio relative h-5 w-5 flex-shrink-0 rounded-full border-2"
                         data-delivery="{{ $shippingId }}">
                      <div
                           class="{{ $isFirst ? '' : 'hidden' }} absolute left-1/2 top-1/2 h-2.5 w-2.5 -translate-x-1/2 -translate-y-1/2 transform rounded-full bg-green-500">
                      </div>
                    </div>
                    <div class="flex flex-col">
                      <span class="text-sm font-medium text-black"
                            style="font-family: 'Hind Siliguri', 'Noto Sans Bengali', sans-serif;">{{ $shippingTitle }}</span>
                      @if ($shippingDuration)
                        <span class="text-xs text-gray-500"
                              style="font-family: 'Hind Siliguri', 'Noto Sans Bengali', sans-serif;">{{ $shippingDuration }}</span>
                      @endif
                    </div>
                  </div>
                  <span class="text-sm font-bold text-black">{{ webCurrencyConverter($shippingCost) }}</span>
                </div>
              @endforeach
            </div>
          @else
            {{-- Fallback if no shipping methods configured --}}
            <div class="space-y-3">
              <div class="delivery-option selected flex cursor-pointer items-center justify-between rounded-lg border border-gray-200 bg-white p-4 transition-all duration-300 hover:border-green-500 hover:bg-green-50"
                   data-delivery="default" data-shipping-id="0" data-price="0">
                <div class="flex flex-1 items-center gap-3">
                  <div class="delivery-radio relative h-5 w-5 flex-shrink-0 rounded-full border-2 border-green-500"
                       data-delivery="default">
                    <div
                         class="absolute left-1/2 top-1/2 h-2.5 w-2.5 -translate-x-1/2 -translate-y-1/2 transform rounded-full bg-green-500">
                    </div>
                  </div>
                  <span class="text-sm font-medium text-black"
                        style="font-family: 'Hind Siliguri', 'Noto Sans Bengali', sans-serif;">{{ translate('standard_delivery') ?? 'স্ট্যান্ডার্ড ডেলিভারি' }}</span>
                </div>
                <span class="text-sm font-bold text-black">{{ webCurrencyConverter(0) }}</span>
              </div>
            </div>
          @endif
        </div>
      </div>

      <!-- Modal Footer -->
      <div class="sticky bottom-0 z-10 border-t border-gray-200 bg-white p-6">
        <button id="checkout-confirm-btn"
                class="flex w-full cursor-pointer items-center justify-center gap-2 rounded-lg border-none bg-orange-500 px-8 py-4 text-base font-bold text-white transition-all duration-300 hover:-translate-y-0.5 hover:bg-orange-600 hover:shadow-lg disabled:transform-none disabled:cursor-not-allowed disabled:bg-gray-300 disabled:shadow-none"
                style="font-family: 'Hind Siliguri', 'Noto Sans Bengali', sans-serif;">
          <span id="checkout-btn-text">অর্ডার কনফার্ম করুন <span
                  id="checkout-btn-total">{{ webCurrencyConverter(amount: $cartTotal) }}</span></span>
          <span id="checkout-btn-loading" class="hidden">
            <svg class="h-5 w-5 animate-spin text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                 viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                      stroke-width="4"></circle>
              <path class="opacity-75" fill="currentColor"
                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
              </path>
            </svg>
            প্রসেসিং...
          </span>
        </button>
        <p class="mt-3 text-center text-xs leading-relaxed text-gray-500"
           style="font-family: 'Hind Siliguri', 'Noto Sans Bengali', sans-serif;">
          আমাদের একজন কাস্টমার প্রতিনিধি আপনাকে কল করে আবার কনফার্ম হবে
        </p>
      </div>
    </div>
  </div>
</div>

@push('script')
  <script>
    let selectedDeliveryOption = null;
    let selectedShippingMethodId = null;
    let deliveryCharge = 0;
    let cartSubtotal = extractNumericValue('{{ webCurrencyConverter(amount: $cartTotal) }}');

    // Initialize first shipping method as selected
    $(document).ready(function() {
      const $firstOption = $('.delivery-option').first();
      if ($firstOption.length) {
        selectedShippingMethodId = $firstOption.data('shipping-id');
        selectedDeliveryOption = $firstOption.data('delivery');
        deliveryCharge = parseFloat($firstOption.data('price')) || 0;
        updateCheckoutTotals();
      }
    });

    // Open checkout modal - make it globally available
    window.openCheckoutModal = function() {
      $('#checkout-modal-overlay').removeClass('hidden');
      $('#checkout-modal').removeClass('hidden');
      $('body').addClass('overflow-hidden');

      // Reset form
      resetCheckoutForm();

      // Initialize first shipping method if available
      const $firstOption = $('.delivery-option').first();
      if ($firstOption.length && !selectedShippingMethodId) {
        selectedShippingMethodId = $firstOption.data('shipping-id');
        selectedDeliveryOption = $firstOption.data('delivery');
        deliveryCharge = parseFloat($firstOption.data('price')) || 0;
        updateCheckoutTotals();
      }

      // Load fresh cart data
      loadCheckoutCartData();
    };

    // Also assign to global scope for compatibility
    if (typeof openCheckoutModal === 'undefined') {
      window.openCheckoutModal = window.openCheckoutModal;
    }

    // Close checkout modal
    function closeCheckoutModal() {
      $('#checkout-modal-overlay').addClass('hidden');
      $('#checkout-modal').addClass('hidden');
      $('body').removeClass('overflow-hidden');
    }

    // Reset checkout form
    function resetCheckoutForm() {
      // Clear form fields
      $('#checkout-name').val('');
      $('#checkout-mobile').val('');
      $('#checkout-email').val('');
      $('#checkout-city').val('');
      $('#checkout-address').val('');
      selectedDeliveryOption = null;
      selectedShippingMethodId = null;
      deliveryCharge = 0;

      // Reset delivery options
      $('.delivery-option').removeClass('border-green-500 bg-green-50 border-2 selected');
      $('.delivery-radio').find('div').addClass('hidden');
      $('.delivery-radio').removeClass('border-green-500').addClass('border-gray-200');

      // Select first delivery option
      const $firstOption = $('.delivery-option').first();
      if ($firstOption.length) {
        selectedShippingMethodId = $firstOption.data('shipping-id');
        selectedDeliveryOption = $firstOption.data('delivery');
        deliveryCharge = parseFloat($firstOption.data('price')) || 0;
        $firstOption.addClass('border-green-500 bg-green-50 border-2 selected');
        $firstOption.find('.delivery-radio').removeClass('border-gray-200').addClass('border-green-500').find('div')
          .removeClass('hidden');
      }

      // Reset price summary
      updateCheckoutTotals();

      // Clear errors
      $('.text-red-500').addClass('hidden').text('');
      $('input, textarea').removeClass('border-red-500');
    }

    // Load checkout cart data and update modal
    function loadCheckoutCartData() {
      // Load fresh cart items for checkout modal
      if (typeof loadCheckoutModalCartItems === 'function') {
        loadCheckoutModalCartItems();
      } else {
        // Fallback: use nav-cart endpoint
        const navCartUrl = $('#route-data').data('route-cart-nav') || '{{ route('cart.nav-cart') }}';
        $.ajax({
          url: navCartUrl,
          method: 'POST',
          data: {
            _token: $('meta[name="_token"]').attr('content')
          },
          success: function(response) {
            if (response && response.data) {
              // Extract cart data from response
              const $newContent = $(response.data);

              // Update cart total from sidebar
              const serverTotal = $newContent.find('#cart-total-price').text();
              if (serverTotal) {
                cartSubtotal = extractNumericValue(serverTotal);
                updateCheckoutTotals();
              }

              // Reload checkout cart items
              if (typeof loadCheckoutModalCartItems === 'function') {
                loadCheckoutModalCartItems();
              }
            }
          },
          error: function() {
            console.error('Failed to load cart data for checkout modal');
          }
        });
      }
    }

    // Load checkout modal cart items specifically - Make it globally available
    window.loadCheckoutModalCartItems = function() {
      $.ajax({
        url: '{{ route('cart.nav-cart') }}',
        method: 'POST',
        data: {
          _token: $('meta[name="_token"]').attr('content')
        },
        success: function(response) {
          if (response && response.data) {
            const $newContent = $(response.data);
            const $cartItems = $newContent.find('#cart-items-container');

            // Get cart total from server response
            let serverTotal = 0;
            const $totalElement = $newContent.find('#cart-total-price');
            if ($totalElement.length) {
              const totalText = $totalElement.text();
              serverTotal = extractNumericValue(totalText);
            }

            if ($cartItems.length && $cartItems.find('.cart-item').length > 0) {
              // Recalculate cart total from items if server total not available
              let calculatedTotal = serverTotal || 0;
              if (calculatedTotal === 0) {
                $cartItems.find('.cart-item').each(function() {
                  const unitPrice = parseFloat($(this).find('.cart-item-subtotal').data('unit-price')) || 0;
                  const quantity = parseInt($(this).find('.quantity-input').val()) || 1;
                  calculatedTotal += unitPrice * quantity;
                });
              }

              // Update checkout modal cart summary
              updateCheckoutModalSummary($cartItems, calculatedTotal);
            } else {
              // Empty cart
              updateCheckoutModalSummary(null, 0);
            }
          }
        },
        error: function() {
          console.error('Failed to load checkout modal cart items');
        }
      });
    }

    // Update checkout modal summary with cart items
    function updateCheckoutModalSummary($cartItems, calculatedTotal) {
      const $summaryContainer = $('#checkout-cart-summary');
      let itemsHtml = '';
      let itemCount = 0;

      // Handle empty cart
      if (!$cartItems || !$cartItems.length || $cartItems.find('.cart-item').length === 0) {
        $summaryContainer.html(`
          <div class="mb-6 flex flex-col items-center justify-center rounded-lg bg-white px-4 py-16 shadow-md">
            <div class="mb-4 flex h-24 w-24 items-center justify-center rounded-full bg-gray-100">
              <i class="fas fa-shopping-cart text-4xl text-gray-400"></i>
            </div>
            <h3 class="mb-2 text-lg font-semibold text-gray-700">Your cart is empty</h3>
            <a href="{{ route('home') }}" class="bg-primary-dynamic rounded-md px-6 py-2 font-semibold text-white transition-colors">Continue Shopping</a>
          </div>
        `);
        cartSubtotal = 0;
        updateCheckoutTotals();
        return;
      }

      $cartItems.find('.cart-item').each(function() {
        const $item = $(this);
        const productImage = $item.find('img').attr('src') || '';
        const productName = $item.find('h3').text() || 'Product';
        const unitPrice = parseFloat($item.find('.cart-item-subtotal').data('unit-price')) || 0;
        const quantity = parseInt($item.find('.quantity-input').val()) || 1;
        const cartId = $item.data('cart-id') || '';

        itemsHtml += `
          <div class="checkout-item flex items-center gap-4 border-b border-gray-100 py-4" data-cart-id="${cartId}">
            <div class="flex h-[60px] w-[60px] flex-shrink-0 items-center justify-center rounded-lg border border-gray-200 bg-gray-50 p-2">
              <img src="${productImage}" alt="${productName}" class="h-full w-full object-contain">
            </div>
            <div class="min-w-0 flex-1">
              <h3 class="mb-1 text-sm font-medium leading-tight text-black" style="font-family: 'Hind Siliguri', 'Noto Sans Bengali', sans-serif;">
                ${productName}
              </h3>
              <p class="text-sm font-bold text-black">${formatCurrency(unitPrice)}</p>
            </div>
          </div>
        `;
        itemCount++;
      });

      if (itemCount > 0) {
        const summaryHtml = `
          <div class="mb-6" id="checkout-cart-items">
            ${itemsHtml}
          </div>
          <div class="mb-6 rounded-lg bg-gray-50 p-4">
            <div class="flex items-center justify-between py-2">
              <span class="text-sm font-medium text-gray-600" style="font-family: 'Hind Siliguri', 'Noto Sans Bengali', sans-serif;">মোট</span>
              <span class="text-sm font-semibold text-black" id="checkout-subtotal">${formatCurrency(calculatedTotal)}</span>
            </div>
            <div class="flex items-center justify-between py-2">
              <span class="text-sm font-medium text-gray-600" style="font-family: 'Hind Siliguri', 'Noto Sans Bengali', sans-serif;">ডেলিভারি চার্জ</span>
              <span class="text-sm font-medium text-green-600" id="checkout-delivery-charge">Select Delivery Area</span>
            </div>
            <div class="mt-2 flex items-center justify-between border-t-2 border-gray-200 py-3">
              <span class="text-base font-bold text-black" style="font-family: 'Hind Siliguri', 'Noto Sans Bengali', sans-serif;">সর্বমোট</span>
              <span class="text-xl font-extrabold text-black" id="checkout-grand-total">${formatCurrency(calculatedTotal)}</span>
            </div>
          </div>
        `;
        $summaryContainer.html(summaryHtml);

        // Update cart subtotal variable
        cartSubtotal = calculatedTotal;
        updateCheckoutTotals();
      } else {
        $summaryContainer.html(`
          <div class="mb-6 flex flex-col items-center justify-center rounded-lg bg-white px-4 py-16 shadow-md">
            <div class="mb-4 flex h-24 w-24 items-center justify-center rounded-full bg-gray-100">
              <i class="fas fa-shopping-cart text-4xl text-gray-400"></i>
            </div>
            <h3 class="mb-2 text-lg font-semibold text-gray-700">Your cart is empty</h3>
            <a href="{{ route('home') }}" class="bg-primary-dynamic rounded-md px-6 py-2 font-semibold text-white transition-colors">Continue Shopping</a>
          </div>
        `);
        cartSubtotal = 0;
        updateCheckoutTotals();
      }
    }

    // Update checkout totals
    function updateCheckoutTotals() {
      const grandTotal = cartSubtotal + deliveryCharge;
      $('#checkout-grand-total').text(formatCurrency(grandTotal));
      $('#checkout-btn-total').text(formatCurrency(grandTotal));

      if (deliveryCharge > 0) {
        $('#checkout-delivery-charge').text(formatCurrency(deliveryCharge));
      } else {
        $('#checkout-delivery-charge').text('Select Delivery Area').removeClass('text-green-600').addClass(
          'text-gray-600');
      }
    }

    // Format currency - extract numeric value from formatted string
    function extractNumericValue(formattedString) {
      const match = formattedString.match(/[\d,]+\.?\d*/);
      if (match) {
        return parseFloat(match[0].replace(/,/g, '')) || 0;
      }
      return 0;
    }

    // Format currency to match server format
    function formatCurrency(amount) {
      // Get currency symbol and position from server
      const currencySymbol = '{{ getCurrencySymbol() }}';
      const symbolPosition = '{{ getWebConfig('currency_symbol_position') ?? 'right' }}';
      const decimalPoints = {{ getWebConfig('decimal_point_settings') ?? 2 }};

      const formatted = parseFloat(amount).toFixed(decimalPoints).replace(/\B(?=(\d{3})+(?!\d))/g, ',');

      if (symbolPosition === 'left') {
        return currencySymbol + formatted;
      } else {
        return formatted + ' ' + currencySymbol;
      }
    }

    // Delivery option selection
    $(document).on('click', '.delivery-option', function() {
      const $option = $(this);
      const delivery = $option.data('delivery');
      const shippingId = $option.data('shipping-id');
      const price = parseFloat($option.data('price')) || 0;

      // Skip if it's the default/fallback option
      if (shippingId === 0 || shippingId === 'default') {
        selectedDeliveryOption = delivery;
        selectedShippingMethodId = shippingId;
        deliveryCharge = price;
        updateCheckoutTotals();
        return;
      }

      // Remove selection from all options
      $('.delivery-option').removeClass('border-green-500 bg-green-50 border-2 selected');
      $('.delivery-radio').find('div').addClass('hidden');
      $('.delivery-radio').removeClass('border-green-500').addClass('border-gray-200');

      // Select this option
      $option.addClass('border-green-500 bg-green-50 border-2 selected');
      $option.find('.delivery-radio').removeClass('border-gray-200').addClass('border-green-500').find('div')
        .removeClass('hidden');

      selectedDeliveryOption = delivery;
      selectedShippingMethodId = shippingId;
      deliveryCharge = price;

      updateCheckoutTotals();

      // Set shipping method via AJAX
      if (shippingId && shippingId !== 0 && shippingId !== 'default') {
        setShippingMethod(shippingId);
      }
    });

    // Set shipping method
    function setShippingMethod(shippingId) {
      const setShippingUrl = $('#route-data').data('route-set-shipping-method');

      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
      });

      $.ajax({
        url: setShippingUrl,
        type: 'GET',
        data: {
          id: shippingId,
          cart_group_id: 'all_cart_group'
        },
        success: function(response) {
          if (response.status == 1) {
            // Shipping method set successfully
            console.log('Shipping method set successfully');
          }
        },
        error: function() {
          console.error('Failed to set shipping method');
        }
      });
    }

    $(document).on('click', '.checkout-decrease-qty', function(e) {
      e.preventDefault();
      if ($(this).prop('disabled')) return;

      const cartId = $(this).data('cart-id');
      const $qtyDisplay = $('.checkout-quantity[data-cart-id="' + cartId + '"]');
      const currentQty = parseInt($qtyDisplay.text()) || 1;

      if (currentQty > 1) {
        updateCheckoutQuantity(cartId, currentQty - 1);
      }
    });

    // Update checkout quantity
    function updateCheckoutQuantity(cartId, quantity) {
      const updateUrl = $('#route-data').data('route-cart-update') || '{{ route('cart.updateQuantity') }}';

      $.ajax({
        url: updateUrl,
        method: 'POST',
        data: {
          _token: $('meta[name="_token"]').attr('content'),
          key: cartId,
          quantity: quantity
        },
        success: function(response) {
          $('.checkout-quantity[data-cart-id="' + cartId + '"]').text(quantity);

          // Recalculate cart totals
          recalculateCheckoutTotals();
        },
        error: function() {
          if (typeof toastr !== 'undefined') {
            toastr.error(
              '{{ translate('failed_to_update_quantity') ?? 'Failed to update quantity' }}');
          }
        }
      });
    }

    // Recalculate checkout totals
    function recalculateCheckoutTotals() {
      const navCartUrl = $('#route-data').data('route-cart-nav') || '{{ route('cart.nav-cart') }}';
      $.ajax({
        url: navCartUrl,
        method: 'POST',
        data: {
          _token: $('meta[name="_token"]').attr('content')
        },
        success: function(response) {
          if (response && response.data) {
            const $newContent = $(response.data);
            const serverTotal = $newContent.find('#cart-total-price').text();
            if (serverTotal) {
              cartSubtotal = extractNumericValue(serverTotal);
              updateCheckoutTotals();
            }
          }
        }
      });
    }

    // Form validation
    function validateCheckoutForm() {
      let isValid = true;

      // Name validation
      const name = $('#checkout-name').val().trim();
      if (name.length < 2) {
        showError('checkout-name', 'এই ফিল্ডটি আবশ্যক');
        isValid = false;
      } else {
        hideError('checkout-name');
      }

      // Mobile validation
      const mobile = $('#checkout-mobile').val().trim();
      const mobileNumeric = mobile.replace(/[^0-9]/g, '');
      if (!mobile || mobileNumeric.length < 4 || mobileNumeric.length > 20) {
        showError('checkout-mobile', 'সঠিক মোবাইল নম্বর দিন (৪-২০ ডিজিট)');
        isValid = false;
      } else {
        hideError('checkout-mobile');
      }

      // Email validation (required for guests)
      const email = $('#checkout-email').val().trim();
      const isGuest = {{ auth('customer')->check() ? 'false' : 'true' }};
      if (isGuest && (!email || !email.match(/^[^\s@]+@[^\s@]+\.[^\s@]+$/))) {
        showError('checkout-email', 'সঠিক ইমেইল দিন');
        isValid = false;
      } else {
        hideError('checkout-email');
      }

      // City validation
      const city = $('#checkout-city').val().trim();
      if (city.length < 2) {
        showError('checkout-city', 'এই ফিল্ডটি আবশ্যক');
        isValid = false;
      } else {
        hideError('checkout-city');
      }

      // Address validation
      const address = $('#checkout-address').val().trim();
      if (address.length < 10) {
        showError('checkout-address', 'এই ফিল্ডটি আবশ্যক (কমপক্ষে ১০ অক্ষর)');
        isValid = false;
      } else {
        hideError('checkout-address');
      }

      // Delivery option validation
      if (!selectedDeliveryOption || !selectedShippingMethodId) {
        if (typeof toastr !== 'undefined') {
          toastr.warning('ডেলিভারি অপশন সিলেক্ট করুন');
        }
        isValid = false;
      }

      return isValid;
    }

    // Show error
    function showError(fieldId, message) {
      $('#' + fieldId).addClass('border-red-500');
      $('#' + fieldId + '-error').text(message).removeClass('hidden');
    }

    // Hide error
    function hideError(fieldId) {
      $('#' + fieldId).removeClass('border-red-500');
      $('#' + fieldId + '-error').addClass('hidden');
    }

    // Submit checkout form
    $('#checkout-confirm-btn').on('click', function(e) {
      e.preventDefault();

      // Validate form
      if (!validateCheckoutForm()) {
        return false;
      }

      // Disable button and show loading
      const $btn = $(this);
      const $btnText = $('#checkout-btn-text');
      const $btnLoading = $('#checkout-btn-loading');

      $btn.prop('disabled', true);
      $btnText.addClass('hidden');
      $btnLoading.removeClass('hidden');

      // Get default country
      let defaultCountry = 'Bangladesh';
      @if (getWebConfig('default_location'))
        @php
          $defaultLocation = getWebConfig('default_location');
          if (is_string($defaultLocation)) {
              $locationData = json_decode($defaultLocation, true);
          } else {
              $locationData = $defaultLocation;
          }
          $defaultCountryValue = is_array($locationData) && isset($locationData['country']) ? $locationData['country'] : 'Bangladesh';
        @endphp
        defaultCountry = '{{ $defaultCountryValue }}';
      @endif

      // Check if cart has physical products
      let physicalProduct = 'yes';
      @php
        $cart = CartManager::getCartListQuery();
        $hasPhysical = false;
        foreach ($cart as $item) {
            $product = Product::find($item['product_id'] ?? ($item->product_id ?? null));
            if ($product && $product->product_type == 'physical') {
                $hasPhysical = true;
                break;
            }
        }
      @endphp
      physicalProduct = '{{ $hasPhysical ? 'yes' : 'no' }}';

      // First, set the shipping method if one is selected
      const setShippingMethodPromise = new Promise(function(resolve) {
        if (selectedShippingMethodId && selectedShippingMethodId !== 0 && selectedShippingMethodId !==
          'default') {
          const setShippingUrl = $('#route-data').data('route-set-shipping-method');
          if (setShippingUrl) {
            $.ajax({
              url: setShippingUrl,
              type: 'GET',
              data: {
                id: selectedShippingMethodId,
                cart_group_id: 'all_cart_group'
              },
              success: function() {
                resolve();
              },
              error: function() {
                // Continue even if shipping method setting fails
                resolve();
              }
            });
          } else {
            resolve();
          }
        } else {
          resolve();
        }
      });

      // After shipping method is set, proceed with address submission
      setShippingMethodPromise.then(function() {
        // Prepare form data
        // For simple checkout, we always create a new address (shipping_method_id = 0)
        const shippingData = {
          contact_person_name: $('#checkout-name').val().trim(),
          phone: $('#checkout-mobile').val().trim(),
          email: $('#checkout-email').val().trim() || '',
          city: $('#checkout-city').val().trim(),
          address: $('#checkout-address').val().trim(),
          address_type: 'home',
          zip: '0000',
          country: defaultCountry,
          latitude: '0',
          longitude: '0',
          shipping_method_id: 0 // Always 0 for new address in simple checkout
        };

        const formData = {
          shipping: $.param(shippingData),
          billing: $.param({
            billing_addresss_same_shipping: 'true'
          }),
          physical_product: physicalProduct
        };

        // Make AJAX request
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
          }
        });

        const chooseShippingUrl = $('#route-data').data('route-choose-shipping-address');
        const checkoutPaymentUrl = $('#route-data').data('route-checkout-payment');

        $.ajax({
          url: chooseShippingUrl,
          type: 'POST',
          data: formData,
          success: function(response) {
            if (response.errors) {
              // Show error message
              if (typeof toastr !== 'undefined') {
                toastr.error(response.errors, {
                  CloseButton: true,
                  ProgressBar: true
                });
              } else {
                alert(response.errors);
              }

              // Re-enable button
              $btn.prop('disabled', false);
              $btnText.removeClass('hidden');
              $btnLoading.addClass('hidden');
            } else {
              // Success - redirect to payment page
              if (typeof toastr !== 'undefined') {
                toastr.success(
                  '{{ translate('address_saved_successfully') ?? 'Address saved successfully' }}', {
                    CloseButton: true,
                    ProgressBar: true
                  });
              }

              setTimeout(function() {
                window.location.href = checkoutPaymentUrl;
              }, 500);
            }
          },
          error: function(xhr) {
            let errorMessage = '{{ translate('something_went_wrong') ?? 'Something went wrong' }}';

            if (xhr.responseJSON && xhr.responseJSON.errors) {
              errorMessage = xhr.responseJSON.errors;
            } else if (xhr.responseJSON && xhr.responseJSON.message) {
              errorMessage = xhr.responseJSON.message;
            }

            if (typeof toastr !== 'undefined') {
              toastr.error(errorMessage, {
                CloseButton: true,
                ProgressBar: true
              });
            } else {
              alert(errorMessage);
            }

            // Re-enable button
            $btn.prop('disabled', false);
            $btnText.removeClass('hidden');
            $btnLoading.addClass('hidden');
          }
        });
      });
    });

    // Close modal on ESC key
    $(document).on('keydown', function(e) {
      if (e.key === 'Escape' && !$('#checkout-modal').hasClass('hidden')) {
        closeCheckoutModal();
      }
    });

    // Prevent closing when clicking inside modal
    $(document).on('click', '#checkout-modal-container', function(e) {
      e.stopPropagation();
    });
  </script>
@endpush
