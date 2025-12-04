/**
 * Recently Viewed Products Functionality
 * Stores product IDs in cookies and retrieves them for display
 */

// Cookie helper functions
function setCookie(name, value, days) {
    const expires = new Date();
    expires.setTime(expires.getTime() + (days * 24 * 60 * 60 * 1000));
    document.cookie = name + '=' + value + ';expires=' + expires.toUTCString() + ';path=/';
}

function getCookie(name) {
    const nameEQ = name + '=';
    const ca = document.cookie.split(';');
    for (let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) === ' ') c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length, c.length);
    }
    return null;
}

// Add product to recently viewed
function addToRecentlyViewed(productId, productSlug, productName, productImage, productPrice) {
    if (!productId) return;

    const cookieName = 'greenmarket_recently_viewed';
    const maxItems = 10; // Maximum number of recently viewed items
    const cookieExpiryDays = 30; // Cookie expires in 30 days

    // Get existing recently viewed products
    let recentlyViewed = getCookie(cookieName);
    let products = [];

    if (recentlyViewed) {
        try {
            products = JSON.parse(recentlyViewed);
        } catch (e) {
            products = [];
        }
    }

    // Remove product if it already exists (to move it to the top)
    products = products.filter(p => p.id !== productId);

    // Add new product to the beginning
    products.unshift({
        id: productId,
        slug: productSlug,
        name: productName,
        image: productImage,
        price: productPrice,
        viewedAt: new Date().toISOString()
    });

    // Keep only the most recent items
    if (products.length > maxItems) {
        products = products.slice(0, maxItems);
    }

    // Save back to cookie
    setCookie(cookieName, JSON.stringify(products), cookieExpiryDays);
}

// Get recently viewed products
function getRecentlyViewed() {
    const cookieName = 'greenmarket_recently_viewed';
    const recentlyViewed = getCookie(cookieName);
    
    if (!recentlyViewed) {
        return [];
    }

    try {
        return JSON.parse(recentlyViewed);
    } catch (e) {
        return [];
    }
}

// Load recently viewed products and display them
function loadRecentlyViewedProducts() {
    const recentlyViewed = getRecentlyViewed();
    const container = $('#recently-viewed-container');
    
    if (!container.length) {
        return;
    }

    if (recentlyViewed.length === 0) {
        container.html('<div class="text-center py-8 text-gray-500">No recently viewed products</div>');
        // Hide slider navigation if no products
        $('.recently-prev, .recently-next').hide();
        return;
    }

    // Show slider navigation
    $('.recently-prev, .recently-next').show();

    // Render from cookie data (simpler approach)
    renderRecentlyViewedFromCookie(recentlyViewed);
}

// Render products from server data
function renderRecentlyViewedProducts(products) {
    const container = $('#recently-viewed-container');
    let html = '';
    
    products.forEach(function(product) {
        html += generateProductCardHTML(product);
    });
    
    container.html(html);
    
    // Initialize slider if slick is available
    if (typeof $ !== 'undefined' && $.fn.slick) {
        if ($('.recently-viewed-slider').hasClass('slick-initialized')) {
            $('.recently-viewed-slider').slick('unslick');
        }
        initializeRecentlyViewedSlider();
    }
}

// Render products from cookie data
function renderRecentlyViewedFromCookie(recentlyViewed) {
    const container = $('#recently-viewed-container');
    let html = '';
    
    // Limit to 10 most recent items
    const itemsToShow = recentlyViewed.slice(0, 10);
    
    itemsToShow.forEach(function(item) {
        const productSlug = item.slug || '';
        const productName = item.name || 'Product';
        const productImage = item.image || 'https://prd.place/400';
        const productPrice = item.price || '৳0';
        const productId = item.id || '';
        
        html += `
            <div class="bg-transparent rounded-lg shadow-md border-1 border-gray-50 overflow-hidden group">
                <div class="relativ p-8">
                    <a href="/product/${productSlug}">
                        <img src="${productImage}" alt="${productName}" class="w-full h-64 object-contain">
                    </a>
                </div>
                <div class="bg-[#F2F2F2] flex">
                    <a href="/product/${productSlug}" class="flex-1 py-3 flex items-center justify-center border-r hover:cursor-pointer border-gray-200">
                        <i class="fa-regular fa-eye"></i>
                    </a>
                    <button class="flex-1 py-3 flex items-center justify-center hover:cursor-pointer add-to-cart-btn" data-product-id="${productId}" data-product-slug="${productSlug}">
                        <i class="fas fa-shopping-cart text-lg md:text-xl"></i>
                    </button>
                </div>
                <div class="p-4">
                    <a href="/product/${productSlug}">
                        <h3 class="text-sm font-bold text-[#222222] mb-2 line-clamp-2">${productName}</h3>
                    </a>
                    <div class="flex items-center gap-2">
                        <span class="text-2xl font-bold text-[#669900]">${productPrice}</span>
                    </div>
                </div>
            </div>
        `;
    });
    
    container.html(html);
    
    // Initialize slider if slick is available
    if (typeof $ !== 'undefined' && $.fn.slick) {
        setTimeout(function() {
            if ($('.recently-viewed-slider').hasClass('slick-initialized')) {
                $('.recently-viewed-slider').slick('unslick');
            }
            initializeRecentlyViewedSlider();
        }, 100);
    }
}

