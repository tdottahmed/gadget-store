@php
    use App\Utils\CartManager;
    use App\Models\Product;
    $cart = CartManager::getCartListQuery();
    $cartTotal = CartManager::getCartListTotalAppliedDiscount($cart);
@endphp

<!-- Cart Sidebar Overlay -->
<div id="cart-sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-[9998] hidden transition-opacity duration-300"></div>

<!-- Cart Sidebar -->
<div id="cart-sidebar" class="fixed top-0 right-0 h-full w-full md:w-[420px] lg:w-[450px] bg-white z-[9999] transform translate-x-full transition-transform duration-300 ease-in-out shadow-2xl flex flex-col">
    <!-- Cart Header -->
    <div class="flex items-center justify-between px-4 py-4 border-b border-gray-200 bg-white">
        <div class="flex items-center gap-3">
            <a href="{{ route('home') }}" class="text-gray-600 hover:text-gray-900 transition-colors flex items-center gap-2">
                <i class="fas fa-arrow-left text-lg"></i>
                <span class="text-sm font-medium hidden sm:inline">{{ translate('continue_shopping') ?? 'Continue Shopping' }}</span>
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
        @if($cart->count() > 0)
            <div class="p-4 space-y-4" id="cart-items-container">
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
                    @endphp
                    <div class="flex items-start gap-3 pb-4 border-b border-gray-100 cart-item" data-cart-id="{{ $cartId }}">
                        <!-- Product Image -->
                        <div class="w-20 h-20 md:w-24 md:h-24 flex-shrink-0 bg-gray-50 rounded-lg overflow-hidden border border-gray-200">
                            <img src="{{ $productImage }}" alt="{{ $productName }}" class="w-full h-full object-contain">
                        </div>

                        <!-- Product Details -->
                        <div class="flex-1 min-w-0">
                            <h3 class="text-sm font-semibold text-black mb-2 line-clamp-2">{{ $productName }}</h3>
                            
                            <!-- Quantity Controls -->
                            <div class="flex items-center gap-2 mb-3">
                                <button class="w-8 h-8 border border-gray-300 rounded flex items-center justify-center text-gray-600 hover:bg-gray-50 transition-colors decrease-quantity" 
                                        data-cart-id="{{ $cartId }}">
                                    <i class="fas fa-minus text-xs"></i>
                                </button>
                                <input type="number" 
                                       value="{{ $quantity }}" 
                                       min="1" 
                                       readonly
                                       class="w-10 h-8 border border-gray-300 rounded text-center text-sm font-medium text-gray-700 quantity-input"
                                       data-cart-id="{{ $cartId }}">
                                <button class="w-8 h-8 border border-gray-300 rounded flex items-center justify-center text-gray-600 hover:bg-gray-50 transition-colors increase-quantity"
                                        data-cart-id="{{ $cartId }}">
                                    <i class="fas fa-plus text-xs"></i>
                                </button>
                            </div>

                            <!-- Price and Delete -->
                            <div class="flex items-center justify-between">
                                <span class="text-base font-bold text-black">{{ webCurrencyConverter(amount: $subtotal) }}</span>
                                <button class="text-red-500 hover:text-red-700 transition-colors remove-cart-item" 
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
                <h3 class="text-lg font-semibold text-gray-700 mb-2">{{ translate('your_cart_is_empty') ?? 'Your cart is empty' }}</h3>
                <p class="text-sm text-gray-500 text-center mb-6">{{ translate('add_items_to_cart') ?? 'Add items to your cart to continue shopping' }}</p>
                <a href="{{ route('home') }}" class="px-6 py-2 bg-[#003315] text-white rounded-md font-semibold hover:bg-[#004d1f] transition-colors">
                    {{ translate('continue_shopping') ?? 'Continue Shopping' }}
                </a>
            </div>
        @endif
    </div>

    <!-- Cart Footer -->
    @if($cart->count() > 0)
        <div class="border-t border-gray-200 bg-white p-4 space-y-4">
            <!-- Total -->
            <div class="flex items-center justify-between">
                <span class="text-base font-bold text-black">{{ translate('total') ?? 'Total' }}</span>
                <span class="text-xl font-bold text-black" id="cart-total-price">{{ webCurrencyConverter(amount: $cartTotal) }}</span>
            </div>

            <!-- Order Button -->
            <a href="{{ route('shop-cart') }}" class="block w-full py-3 px-6 bg-[#003315] text-white rounded-lg font-bold text-center hover:bg-[#004d1f] transition-colors">
                {{ translate('order_now') ?? 'অর্ডার করুন' }}
            </a>
        </div>
    @endif
