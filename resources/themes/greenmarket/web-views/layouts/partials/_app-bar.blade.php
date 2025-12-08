@php
  use App\Utils\CartManager;
  $cart_mobile = CartManager::getCartListQuery();
@endphp

<!-- Mobile Bottom Navigation Bar -->
<ul class="flex list-none items-center justify-around gap-2 bg-white px-2 py-2">
  <!-- Home -->
  <li>
    <a href="{{ route('home') }}"
       class="{{ Request::is('/') || Request::is('home') ? 'text-[#2d8659]' : 'text-gray-600' }} flex flex-col items-center py-2 transition-colors">
      <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
      </svg>
      <span class="mt-1 text-xs font-medium">{{ translate('home') ?? 'Home' }}</span>
    </a>
  </li>

  <!-- Wishlist -->
  <li>
    @if (auth('customer')->check())
      <a href="{{ route('wishlists') }}"
         class="{{ Request::is('wishlists') ? 'text-[#2d8659]' : 'text-gray-600' }} flex flex-col items-center py-2 transition-colors">
        <div class="relative">
          <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
          </svg>
          @if (session()->has('wish_list') && count(session('wish_list')) > 0)
            <span
                  class="absolute -right-1 -top-1 flex h-4 w-4 items-center justify-center rounded-full bg-red-500 text-xs font-bold text-white">
              {{ count(session('wish_list')) }}</span>
          @endif
        </div>
        <span class="mt-1 text-xs font-medium">{{ translate('wishlist') ?? 'Wishlist' }}</span>
      </a>
    @else
      <a href="javascript:" class="flex flex-col items-center py-2 text-gray-600 transition-colors" data-toggle="modal"
         data-target="#loginModal">
        <div class="relative">
          <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
          </svg>
        </div>
        <span class="mt-1 text-xs font-medium">{{ translate('wishlist') ?? 'Wishlist' }}</span>
      </a>
    @endif
  </li>

  <!-- Cart -->
  <li>
    <a href="{{ route('shop-cart') }}"
       class="{{ Request::is('shop-cart') ? 'text-[#2d8659]' : 'text-gray-600' }} flex flex-col items-center py-2 transition-colors">
      <div class="relative">
        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
        </svg>
        @if ($cart_mobile->count() > 0)
          <span
                class="absolute -right-1 -top-1 flex h-4 w-4 items-center justify-center rounded-full bg-red-500 text-xs font-bold text-white">
            {{ $cart_mobile->count() }}</span>
        @endif
      </div>
      <span class="mt-1 text-xs font-medium">{{ translate('cart') ?? 'Cart' }}</span>
    </a>
  </li>

  <!-- Compare -->
  <li>
    @if (auth('customer')->check())
      <a href="{{ route('product-compare.index') }}"
         class="{{ Request::is('compare-list') ? 'text-[#2d8659]' : 'text-gray-600' }} flex flex-col items-center py-2 transition-colors">
        <div class="relative">
          <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
          </svg>
          @if (session()->has('compare_list') && count(session('compare_list')) > 0)
            <span
                  class="absolute -right-1 -top-1 flex h-4 w-4 items-center justify-center rounded-full bg-red-500 text-xs font-bold text-white">
              {{ count(session('compare_list')) }}</span>
          @endif
        </div>
        <span class="mt-1 text-xs font-medium">{{ translate('compare') ?? 'Compare' }}</span>
      </a>
    @else
      <a href="javascript:" class="flex flex-col items-center py-2 text-gray-600 transition-colors" data-toggle="modal"
         data-target="#loginModal">
        <div class="relative">
          <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
          </svg>
        </div>
        <span class="mt-1 text-xs font-medium">{{ translate('compare') ?? 'Compare' }}</span>
      </a>
    @endif
  </li>
</ul>