// Generate product card HTML
function generateProductCardHTML(product) {
    const productSlug = product.slug || '';
    const productName = product.name || 'Product';
    const productImage = product.thumbnail_full_url ? getProductImageUrl(product.thumbnail_full_url) : 'https://prd.place/400';
    const productPrice = product.discounted_price || product.unit_price || '৳0';
    const productDiscountPrice = product.discount > 0 ? product.unit_price : null;
    const productId = product.id;
    
    return `
        <div class="bg-transparent rounded-lg shadow-md border-1 border-gray-50 overflow-hidden group">
            <div class="relativ p-8">
                <a href="/product/${productSlug}">
                    <img src="${productImage}" alt="${productName}" class="w-full h-64 object-contain">
                </a>
            </div>
            <div class="bg-[#F2F2F2] flex">
                <a href="/product/${productSlug}" class="flex-1 py-3 flex items-center justify-center border-r hover:cursor-pointer border-gray-200">
                    <i class="fa-regular fa-eye"></i>
                </a>
                <button class="flex-1 py-3 flex items-center justify-center hover:cursor-pointer add-to-cart-btn" data-product-id="${productId}" data-product-slug="${productSlug}">
                    <i class="fas fa-shopping-cart text-lg md:text-xl"></i>
                </button>
            </div>
            <div class="p-4">
                <a href="/product/${productSlug}">
                    <h3 class="text-sm font-bold text-[#222222] mb-2 line-clamp-2">${productName}</h3>
                </a>
                <div class="flex items-center gap-2">
                    <span class="text-2xl font-bold text-[#669900]">${productPrice}</span>
                    ${productDiscountPrice ? `<span class="text-medium text-[#afb4be] line-through">${productDiscountPrice}</span>` : ''}
                </div>
            </div>
        </div>
    `;
}

// Helper function to get product image URL
function getProductImageUrl(path) {
    if (!path) return 'https://prd.place/400';
    if (path.startsWith('http')) return path;
    return '/storage/app/public/product/thumbnail/' + path;
}

// Initialize recently viewed slider
function initializeRecentlyViewedSlider() {
    if ($('.recently-viewed-slider').length && typeof $ !== 'undefined' && $.fn.slick) {
        $('.recently-viewed-slider').slick({
            slidesToShow: 4,
            slidesToScroll: 1,
            infinite: true,
            arrows: false,
            dots: false,
            responsive: [{
                breakpoint: 992,
                settings: {
                    slidesToShow: 3
                }
            }, {
                breakpoint: 768,
                settings: {
                    slidesToShow: 2
                }
            }, {
                breakpoint: 576,
                settings: {
                    slidesToShow: 1
                }
            }]
        });
    }
}

// Track product view on product details page
$(document).ready(function() {
    // Check if we're on a product details page
    if ($('#product-details-page').length) {
        const productData = $('#product-details-page');
        const productId = productData.data('product-id');
        const productSlug = productData.data('product-slug');
        const productName = productData.data('product-name');
        const productImage = productData.data('product-image');
        const productPrice = productData.data('product-price');

        if (productId) {
            addToRecentlyViewed(productId, productSlug, productName, productImage, productPrice);
        }
    }

    // Track product views when clicking on product links (eye icon or product card)
    $(document).on('click', 'a[href*="/product/"], a.quick-view-btn', function(e) {
        // Don't prevent default, let the link work normally
        const href = $(this).attr('href');
        if (!href) return;
        
        const productSlug = href.split('/product/').pop().split('?')[0];
        
        // Extract product ID from data attribute if available
        const productCard = $(this).closest('.bg-transparent.rounded-lg, .product-card');
        const productId = productCard.find('[data-product-id]').data('product-id') || 
                          $(this).data('product-id') ||
                          productCard.find('.add-to-cart-btn').data('product-id');
        
        if (productId) {
            const productName = productCard.find('h3').text().trim() || $(this).closest('[class*="product"]').find('h3').text().trim();
            const productImage = productCard.find('img').first().attr('src') || $(this).find('img').attr('src');
            const productPrice = productCard.find('[class*="text-2xl"], [class*="text-[#669900]"]').first().text().trim();
            
            if (productId && productSlug) {
                addToRecentlyViewed(productId, productSlug, productName, productImage, productPrice);
            }
        }
    });

    // Load recently viewed products on page load
    setTimeout(function() {
        loadRecentlyViewedProducts();
    }, 500);
});

