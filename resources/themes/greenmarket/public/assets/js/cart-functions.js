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
                
                // Open cart sidebar
                if ($('#cart-sidebar').length) {
                    $('#cart-sidebar-overlay').removeClass('hidden');
                    $('#cart-sidebar').removeClass('translate-x-full');
                    $('body').addClass('overflow-hidden');
                    
                    // Reload page to refresh cart sidebar content
                    setTimeout(function() {
                        window.location.reload();
                    }, 500);
                }
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
            // Cart count will be updated when page reloads
            // For now, we'll reload the page to get fresh cart data
        }
    });
}

// Initialize cart functions on document ready
$(document).ready(function() {
    // Add to cart button click handler
    $(document).on('click', '.add-to-cart-btn', function(e) {
        e.preventDefault();
        e.stopPropagation();
        const productId = $(this).data('product-id');
        if (productId) {
            addToCartGreenmarket(productId, 1);
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
