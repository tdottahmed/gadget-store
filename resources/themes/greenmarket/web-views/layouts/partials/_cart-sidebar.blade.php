@php
    use App\Utils\CartManager;
    use App\Models\Product;
    $cart = CartManager::getCartListQuery();
    $cartTotal = CartManager::getCartListTotalAppliedDiscount($cart);
@endphp

<!-- Cart Sidebar Overlay -->
<div id="cart-sidebar-overlay"
    class="fixed inset-0 bg-black bg-opacity-50 z-[9998] hidden transition-opacity duration-300"></div>

<!-- Cart Sidebar -->
<div id="cart-sidebar"
    class="fixed top-0 right-0 h-full w-full md:w-[420px] lg:w-[450px] bg-white z-[9999] transform translate-x-full transition-transform duration-300 ease-in-out shadow-2xl flex flex-col">
    <!-- Cart Header -->
    <div class="flex items-center justify-between px-4 py-4 border-b border-gray-200 bg-white">
        <div class="flex items-center gap-3">
            <a href="{{ route('home') }}"
                class="text-gray-600 hover:text-gray-900 transition-colors flex items-center gap-2">
                <i class="fas fa-arrow-left text-lg"></i>
                <span
                    class="text-sm font-medium hidden sm:inline">{{ translate('continue_shopping') ?? 'Continue Shopping' }}</span>
            </a>
        </div>
        <div class="flex items-center gap-4">
            <h2 class="text-lg font-bold text-black">{{ translate('your_cart') ?? 'Your Cart' }}</h2>
            <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center">
                <span class="text-sm font-bold text-gray-700 cart-count-badge">{{ $cart->count() }}</span>
            </div>
        </div>
    </div>

    <!-- Cart Content -->
    <div class="flex-1 overflow-y-auto">
        @if ($cart->count() > 0)
            <div class="p-4 space-y-4" id="cart-items-container">
                @foreach ($cart as $cartItem)
                    @php
                        $product = Product::find($cartItem['product_id'] ?? ($cartItem->product_id ?? null));
                        if ($product) {
                            $productImage = getStorageImages(path: $product->thumbnail_full_url ?? $product->thumbnail ?? '', type: 'product');
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
                    <div class="flex items-start gap-3 pb-4 border-b border-gray-100 cart-item"
                        data-cart-id="{{ $cartId }}" data-product-id="{{ $product ? $product->id : '' }}"
                        data-max-quantity="{{ $maxQuantity }}">
                        <!-- Product Image -->
                        <div
                            class="w-20 h-20 md:w-24 md:h-24 flex-shrink-0 bg-gray-50 rounded-lg overflow-hidden border border-gray-200">
                            <img src="{{ $productImage }}" alt="{{ $productName }}"
                                class="w-full h-full object-contain">
                        </div>

                        <!-- Product Details -->
                        <div class="flex-1 min-w-0">
                            <h3 class="text-sm font-semibold text-black mb-2 line-clamp-2">{{ $productName }}</h3>

                            <!-- Quantity Controls -->
                            <div class="flex items-center gap-2 mb-3">
                                <button
                                    class="w-8 h-8 border border-gray-300 rounded flex items-center justify-center text-gray-600 hover:bg-gray-50 transition-colors decrease-quantity {{ $quantity <= 1 ? 'opacity-50 cursor-not-allowed' : '' }}"
                                    data-cart-id="{{ $cartId }}" {{ $quantity <= 1 ? 'disabled' : '' }}>
                                    <i class="fas fa-minus text-xs"></i>
                                </button>
                                <input type="number" value="{{ $quantity }}" min="1"
                                    max="{{ $maxQuantity }}" readonly
                                    class="w-10 h-8 border border-gray-300 rounded text-center text-sm font-medium text-gray-700 quantity-input"
                                    data-cart-id="{{ $cartId }}" data-max="{{ $maxQuantity }}">
                                <button
                                    class="w-8 h-8 border border-gray-300 rounded flex items-center justify-center text-gray-600 hover:bg-gray-50 transition-colors increase-quantity {{ $quantity >= $maxQuantity ? 'opacity-50 cursor-not-allowed' : '' }}"
                                    data-cart-id="{{ $cartId }}" data-max="{{ $maxQuantity }}"
                                    {{ $quantity >= $maxQuantity ? 'disabled' : '' }}>
                                    <i class="fas fa-plus text-xs"></i>
                                </button>
                            </div>
                            @if ($quantity >= $maxQuantity)
                                <p class="text-xs text-red-500 mb-2">
                                    {{ translate('max_quantity_reached') ?? 'Maximum quantity reached' }}</p>
                            @endif

                            <!-- Price and Delete -->
                            <div class="flex items-center justify-between">
                                <span class="text-base font-bold text-black cart-item-subtotal"
                                    data-cart-id="{{ $cartId }}">{{ webCurrencyConverter(amount: $subtotal) }}</span>
                                <button
                                    class="text-red-500 hover:text-red-700 transition-colors greenmarket-remove-cart-item"
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
            <div class="flex flex-col items-center justify-center h-full px-4 py-12">
                <div class="w-24 h-24 rounded-full bg-gray-100 flex items-center justify-center mb-4">
                    <i class="fas fa-shopping-cart text-4xl text-gray-400"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-700 mb-2">
                    {{ translate('your_cart_is_empty') ?? 'Your cart is empty' }}</h3>
                <p class="text-sm text-gray-500 text-center mb-6">
                    {{ translate('add_items_to_cart') ?? 'Add items to your cart to continue shopping' }}</p>
                <a href="{{ route('home') }}"
                    class="px-6 py-2 bg-primary-dynamic text-white rounded-md font-semibold transition-colors">
                    {{ translate('continue_shopping') ?? 'Continue Shopping' }}
                </a>
            </div>
        @endif
    </div>

    <!-- Cart Footer -->
    @if ($cart->count() > 0)
        <div class="border-t border-gray-200 bg-white p-4 space-y-4">
            <!-- Total -->
            <div class="flex items-center justify-between">
                <span class="text-base font-bold text-black">{{ translate('total') ?? 'Total' }}</span>
                <span class="text-xl font-bold text-black"
                    id="cart-total-price">{{ webCurrencyConverter(amount: $cartTotal) }}</span>
            </div>

            <!-- Order Button -->
            <button onclick="openCheckoutModal()"
                class="block w-full py-3 px-6 bg-primary-dynamic text-white rounded-lg font-bold text-center transition-colors">
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

            // Quantity increase
            $(document).on('click', '.increase-quantity', function(e) {
                e.preventDefault();
                e.stopPropagation();
                if ($(this).prop('disabled')) return false;

                const cartId = $(this).data('cart-id');
                const maxQty = parseInt($(this).data('max')) || 999;
                const quantityInput = $(this).siblings('.quantity-input');
                const currentQty = parseInt(quantityInput.val()) || 1;

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

            // Quantity decrease
            $(document).on('click', '.decrease-quantity', function(e) {
                e.preventDefault();
                e.stopPropagation();
                if ($(this).prop('disabled')) return false;

                const cartId = $(this).data('cart-id');
                const quantityInput = $(this).siblings('.quantity-input');
                const currentQty = parseInt(quantityInput.val()) || 1;

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

            // Update quantity function
            function updateQuantity(cartId, quantity) {
                const updateUrl = $('#route-data').data('route-cart-update') ||
                    '{{ route('cart.updateQuantity') }}';
                const $cartItem = $('.cart-item[data-cart-id="' + cartId + '"]');
                const $quantityInput = $cartItem.find('.quantity-input');
                const $increaseBtn = $cartItem.find('.increase-quantity');
                const $decreaseBtn = $cartItem.find('.decrease-quantity');
                const maxQty = parseInt($cartItem.data('max-quantity')) || 999;

                // Disable buttons during update
                $increaseBtn.prop('disabled', true);
                $decreaseBtn.prop('disabled', true);

                $.ajax({
                    url: updateUrl,
                    method: 'POST',
                    data: {
                        _token: $('meta[name="_token"]').attr('content'),
                        key: cartId,
                        quantity: quantity
                    },
                    success: function(response) {
                        // Response can be HTML string (success) or JSON object (error)
                        let isSuccess = false;
                        let errorMessage = '';

                        if (typeof response === 'string') {
                            // HTML response means success
                            isSuccess = true;
                        } else if (response && typeof response === 'object') {
                            // JSON response - check status
                            if (response.status === 0) {
                                isSuccess = false;
                                errorMessage = response.message ||
                                    '{{ translate('failed_to_update_quantity') ?? 'Failed to update quantity' }}';
                            } else {
                                isSuccess = true;
                            }
                        } else {
                            // Assume success if we can't determine
                            isSuccess = true;
                        }

                        if (isSuccess) {
                            // Update quantity input
                            $quantityInput.val(quantity);

                            // Update button states
                            if (quantity >= maxQty) {
                                $increaseBtn.prop('disabled', true).addClass(
                                    'opacity-50 cursor-not-allowed');
                            } else {
                                $increaseBtn.prop('disabled', false).removeClass(
                                    'opacity-50 cursor-not-allowed');
                            }

                            if (quantity <= 1) {
                                $decreaseBtn.prop('disabled', true).addClass(
                                    'opacity-50 cursor-not-allowed');
                            } else {
                                $decreaseBtn.prop('disabled', false).removeClass(
                                    'opacity-50 cursor-not-allowed');
                            }

                            // Recalculate cart totals
                            recalculateCartTotals();
                            updateCartCount();

                            if (typeof toastr !== 'undefined') {
                                toastr.success(
                                    '{{ translate('quantity_updated') ?? 'Quantity updated' }}');
                            }
                        } else {
                            // Revert quantity on error
                            const currentQty = parseInt($quantityInput.val()) || 1;
                            $quantityInput.val(currentQty);

                            if (typeof toastr !== 'undefined') {
                                toastr.error(errorMessage);
                            }
                        }

                        // Re-enable buttons
                        $increaseBtn.prop('disabled', false);
                        $decreaseBtn.prop('disabled', false);
                    },
                    error: function(xhr) {
                        // Re-enable buttons
                        $increaseBtn.prop('disabled', false);
                        $decreaseBtn.prop('disabled', false);

                        const currentQty = parseInt($quantityInput.val()) || 1;
                        $quantityInput.val(currentQty);

                        if (typeof toastr !== 'undefined') {
                            toastr.error(xhr.responseJSON?.message ||
                                '{{ translate('failed_to_update_quantity') ?? 'Failed to update quantity' }}'
                                );
                        }
                    }
                });
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

            // Recalculate cart totals from server
            function recalculateCartTotals() {
                // Reload cart totals from server for accurate calculation
                const navCartUrl = $('#route-data').data('route-cart-nav') || '{{ route('cart.nav-cart') }}';
                $.ajax({
                    url: navCartUrl,
                    method: 'POST',
                    data: {
                        _token: $('meta[name="_token"]').attr('content')
                    },
                    success: function(response) {
                        if (response && response.data) {
                            // Get updated total from server response
                            const $newContent = $(response.data);
                            const serverTotal = $newContent.find('#cart-total-price').text();
                            if (serverTotal) {
                                $('#cart-total-price').text(serverTotal);
                            }

                            // Update individual item subtotals and quantities
                            $newContent.find('.cart-item').each(function() {
                                const cartId = $(this).data('cart-id');
                                if (cartId) {
                                    const newSubtotal = $(this).find('.cart-item-subtotal')
                                        .text();
                                    const newQuantity = $(this).find('.quantity-input').val();

                                    if (newSubtotal) {
                                        $('.cart-item-subtotal[data-cart-id="' + cartId + '"]')
                                            .text(newSubtotal);
                                    }

                                    if (newQuantity) {
                                        $('.quantity-input[data-cart-id="' + cartId + '"]').val(
                                            newQuantity);

                                        // Update button states
                                        const maxQty = parseInt($('.cart-item[data-cart-id="' +
                                            cartId + '"]').data('max-quantity')) || 999;
                                        const $cartItem = $('.cart-item[data-cart-id="' +
                                            cartId + '"]');
                                        const $increaseBtn = $cartItem.find(
                                            '.increase-quantity');
                                        const $decreaseBtn = $cartItem.find(
                                            '.decrease-quantity');

                                        if (parseInt(newQuantity) >= maxQty) {
                                            $increaseBtn.prop('disabled', true).addClass(
                                                'opacity-50 cursor-not-allowed');
                                        } else {
                                            $increaseBtn.prop('disabled', false).removeClass(
                                                'opacity-50 cursor-not-allowed');
                                        }

                                        if (parseInt(newQuantity) <= 1) {
                                            $decreaseBtn.prop('disabled', true).addClass(
                                                'opacity-50 cursor-not-allowed');
                                        } else {
                                            $decreaseBtn.prop('disabled', false).removeClass(
                                                'opacity-50 cursor-not-allowed');
                                        }
                                    }
                                }
                            });
                        }
                    }
                });
            }

            // Load cart sidebar content dynamically
            function loadCartSidebar() {
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

                            // Update cart count badge
                            const cartCount = $newContent.find('.cart-count-badge').text() || '0';
                            $('#cart-sidebar .cart-count-badge').text(cartCount);

                            // Re-attach event handlers after content update
                            if (typeof attachRemoveHandlers === 'function') {
                                attachRemoveHandlers();
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

            // Update cart count in header
            function updateCartCount() {
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
                    },
                    error: function() {
                        console.error('Failed to update cart count');
                    }
                });
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
