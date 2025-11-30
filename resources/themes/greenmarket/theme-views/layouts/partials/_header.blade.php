<!-- Header -->
<header>
    <!-- Top Bar - Hidden on tablet and mobile -->
    <div class="bg-primary-dark text-white py-2 hidden lg:block">
        <div class="max-w-[1512px] mx-auto px-4 flex justify-between items-center text-sm py-1">
            <div class="flex items-center gap-2 ml-8">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                </svg>
                <span>{{ getWebConfig('phone') ?? '09639812525' }}</span>
            </div>
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
                <span class="font-medium text-[#d8f7e5]">{{ getWebConfig('announcement')['text'] ?? translate('discover_the_power_of_nature') }}</span>
            </div>
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="font-medium text-[#d8f7e5] md:pr-3">Customer Help</span>
            </div>
        </div>
    </div>

    <!-- Main Header -->
    <div class="bg-primary-green">
        <div class="max-w-[1512px] mx-auto px-4 md:px-6 lg:px-2 py-3 flex justify-between items-center gap-4">
            <!-- Logo -->
            <div class="flex-shrink-0">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('themes/greenmarket/assets/images/Naturo-Logo.png') }}" 
                         alt="{{ $web_config['company_name'] ?? 'Logo' }}" 
                         class="h-8 md:h-10 lg:h-auto"
                         onerror="this.src='{{ $web_config['web_logo']['path'] ?? '' }}'">
                </a>
            </div>

            <!-- Search Bar - Hidden on mobile, adjusted on tablet -->
            <div class="hidden md:flex flex-1 max-w-5xl lg:mx-8 md:mx-4">
                <form action="{{ route('products') }}" method="GET" class="relative w-full">
                    <input type="text" name="name" placeholder="{{ translate('search_in') }} {{ $web_config['company_name'] ?? 'Store' }}..."
                        class="w-full bg-primary-dark text-white font-semibold text-sm placeholder-primary-semi-dark px-10 py-2 md:py-3 lg:py-3 pr-12 focus:outline-none">
                    <button type="submit" class="absolute left-3 top-1/2 -translate-y-1/2">
                        <svg class="w-5 h-5 text-primary-semi-dark" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>
                </form>
            </div>

            <!-- Cart -->
            <div class="flex items-center gap-7 md:gap-6 md:pr-10 flex-shrink-0">
                <a href="{{ route('shop-cart') }}" class="relative text-white flex items-center gap-1 md:gap-2">
                    <i class="fas fa-shopping-cart text-lg md:text-xl"></i>
                    @php
                        $cartCount = auth('customer')->check() ? \App\Models\Cart::where('customer_id', auth('customer')->id())->count() : 0;
                    @endphp
                    @if($cartCount > 0)
                        <span class="absolute -top-2 md:-top-3 left-3 md:left-4 bg-[#DC3545] text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center">{{ $cartCount }}</span>
                    @endif
                    <span class="hidden md:inline text-sm">{{ translate('cart') }}</span>
                </a>
                <!-- Mobile Search Icon - Visible only on mobile -->
                <button class="md:hidden text-white text-xl" id="mobile-search-button-open">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </div>
</header>
