// Import main CSS file
import './styles/main.css'

// Initialize Lucide Icons after DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
});

// Wait for jQuery, Slick, and DOM to be ready
function initAll() {
    // Check if jQuery and Slick are available
    if (typeof jQuery === 'undefined' || typeof jQuery.fn === 'undefined' || typeof jQuery.fn.slick === 'undefined') {
        setTimeout(initAll, 100);
        return;
    }

    const $ = jQuery;

    // Use jQuery ready to ensure DOM is loaded
    $(function() {
        // Mobile Menu Toggle
        $('#mobile-menu-btn').click(function () {
            $('#mobile-menu').slideToggle(300);
        });

        // Smooth Scroll for anchor links
        $('a[href^="#"]').on('click', function (event) {
            var target = $(this.getAttribute('href'));
            if (target.length) {
                event.preventDefault();
                $('html, body').stop().animate({
                    scrollTop: target.offset().top - 100 // Adjust for sticky header
                }, 800);
            }
        });

        // Simple "Add to Cart" Animation
        $('.group button:has(.lucide-shopping-cart)').click(function (e) {
            e.preventDefault();
            e.stopPropagation();

            const btn = $(this);
            const originalContent = btn.html();

            // Change to checkmark
            btn.html('<i data-lucide="check" class="w-5 h-5 text-primary-green"></i>');
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }

            // Revert after 1.5s
            setTimeout(function () {
                btn.html(originalContent);
                if (typeof lucide !== 'undefined') {
                    lucide.createIcons();
                }
            }, 1500);
        });

        // Hero Slider Configuration
        $('.hero-slider').slick({
            dots: false,
            infinite: true,
            speed: 1000,
            slidesToShow: 1,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 4000,
            fade: true,
            cssEase: 'linear',
            arrows: false,
            prevArrow: false,
            nextArrow: false,
            pauseOnHover: false,
            pauseOnFocus: false
        });

        // Category Slider Configuration
        if ($('.category-slider').length > 0 && !$('.category-slider').hasClass('slick-initialized')) {
            $('.category-slider').slick({
                dots: false,
                infinite: true,
                speed: 500,
                slidesToShow: 8,
                slidesToScroll: 2,
                autoplay: true,
                autoplaySpeed: 3000,
                arrows: false,
                adaptiveHeight: false,
                responsive: [
                    {
                        breakpoint: 1200,
                        settings: {
                            slidesToShow: 6,
                            slidesToScroll: 2
                        }
                    },
                    {
                        breakpoint: 992,
                        settings: {
                            slidesToShow: 5,
                            slidesToScroll: 2
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 4,
                            slidesToScroll: 2
                        }
                    },
                    {
                        breakpoint: 576,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 1
                        }
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 1
                        }
                    }
                ]
            });
        }

        // Product Slider configuration
        const sliderConfig = {
            dots: false,
            infinite: true,
            speed: 300,
            slidesToShow: 4,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 3000,
            arrows: false,
            prevArrow: '<button type="button" class="slick-prev"><i class="fas fa-chevron-left"></i></button>',
            nextArrow: '<button type="button" class="slick-next"><i class="fas fa-chevron-right"></i></button>',
            responsive: [
                {
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: 4,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 992,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 576,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
            ]
        };

        // Initialize Slick Carousel for each product slider section
        $('.product-slider').each(function () {
            $(this).slick(sliderConfig);
        });

        // Add to cart animation
        $('.action-btn').on('click', function (e) {
            if ($(this).find('.fa-shopping-cart').length) {
                e.preventDefault();
                const btn = $(this);
                const originalHtml = btn.html();

                btn.html('<i class="fas fa-check"></i>');
                btn.css('background', '#4CAF50');

                setTimeout(function () {
                    btn.html(originalHtml);
                    btn.css('background', '');
                }, 1500);
            }
        });

        // Wishlist toggle
        $('.action-btn').on('click', function (e) {
            if ($(this).find('.fa-heart').length) {
                e.preventDefault();
                $(this).toggleClass('active');
                if ($(this).hasClass('active')) {
                    $(this).css('background', '#DC3545');
                    $(this).css('color', '#FFFFFF');
                } else {
                    $(this).css('background', '');
                    $(this).css('color', '');
                }
            }
        });
    });
}

// Wait for all external scripts to load (jQuery and Slick)
function waitForScripts() {
    if (typeof jQuery === 'undefined' || typeof jQuery.fn === 'undefined' || typeof jQuery.fn.slick === 'undefined') {
        setTimeout(waitForScripts, 100);
        return;
    }
    
    // Initialize everything
    initAll();
}

// Start waiting for scripts on DOM ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', waitForScripts);
} else {
    waitForScripts();
}

// Also try on window load as backup
window.addEventListener('load', function() {
    if (typeof jQuery !== 'undefined' && typeof jQuery.fn !== 'undefined' && typeof jQuery.fn.slick !== 'undefined') {
        // Only init if not already initialized
        const $ = jQuery;
        if ($('.category-slider').length > 0 && !$('.category-slider').hasClass('slick-initialized')) {
            initAll();
        }
    }
});

