@php
    use App\Utils\CartManager;
    use App\Models\Product;
    use App\Models\ShippingMethod;
    
    $cart = CartManager::getCartListQuery();
    $cartTotal = CartManager::getCartListTotalAppliedDiscount($cart);
    
    // Get active admin shipping methods
    $shippingMethods = ShippingMethod::where('creator_type', 'admin')
        ->where('status', 1)
        ->orderBy('id', 'asc')
        ->get();
@endphp

<!-- Checkout Modal Overlay -->
<div id="checkout-modal-overlay" class="hidden fixed inset-0 bg-black bg-opacity-50 z-[9998] transition-opacity duration-300"></div>

<!-- Checkout Modal -->
<div id="checkout-modal" class="hidden fixed inset-0 z-[9999] overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 py-4">
        <!-- Overlay -->
        <div class="fixed inset-0 bg-black bg-opacity-50" onclick="closeCheckoutModal()"></div>
        
        <!-- Modal Container -->
        <div class="relative bg-white rounded-xl shadow-2xl w-full max-w-[700px] max-h-[90vh] flex flex-col transform transition-all duration-300" id="checkout-modal-container">
            <!-- Modal Header -->
            <div class="flex items-center justify-between px-6 py-6 border-b border-gray-200 bg-white sticky top-0 z-10">
                <h2 class="text-xl font-bold text-black leading-tight" style="font-family: 'Hind Siliguri', 'Noto Sans Bengali', sans-serif;">
                    অর্ডার করুন - ক্যাশ অন ডেলিভারিতে
                </h2>
                <button onclick="closeCheckoutModal()" 
                        class="w-8 h-8 rounded-full bg-transparent border-none cursor-pointer flex items-center justify-center text-gray-600 hover:bg-gray-100 hover:text-black transition-all duration-300"
                        aria-label="Close checkout">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Modal Content -->
            <div class="flex-1 overflow-y-auto overflow-x-hidden px-6 py-6" id="checkout-modal-content">
                <!-- Order Summary Section -->
                @if($cart->count() > 0)
                    <div class="mb-6">
                        @foreach($cart as $cartItem)
                            @php
                                $product = Product::find($cartItem['product_id'] ?? $cartItem->product_id ?? null);
                                if ($product && $product->thumbnail_full_url) {
                                    $thumbnailResult = $product->thumbnail_full_url;
                                    if (is_array($thumbnailResult) && isset($thumbnailResult['path'])) {
                                        $productImage = $thumbnailResult['path'];
                                    } elseif (is_string($thumbnailResult)) {
                                        $productImage = $thumbnailResult;
                                    } else {
                                        $productImage = getStorageImages(path: $product->thumbnail ?? '', type: 'product');
                                    }
                                } else {
                                    $productImage = asset('themes/greenmarket/assets/images/placeholder.png');
                                }
                                $productName = $product ? $product->name : 'Product';
                                $price = $cartItem['price'] ?? $cartItem->price ?? 0;
                                $discount = $cartItem['discount'] ?? $cartItem->discount ?? 0;
                                $quantity = $cartItem['quantity'] ?? $cartItem->quantity ?? 1;
                                $subtotal = ($price - $discount) * $quantity;
                                $cartId = $cartItem['id'] ?? $cartItem->id ?? '';
                                
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
                            <div class="flex items-center gap-4 py-4 border-b border-gray-100 checkout-item" data-cart-id="{{ $cartId }}">
                                <!-- Product Image -->
                                <div class="w-[60px] h-[60px] flex-shrink-0 bg-gray-50 rounded-lg border border-gray-200 flex items-center justify-center p-2">
                                    <img src="{{ $productImage }}" alt="{{ $productName }}" class="w-full h-full object-contain">
                                </div>

                                <!-- Product Details -->
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-sm font-medium text-black mb-1 leading-tight" style="font-family: 'Hind Siliguri', 'Noto Sans Bengali', sans-serif;">
                                        {{ $productName }}
                                    </h3>
                                    <p class="text-sm font-bold text-black">{{ webCurrencyConverter(amount: $price - $discount) }}</p>
                                    
                                  
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Price Summary -->
                    <div class="bg-gray-50 rounded-lg p-4 mb-6">
                        <div class="flex justify-between items-center py-2">
                            <span class="text-sm font-medium text-gray-600" style="font-family: 'Hind Siliguri', 'Noto Sans Bengali', sans-serif;">মোট</span>
                            <span class="text-sm font-semibold text-black" id="checkout-subtotal">{{ webCurrencyConverter(amount: $cartTotal) }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2">
                            <span class="text-sm font-medium text-gray-600" style="font-family: 'Hind Siliguri', 'Noto Sans Bengali', sans-serif;">ডেলিভারি চার্জ</span>
                            <span class="text-sm font-medium text-green-600" id="checkout-delivery-charge">Select Delivery Area</span>
                        </div>
                        <div class="flex justify-between items-center py-3 mt-2 border-t-2 border-gray-200">
                            <span class="text-base font-bold text-black" style="font-family: 'Hind Siliguri', 'Noto Sans Bengali', sans-serif;">সর্বমোট</span>
                            <span class="text-xl font-extrabold text-black" id="checkout-grand-total">{{ webCurrencyConverter(amount: $cartTotal) }}</span>
                        </div>
                    </div>
                @endif

                <!-- Form Section -->
                <div class="mb-8">
                    <h3 class="text-lg font-bold text-black mb-6 text-center" style="font-family: 'Hind Siliguri', 'Noto Sans Bengali', sans-serif;">
                        অর্ডার করতে নিচের তথ্যগুলি দিন
                    </h3>
                    
                    <div class="space-y-4">
                        <!-- Name Field -->
                        <div class="flex flex-col gap-2">
                            <label class="text-sm font-semibold text-black" style="font-family: 'Hind Siliguri', 'Noto Sans Bengali', sans-serif;">নাম</label>
                            <input type="text" 
                                   id="checkout-name" 
                                   placeholder="আপনার নাম" 
                                   class="w-full py-3.5 px-4 border border-gray-200 rounded-md text-sm text-black bg-white transition-all duration-300 placeholder:text-gray-300 focus:border-green-500 focus:outline-none focus:ring-3 focus:ring-green-100"
                                   style="font-family: 'Hind Siliguri', 'Noto Sans Bengali', sans-serif;">
                            <span class="text-xs text-red-500 hidden" id="checkout-name-error"></span>
                        </div>

                        <!-- Mobile Number Field -->
                        <div class="flex flex-col gap-2">
                            <label class="text-sm font-semibold text-black" style="font-family: 'Hind Siliguri', 'Noto Sans Bengali', sans-serif;">মোবাইল নাম্বার</label>
                            <input type="tel" 
                                   id="checkout-mobile" 
                                   placeholder="11 ডিজিট মোবাইল নাম্বার" 
                                   maxlength="11"
                                   class="w-full py-3.5 px-4 border border-gray-200 rounded-md text-sm text-black bg-white transition-all duration-300 placeholder:text-gray-300 focus:border-green-500 focus:outline-none focus:ring-3 focus:ring-green-100"
                                   style="font-family: 'Inter', sans-serif;">
                            <span class="text-xs text-red-500 hidden" id="checkout-mobile-error"></span>
                        </div>

                        <!-- Address Field -->
                        <div class="flex flex-col gap-2">
                            <label class="text-sm font-semibold text-black" style="font-family: 'Hind Siliguri', 'Noto Sans Bengali', sans-serif;">ঠিকানা</label>
                            <textarea id="checkout-address" 
                                      placeholder="আপনার বাসার সম্পূর্ণ ঠিকানা" 
                                      rows="3"
                                      class="w-full py-3.5 px-4 border border-gray-200 rounded-md text-sm text-black bg-white min-h-[100px] resize-y transition-all duration-300 placeholder:text-gray-300 focus:border-green-500 focus:outline-none focus:ring-3 focus:ring-green-100"
                                      style="font-family: 'Hind Siliguri', 'Noto Sans Bengali', sans-serif;"></textarea>
                            <span class="text-xs text-red-500 hidden" id="checkout-address-error"></span>
                        </div>

                        <!-- Order Note Field -->
                        <div class="flex flex-col gap-2">
                            <label class="text-sm font-semibold text-black" style="font-family: 'Hind Siliguri', 'Noto Sans Bengali', sans-serif;">অর্ডার নোট</label>
                            <input type="text" 
                                   id="checkout-note" 
                                   placeholder="স্পেশাল কিছু বলতে চাইলে লেখুন (অপশনাল)" 
                                   class="w-full py-3.5 px-4 border border-gray-200 rounded-md text-sm text-black bg-white transition-all duration-300 placeholder:text-gray-300 focus:border-green-500 focus:outline-none focus:ring-3 focus:ring-green-100"
                                   style="font-family: 'Hind Siliguri', 'Noto Sans Bengali', sans-serif;">
                        </div>
                    </div>
                </div>

                <!-- Delivery Options -->
                <div class="mb-8">
                    <h3 class="text-sm font-bold text-black mb-4" style="font-family: 'Hind Siliguri', 'Noto Sans Bengali', sans-serif;">{{ translate('delivery') ?? 'ডেলিভারি' }}</h3>
                    
                    @if($shippingMethods->count() > 0)
                        <div class="space-y-3" id="shipping-methods-container">
                            @foreach($shippingMethods as $index => $shippingMethod)
                                @php
                                    $shippingId = $shippingMethod->id;
                                    $shippingTitle = $shippingMethod->title ?? translate('delivery') ?? 'ডেলিভারি';
                                    $shippingCost = $shippingMethod->cost ?? 0;
                                    $shippingDuration = $shippingMethod->duration ?? '';
                                    $isFirst = $index === 0;
                                @endphp
                                <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg bg-white cursor-pointer transition-all duration-300 hover:border-green-500 hover:bg-green-50 delivery-option {{ $isFirst ? 'selected' : '' }}" 
                                     data-delivery="{{ $shippingId }}" 
                                     data-shipping-id="{{ $shippingId }}"
                                     data-price="{{ $shippingCost }}">
                                    <div class="flex items-center gap-3 flex-1">
                                        <div class="w-5 h-5 rounded-full border-2 {{ $isFirst ? 'border-green-500' : 'border-gray-200' }} relative flex-shrink-0 delivery-radio" data-delivery="{{ $shippingId }}">
                                            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-2.5 h-2.5 rounded-full bg-green-500 {{ $isFirst ? '' : 'hidden' }}"></div>
                                        </div>
                                        <div class="flex flex-col">
                                            <span class="text-sm font-medium text-black" style="font-family: 'Hind Siliguri', 'Noto Sans Bengali', sans-serif;">{{ $shippingTitle }}</span>
                                            @if($shippingDuration)
                                                <span class="text-xs text-gray-500" style="font-family: 'Hind Siliguri', 'Noto Sans Bengali', sans-serif;">{{ $shippingDuration }}</span>
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
                            <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg bg-white cursor-pointer transition-all duration-300 hover:border-green-500 hover:bg-green-50 delivery-option selected" 
                                 data-delivery="default" 
                                 data-shipping-id="0"
                                 data-price="0">
                                <div class="flex items-center gap-3 flex-1">
                                    <div class="w-5 h-5 rounded-full border-2 border-green-500 relative flex-shrink-0 delivery-radio" data-delivery="default">
                                        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-2.5 h-2.5 rounded-full bg-green-500"></div>
                                    </div>
                                    <span class="text-sm font-medium text-black" style="font-family: 'Hind Siliguri', 'Noto Sans Bengali', sans-serif;">{{ translate('standard_delivery') ?? 'স্ট্যান্ডার্ড ডেলিভারি' }}</span>
                                </div>
                                <span class="text-sm font-bold text-black">{{ webCurrencyConverter(0) }}</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="border-t border-gray-200 bg-white p-6 sticky bottom-0 z-10">
                <button id="checkout-confirm-btn" 
                        class="w-full py-4 px-8 bg-orange-500 text-white border-none rounded-lg text-base font-bold cursor-pointer transition-all duration-300 flex items-center justify-center gap-2 hover:bg-orange-600 hover:-translate-y-0.5 hover:shadow-lg disabled:bg-gray-300 disabled:cursor-not-allowed disabled:transform-none disabled:shadow-none"
                        style="font-family: 'Hind Siliguri', 'Noto Sans Bengali', sans-serif;">
                    <span id="checkout-btn-text">অর্ডার কনফার্ম করুন <span id="checkout-btn-total">{{ webCurrencyConverter(amount: $cartTotal) }}</span></span>
                    <span id="checkout-btn-loading" class="hidden">
                        <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        প্রসেসিং...
                    </span>
                </button>
                <p class="text-xs text-gray-500 text-center mt-3 leading-relaxed" style="font-family: 'Hind Siliguri', 'Noto Sans Bengali', sans-serif;">
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
        $('#checkout-name').val('');
        $('#checkout-mobile').val('');
        $('#checkout-address').val('');
        $('#checkout-note').val('');
        selectedDeliveryOption = null;
        deliveryCharge = 0;
        
        // Reset delivery options
        $('.delivery-option').removeClass('border-green-500 bg-green-50 border-2');
        $('.delivery-radio').find('div').addClass('hidden');
        $('.delivery-radio').removeClass('border-green-500');
        
        // Reset price summary
        updateCheckoutTotals();
        
        // Clear errors
        $('.text-red-500').addClass('hidden').text('');
        $('input, textarea').removeClass('border-red-500');
    }

    // Load checkout cart data
    function loadCheckoutCartData() {
        const navCartUrl = $('#route-data').data('route-cart-nav') || '{{ route("cart.nav-cart") }}';
        $.ajax({
            url: navCartUrl,
            method: 'POST',
            data: {
                _token: $('meta[name="_token"]').attr('content')
            },
            success: function(response) {
                if (response && response.data) {
                    // Update cart items in checkout modal
                    // This would require server-side rendering of checkout items
                    // For now, we'll use the initial data
                }
            }
        });
    }

    // Update checkout totals
    function updateCheckoutTotals() {
        const grandTotal = cartSubtotal + deliveryCharge;
        $('#checkout-grand-total').text(formatCurrency(grandTotal));
        $('#checkout-btn-total').text(formatCurrency(grandTotal));
        
        if (deliveryCharge > 0) {
            $('#checkout-delivery-charge').text(formatCurrency(deliveryCharge));
        } else {
            $('#checkout-delivery-charge').text('Select Delivery Area').removeClass('text-green-600').addClass('text-gray-600');
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
        const symbolPosition = '{{ getWebConfig("currency_symbol_position") ?? "right" }}';
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
        
        // Remove selection from all options
        $('.delivery-option').removeClass('border-green-500 bg-green-50 border-2 selected');
        $('.delivery-radio').find('div').addClass('hidden');
        $('.delivery-radio').removeClass('border-green-500').addClass('border-gray-200');
        
        // Select this option
        $option.addClass('border-green-500 bg-green-50 border-2 selected');
        $option.find('.delivery-radio').removeClass('border-gray-200').addClass('border-green-500').find('div').removeClass('hidden');
        
        selectedDeliveryOption = delivery;
        selectedShippingMethodId = shippingId;
        deliveryCharge = price;
        
        updateCheckoutTotals();
    });

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
        const updateUrl = $('#route-data').data('route-cart-update') || '{{ route("cart.updateQuantity") }}';
        
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
                    toastr.error('{{ translate("failed_to_update_quantity") ?? "Failed to update quantity" }}');
                }
            }
        });
    }

    // Recalculate checkout totals
    function recalculateCheckoutTotals() {
        const navCartUrl = $('#route-data').data('route-cart-nav') || '{{ route("cart.nav-cart") }}';
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
        const mobilePattern = /^01[3-9]\d{8}$/;
        if (!mobile || mobile.length !== 11 || !mobilePattern.test(mobile)) {
            showError('checkout-mobile', 'সঠিক মোবাইল নম্বর দিন');
            isValid = false;
        } else {
            hideError('checkout-mobile');
        }
        
        // Address validation
        const address = $('#checkout-address').val().trim();
        if (address.length < 10) {
            showError('checkout-address', 'এই ফিল্ডটি আবশ্যক');
            isValid = false;
        } else {
            hideError('checkout-address');
        }
        
        // Delivery option validation
        if (!selectedDeliveryOption) {
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
    $(document).on('click', '#checkout-confirm-btn', function(e) {
        e.preventDefault();
        
        if (!validateCheckoutForm()) {
            return;
        }
        
        // Disable button and show loading
        const $btn = $(this);
        $btn.prop('disabled', true);
        $('#checkout-btn-text').addClass('hidden');
        $('#checkout-btn-loading').removeClass('hidden');
        
        // Store order note in session first
        const orderNote = $('#checkout-note').val().trim();
        const orderNoteUrl = '{{ route("order_note") }}';
        
        // Store order note and shipping method
        $.ajax({
            url: orderNoteUrl,
            method: 'POST',
            data: {
                _token: $('meta[name="_token"]').attr('content'),
                order_note: orderNote
            },
            success: function() {
                // Store shipping method if selected
                if (selectedShippingMethodId && selectedShippingMethodId !== '0' && selectedShippingMethodId !== 'default') {
                    // Route is GET, so we'll append query parameters
                    const setShippingUrl = '{{ url("/customer/set-shipping-method") }}?id=' + selectedShippingMethodId + '&cart_group_id=all_cart_group';
                    
                    // Use GET request to set shipping method
                    $.ajax({
                        url: setShippingUrl,
                        method: 'GET',
                        success: function() {
                            // Redirect to checkout page after shipping method is set
                            window.location.href = '{{ route("checkout-details") }}';
                        },
                        error: function() {
                            // Even if shipping method fails, proceed to checkout
                            window.location.href = '{{ route("checkout-details") }}';
                        }
                    });
                } else {
                    // No shipping method selected or default, just redirect
                    window.location.href = '{{ route("checkout-details") }}';
                }
            },
            error: function(xhr) {
                $btn.prop('disabled', false);
                $('#checkout-btn-text').removeClass('hidden');
                $('#checkout-btn-loading').addClass('hidden');
                
                if (typeof toastr !== 'undefined') {
                    toastr.error(xhr.responseJSON?.message || '{{ translate("order_failed") ?? "Failed to place order" }}');
                }
            }
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

