<!-- Header -->
<header class="relative z-[1000]">
  <!-- Top Bar - Hidden on tablet and mobile -->
  <div class="hidden top-bar-bg py-2 text-white lg:block">
    <div class="mx-auto flex max-w-[1240px] items-center justify-between px-4 py-1 text-sm">
      <div class="hidden items-center gap-2 md:flex">
        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
        </svg>
        <span class="hidden lg:inline">{{ getWebConfig('company_phone') ?? '' }}</span>
      </div>
      <div class="hidden items-center gap-2 lg:flex">
        {{-- <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
        </svg>
        <span
              class="font-medium text-[#d8f7e5]">{{ getWebConfig('announcement')['text'] ?? translate('') }}</span> --}}
      </div>
      <div class="hidden items-center gap-2 lg:flex">
        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span class="font-medium text-[#d8f7e5]">Customer Help</span>
      </div>
    </div>
  </div>

  <!-- Main Header -->
  <div class="main-header-bg">
    <div
         class="mx-auto flex max-w-[1240px] items-center justify-between gap-2 px-3 py-2 sm:gap-4 sm:px-4 sm:py-3 md:gap-4 md:px-6 lg:gap-4 lg:px-2 lg:py-3">
      <!-- Logo -->
      <div class="flex-shrink-0">
        <a href="{{ route('home') }}" class="flex items-center">
          <img src="{{ $web_config['web_logo']['path'] ?? '' }}" alt="{{ $web_config['company_name'] ?? 'Logo' }}"
               class="h-8 w-auto object-contain sm:h-10 md:h-12 lg:h-14"
               onerror="this.src='{{ $web_config['web_logo']['path'] ?? '' }}'">
        </a>
      </div>

      <!-- Search Bar - Hidden on mobile, adjusted on tablet -->
      <div class="hidden max-w-5xl flex-1 md:mx-2 md:flex lg:mx-8">
        <div class="relative w-full">
          <form action="{{ route('products') }}" method="GET" class="relative">
            <input type="text" 
                   id="search-input-desktop"
                   name="name"
                   autocomplete="off"
                   placeholder="{{ translate('search') }}.."
                   class="w-full top-bar-bg px-10 py-2 pr-12 text-sm font-semibold text-white placeholder-[#a8d4c0] focus:outline-none md:py-3 lg:py-3">
            <button type="submit" class="absolute left-3 top-1/2 -translate-y-1/2">
              <svg class="h-5 w-5 text-[#a8d4c0]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
              </svg>
            </button>
          </form>
          <!-- Search Results Dropdown -->
          <div id="search-results-desktop" class="absolute left-0 right-0 top-full z-50 mt-1 hidden max-h-96 overflow-y-auto rounded-lg bg-white shadow-lg">
            <div id="search-results-content-desktop" class="p-2">
              <!-- Results will be inserted here -->
            </div>
            <div id="search-loading-desktop" class="hidden p-4 text-center text-gray-500">
              <i class="fas fa-spinner fa-spin"></i> {{ translate('searching') }}...
            </div>
            <div id="search-empty-desktop" class="hidden p-4 text-center text-gray-500">
              {{ translate('no_products_found') }}
            </div>
          </div>
        </div>
      </div>

      <!-- Cart -->
      <div class="flex flex-shrink-0 py-3 md:py-0 items-center gap-3 sm:gap-5 md:gap-6 lg:pr-4">
        <a href="{{ route('shop-cart') }}" class="relative flex items-center gap-1 text-white md:gap-2 cart-button" title="{{ translate('cart') ?? 'Cart' }}">
          <i class="fas fa-shopping-cart text-lg md:text-xl"></i>
          @php
            use App\Utils\CartManager;
            $cart = CartManager::getCartListQuery();
            $cartCount = $cart->count();
          @endphp
          @if ($cartCount > 0)
            <span
                  class="cart-count-badge absolute -top-2 left-3 flex h-5 w-5 items-center justify-center rounded-full bg-[#DC3545] text-xs font-bold text-white md:-top-3 md:left-4" 
                  title="{{ translate('items_in_cart') ?? $cartCount . ' items in cart' }}">{{ $cartCount }}</span>
          @endif
          <span class="hidden text-sm md:inline">{{ translate('cart') }}</span>
        </a>
        <!-- Mobile Search Icon - Visible only on mobile -->
        <button class="ml-2 md:ml-0 text-xl text-white md:hidden" id="mobile-search-button-open">
          <i class="fas fa-search"></i>
        </button>
      </div>
    </div>

    <!-- Mobile Search Bar - Hidden by default -->
    <div id="mobile-search-container" class="hidden border-t border-[var(--primary-color-light)] bg-[var(--primary-color)] px-3 py-2 md:hidden">
      <div class="relative">
        <form action="{{ route('products') }}" method="GET" class="relative">
          <input type="text" 
                 id="search-input-mobile"
                 name="name"
                 autocomplete="off"
                 placeholder="{{ translate('search') }}.."
                 class="w-full top-bar-bg px-10 py-2 pr-12 text-sm font-semibold text-white placeholder-[#a8d4c0] focus:outline-none">
          <button type="submit" class="absolute left-3 top-1/2 -translate-y-1/2">
            <svg class="h-5 w-5 text-[#a8d4c0]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
          </button>
          <button type="button" id="mobile-search-button-close" class="absolute right-3 top-1/2 -translate-y-1/2 text-white">
            <i class="fas fa-times"></i>
          </button>
        </form>
        <!-- Mobile Search Results Dropdown -->
        <div id="search-results-mobile" class="absolute left-0 right-0 top-full z-50 mt-1 hidden max-h-96 overflow-y-auto rounded-lg bg-white shadow-lg">
          <div id="search-results-content-mobile" class="p-2">
            <!-- Results will be inserted here -->
          </div>
          <div id="search-loading-mobile" class="hidden p-4 text-center text-gray-500">
            <i class="fas fa-spinner fa-spin"></i> {{ translate('searching') }}...
          </div>
          <div id="search-empty-mobile" class="hidden p-4 text-center text-gray-500">
            {{ translate('no_products_found') }}
          </div>
        </div>
      </div>
    </div>
  </div>
