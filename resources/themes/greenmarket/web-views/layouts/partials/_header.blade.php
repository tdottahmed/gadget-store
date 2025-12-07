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
        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
        </svg>
        <span
              class="font-medium text-[#d8f7e5]">{{ getWebConfig('announcement')['text'] ?? translate('') }}</span>
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
        <form action="{{ route('products') }}" method="GET" class="relative w-full">
          <input type="text" name="name"
                 placeholder="{{ translate('search_in') }} {{ $web_config['company_name'] ?? 'Store' }}..."
                 class="w-full top-bar-bg px-10 py-2 pr-12 text-sm font-semibold text-white placeholder-[#a8d4c0] focus:outline-none md:py-3 lg:py-3">
          <button type="submit" class="absolute left-3 top-1/2 -translate-y-1/2">
            <svg class="h-5 w-5 text-[#a8d4c0]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
          </button>
        </form>
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
  </div>
</header>
