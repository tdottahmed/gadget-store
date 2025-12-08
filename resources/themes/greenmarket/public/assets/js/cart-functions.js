/**
 * Dynamic Cart Functions for Greenmarket Theme
 */

// Add to Cart Function
function addToCartGreenmarket(productId, quantity = 1, variant = null) {
    if (typeof productId === 'undefined' || !productId) {
        console.error('Product ID is required');
        if (typeof toastr !== 'undefined') {
            toastr.error('Product not found');
        }
        return;
    }

    const cartAddUrl = $('#route-data').data('route-cart-add');
    if (!cartAddUrl) {
        console.error('Cart add route not found');
        return;
    }

    const formData = {
        _token: $('meta[name="_token"]').attr('content'),
        id: productId,
        quantity: quantity
    };

    if (variant) {
        formData.variant = variant;
    }

    $.ajax({
        url: cartAddUrl,
        method: 'POST',
        data: formData,
        beforeSend: function() {
            if ($('#loading').length) {
                $('#loading').removeClass('hidden');
            }
        },
        success: function(response) {
            if ($('#loading').length) {
                $('#loading').addClass('hidden');
            }
            
            if (response.status === 1) {
                if (typeof toastr !== 'undefined') {
                    toastr.success(response.message || 'Product added to cart successfully');
                }
                
                // Update cart count
                updateCartCountGreenmarket();
                
                // Reload the page
                window.location.reload();
            } else {
                if (typeof toastr !== 'undefined') {
                    toastr.error(response.message || 'Failed to add product to cart');
                }
            }
        },
        error: function(xhr) {
            if ($('#loading').length) {
                $('#loading').addClass('hidden');
            }
            const errorMessage = xhr.responseJSON?.message || 'Something went wrong';
            if (typeof toastr !== 'undefined') {
                toastr.error(errorMessage);
            }
        }
    });
}

// Update Cart Count
function updateCartCountGreenmarket() {
    const navCartUrl = $('#route-data').data('route-cart-nav') || '/cart/nav-cart-items';
    
    $.ajax({
        url: navCartUrl,
        method: 'POST',
        data: {
            _token: $('meta[name="_token"]').attr('content')
        },
        success: function(response) {
            if (response && response.data) {
                // Parse the cart partial HTML to get cart count
                const $cartHtml = $(response.data);
                const cartCount = $cartHtml.find('.cart-count-badge').text() || '0';
                const $headerBadge = $('.cart-count-badge');
                
                // Update or create cart count badge in header
                if (parseInt(cartCount) > 0) {
                    if ($headerBadge.length) {
                        $headerBadge.text(cartCount);
                        $headerBadge.attr('title', cartCount + ' {{ translate("items_in_cart") ?? "items in cart" }}');
                    } else {
                        // Add badge if it doesn't exist
                        $('a[href*="shop-cart"]').append('<span class="cart-count-badge absolute -top-2 left-3 flex h-5 w-5 items-center justify-center rounded-full bg-[#DC3545] text-xs font-bold text-white md:-top-3 md:left-4" title="' + cartCount + ' {{ translate("items_in_cart") ?? "items in cart" }}">' + cartCount + '</span>');
                    }
                } else {
                    // Remove badge if cart is empty
                    $headerBadge.remove();
                }
            }
        },
        error: function() {
            console.error('Failed to update cart count');
        }
    });
}

// Load cart sidebar content dynamically
function loadCartSidebarContent() {
    const navCartUrl = $('#route-data').data('route-cart-nav') || '/cart/nav-cart-items';
    
    $.ajax({
        url: navCartUrl,
        method: 'POST',
        data: {
            _token: $('meta[name="_token"]').attr('content')
        },
        success: function(response) {
            if (response && response.data) {
                const $newContent = $(response.data);
                
                // Update cart items container
                if ($newContent.find('#cart-items-container').length) {
                    $('#cart-items-container').html($newContent.find('#cart-items-container').html());
                }
                
                // Update cart footer
                const $newFooter = $newContent.find('.border-t.border-gray-200.bg-white.p-4.space-y-4');
                const $currentFooter = $('#cart-sidebar .border-t.border-gray-200.bg-white.p-4.space-y-4');
                if ($newFooter.length) {
                    if ($currentFooter.length) {
                        $currentFooter.replaceWith($newFooter);
                    } else {
                        $('#cart-sidebar .flex-1.overflow-y-auto').after($newFooter);
                    }
                }
                
                // Update cart count badge
                const cartCount = $newContent.find('.cart-count-badge').text() || '0';
                $('#cart-sidebar .cart-count-badge').text(cartCount);
            }
        },
        error: function() {
            console.error('Failed to load cart sidebar content');
        }
    });
}

// Initialize cart functions on document ready
$(document).ready(function() {
    // Add to cart button click handler - handles both .add-to-cart-btn and .greenmarket-add-to-cart-btn
    $(document).on('click', '.add-to-cart-btn, .greenmarket-add-to-cart-btn', function(e) {
        e.preventDefault();
        e.stopPropagation();
        const productId = $(this).data('product-id');
        if (productId) {
            addToCartGreenmarket(productId, 1);
        } else {
            console.error('Product ID not found on add to cart button');
            if (typeof toastr !== 'undefined') {
                toastr.error('Product ID not found');
            }
        }
        return false;
    });

    // Quick view button click handler
    $(document).on('click', '.quick-view-btn', function(e) {
        e.preventDefault();
        e.stopPropagation();
        const productId = $(this).data('product-id');
        if (productId && typeof quickView !== 'undefined') {
            quickView(productId);
        }
        return false;
    });
});