</header>

@push('script')
<script>
(function() {
    'use strict';
    
    // Debounce function
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }
    
    // Search function
    function performSearch(query, type) {
        if (query.length < 2) {
            hideResults(type);
            return;
        }
        
        const resultsContainer = document.getElementById(`search-results-${type}`);
        const resultsContent = document.getElementById(`search-results-content-${type}`);
        const loadingDiv = document.getElementById(`search-loading-${type}`);
        const emptyDiv = document.getElementById(`search-empty-${type}`);
        
        // Show loading
        resultsContainer.classList.remove('hidden');
        resultsContent.classList.add('hidden');
        loadingDiv.classList.remove('hidden');
        emptyDiv.classList.add('hidden');
        
        // Make AJAX request
        fetch(`{{ route('ajax-search-products') }}?q=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(data => {
                loadingDiv.classList.add('hidden');
                
                if (data.products && data.products.length > 0) {
                    resultsContent.innerHTML = '';
                    data.products.forEach(product => {
                        const productItem = document.createElement('a');
                        productItem.href = product.url;
                        productItem.className = 'flex items-center gap-3 p-3 hover:bg-gray-100 rounded-lg transition-colors';
                        productItem.innerHTML = `
                            <img src="${product.image}" alt="${product.name}" class="w-16 h-16 object-cover rounded">
                                <div class="flex-1 min-w-0">
                                <h4 class="text-sm font-semibold text-gray-900 truncate">${product.name}</h4>
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="text-sm font-bold text-primary-light-dynamic">${product.price}</span>
                                    ${product.original_price ? `<span class="text-xs text-gray-500 line-through">${product.original_price}</span>` : ''}
                                </div>
                            </div>
                        `;
                        resultsContent.appendChild(productItem);
                    });
                    
                    // Show "View all results" link if there are more products
                    if (data.total > data.products.length) {
                        const viewAllLink = document.createElement('a');
                        viewAllLink.href = `{{ route('products') }}?name=${encodeURIComponent(query)}`;
                        viewAllLink.className = 'block p-3 text-center text-sm font-semibold text-primary-light-dynamic hover:bg-gray-100 border-t';
                        viewAllLink.textContent = `{{ translate('view_all_results') }} (${data.total})`;
                        resultsContent.appendChild(viewAllLink);
                    }
                    
                    resultsContent.classList.remove('hidden');
                    emptyDiv.classList.add('hidden');
                } else {
                    resultsContent.classList.add('hidden');
                    emptyDiv.classList.remove('hidden');
                }
            })
            .catch(error => {
                console.error('Search error:', error);
                loadingDiv.classList.add('hidden');
                emptyDiv.classList.remove('hidden');
            });
    }
    
    function hideResults(type) {
        const resultsContainer = document.getElementById(`search-results-${type}`);
        resultsContainer.classList.add('hidden');
    }
    
    // Debounced search functions
    const debouncedSearchDesktop = debounce((query) => performSearch(query, 'desktop'), 300);
    const debouncedSearchMobile = debounce((query) => performSearch(query, 'mobile'), 300);
    
    // Desktop search
    const desktopInput = document.getElementById('search-input-desktop');
    if (desktopInput) {
        desktopInput.addEventListener('input', function(e) {
            const query = e.target.value.trim();
            debouncedSearchDesktop(query);
        });
        
        desktopInput.addEventListener('focus', function() {
            if (this.value.trim().length >= 2) {
                performSearch(this.value.trim(), 'desktop');
            }
        });
        
        // Hide results when clicking outside
        document.addEventListener('click', function(e) {
            if (!desktopInput.contains(e.target) && !document.getElementById('search-results-desktop').contains(e.target)) {
                hideResults('desktop');
            }
        });
    }
    
    // Mobile search
    const mobileInput = document.getElementById('search-input-mobile');
    if (mobileInput) {
        mobileInput.addEventListener('input', function(e) {
            const query = e.target.value.trim();
            debouncedSearchMobile(query);
        });
        
        mobileInput.addEventListener('focus', function() {
            if (this.value.trim().length >= 2) {
                performSearch(this.value.trim(), 'mobile');
            }
        });
        
        // Hide results when clicking outside
        document.addEventListener('click', function(e) {
            if (!mobileInput.contains(e.target) && !document.getElementById('search-results-mobile').contains(e.target)) {
                hideResults('mobile');
            }
        });
    }
    
    // Mobile search toggle
    const mobileSearchOpen = document.getElementById('mobile-search-button-open');
    const mobileSearchClose = document.getElementById('mobile-search-button-close');
    const mobileSearchContainer = document.getElementById('mobile-search-container');
    
    if (mobileSearchOpen) {
        mobileSearchOpen.addEventListener('click', function() {
            mobileSearchContainer.classList.remove('hidden');
            setTimeout(() => {
                mobileInput.focus();
            }, 100);
        });
    }
    
    if (mobileSearchClose) {
        mobileSearchClose.addEventListener('click', function() {
            mobileSearchContainer.classList.add('hidden');
            mobileInput.value = '';
            hideResults('mobile');
        });
    }
})();
</script>
@endpush
