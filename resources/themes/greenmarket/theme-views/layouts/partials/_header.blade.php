<header class="bg-white shadow-md sticky top-0 z-30">
    <div class="container mx-auto px-4">
        <!-- Top Bar -->
        <div class="flex items-center justify-between py-3 border-b border-gray-200">
            <div class="flex items-center space-x-4">
                <a href="{{ route('home') }}" class="flex items-center">
                    <img src="{{ $web_config['web_logo']['path'] }}" alt="{{ $web_config['company_name'] }}" class="h-10">
                </a>
            </div>
            <div class="flex items-center space-x-4">
                @if(auth('customer')->check())
                    <a href="{{ route('account-orders') }}" class="text-gray-700 hover:opacity-75 transition-colors" style="--hover-color: var(--primary-color);">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                    </a>
                    <a href="{{ route('wishlists') }}" class="text-gray-700 hover:opacity-75 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                    </a>
                    <a href="{{ route('user-account') }}" class="text-gray-700 hover:opacity-75 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </a>
                @else
                    <a href="{{ route('customer.auth.login') }}" class="text-gray-700 hover:opacity-75 transition-colors">
                        {{ translate('login') }}
                    </a>
                    <a href="{{ route('customer.auth.sign-up') }}" class="text-white px-4 py-2 rounded-lg hover:opacity-90 transition-colors" style="background-color: var(--primary-color);">
                        {{ translate('sign_up') }}
                    </a>
                @endif
            </div>
        </div>

        <!-- Navigation -->
        <nav class="flex items-center justify-between py-4">
            <div class="flex items-center space-x-6">
                <a href="{{ route('home') }}" class="text-gray-700 hover:opacity-75 transition-colors font-medium">
                    {{ translate('home') }}
                </a>
                <a href="{{ route('products') }}" class="text-gray-700 hover:opacity-75 transition-colors font-medium">
                    {{ translate('products') }}
                </a>
                <a href="{{ route('contacts') }}" class="text-gray-700 hover:opacity-75 transition-colors font-medium">
                    {{ translate('contact_us') }}
                </a>
            </div>
            <div class="flex-1 max-w-lg mx-4">
                <form action="{{ route('products') }}" method="GET" class="relative">
                    <input type="text" name="name" placeholder="{{ translate('search_products') }}" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 rounded-lg" 
                           style="--focus-ring-color: var(--primary-color);">
                    <button type="submit" class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-400 hover:opacity-75">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </button>
                </form>
            </div>
        </nav>
    </div>
</header>