</div>

@push('script')
<script>
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

        // Prevent closing when clicking inside sidebar
        $('#cart-sidebar').on('click', function(e) {
            e.stopPropagation();
        });

        // Quantity increase
        $(document).on('click', '.increase-quantity', function() {
            const cartId = $(this).data('cart-id');
            const quantityInput = $(this).siblings('.quantity-input');
            const currentQty = parseInt(quantityInput.val());
            updateQuantity(cartId, currentQty + 1);
        });

        // Quantity decrease
        $(document).on('click', '.decrease-quantity', function() {
            const cartId = $(this).data('cart-id');
            const quantityInput = $(this).siblings('.quantity-input');
            const currentQty = parseInt(quantityInput.val());
            if (currentQty > 1) {
                updateQuantity(cartId, currentQty - 1);
            }
        });

        // Remove item
        $(document).on('click', '.remove-cart-item', function() {
            const cartId = $(this).data('cart-id');
            removeCartItem(cartId);
        });

        // Update quantity function
        function updateQuantity(cartId, quantity) {
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
                    if (response && response.status !== 0) {
                        // Reload cart sidebar content
                        loadCartSidebar();
                        updateCartCount();
                        if (typeof toastr !== 'undefined') {
                            toastr.success('{{ translate("quantity_updated") ?? "Quantity updated" }}');
                        }
                    } else {
                        if (typeof toastr !== 'undefined') {
                            toastr.error(response?.message || '{{ translate("failed_to_update_quantity") ?? "Failed to update quantity" }}');
                        }
                    }
                },
                error: function(xhr) {
                    if (typeof toastr !== 'undefined') {
                        toastr.error(xhr.responseJSON?.message || '{{ translate("failed_to_update_quantity") ?? "Failed to update quantity" }}');
                    }
                }
            });
        }

        // Remove cart item function
        function removeCartItem(cartId) {
            if (confirm('{{ translate("are_you_sure_remove") ?? "Are you sure you want to remove this item?" }}')) {
                const removeUrl = $('#route-data').data('route-cart-remove') || '{{ route("cart.remove") }}';
                $.ajax({
                    url: removeUrl,
                    method: 'POST',
                    data: {
                        _token: $('meta[name="_token"]').attr('content'),
                        key: cartId
                    },
                    success: function(response) {
                        if (response && response.message) {
                            // Reload cart sidebar content
                            loadCartSidebar();
                            updateCartCount();
                            if (typeof toastr !== 'undefined') {
                                toastr.success(response.message || '{{ translate("item_removed") ?? "Item removed from cart" }}');
                            }
                        }
                    },
                    error: function(xhr) {
                        if (typeof toastr !== 'undefined') {
                            toastr.error(xhr.responseJSON?.message || '{{ translate("failed_to_remove_item") ?? "Failed to remove item" }}');
                        }
                    }
                });
            }
        }

        // Load cart sidebar content dynamically
        function loadCartSidebar() {
            const navCartUrl = $('#route-data').data('route-cart-nav') || '{{ route("cart.nav-cart") }}';
            $.ajax({
                url: navCartUrl,
                method: 'POST',
                data: {
                    _token: $('meta[name="_token"]').attr('content')
                },
                success: function(response) {
                    if (response && response.data) {
                        // Reload the entire page to refresh cart sidebar
                        // This ensures all cart data is up to date
                        window.location.reload();
                    }
                },
                error: function() {
                    if (typeof toastr !== 'undefined') {
                        toastr.error('{{ translate("failed_to_load_cart") ?? "Failed to load cart data" }}');
                    }
                }
            });
        }

        // Update cart count in header
        function updateCartCount() {
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
                        const cartCount = $newContent.find('.cart-count-badge').text() || '0';
                        const $headerBadge = $('.cart-count-badge');
                        
                        if (parseInt(cartCount) > 0) {
                            if ($headerBadge.length) {
                                $headerBadge.text(cartCount);
                            } else {
                                // Add badge if it doesn't exist
                                $('a[href*="shop-cart"]').append('<span class="cart-count-badge absolute -top-2 left-3 flex h-5 w-5 items-center justify-center rounded-full bg-[#DC3545] text-xs font-bold text-white md:-top-3 md:left-4">' + cartCount + '</span>');
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
        $(document).on('click', 'a[href*="shop-cart"], a[href="{{ route("shop-cart") }}"]', function(e) {
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

