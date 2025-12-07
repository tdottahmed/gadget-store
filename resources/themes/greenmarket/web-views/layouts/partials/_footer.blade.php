@php
    use Illuminate\Support\Str;
    
    // Get footer settings
    $companyName = $web_config['company_name'] ?? getWebConfig('company_name') ?? '';
    $aboutText = getWebConfig('about_us') ?? '';
    $shopAddress = getWebConfig('shop_address') ?? '';
    $companyPhone = getWebConfig('company_phone') ?? '';
    $companyEmail = getWebConfig('company_email') ?? '';
    
    // Get business pages for quick links (default pages)
    $businessPages = $web_config['business_pages'] ?? collect();
    $defaultPages = $businessPages->where('default_status', 1)->where('status', 1);
    
    // Get social media links
    $socialMediaLinks = $web_config['social_media'] ?? collect();
    
    // Get contact route if available
    $contactRoute = route('contacts') ?? '#';
@endphp

<!-- Footer -->
<footer class="footer-bg text-white pt-12 pb-8">
    <div class="container-ds">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12 mb-12 border-b border-white/10 pb-12">
            <!-- Brand Column -->
            <div class="space-y-4">
                <div class="flex items-center gap-3 mb-4">
                    <div class="text-3xl font-bold tracking-wider">{{ $companyName }}</div>
                    <i class="fas fa-leaf text-[#a8d4c0] text-2xl"></i>
                </div>
                @if($aboutText)
                    <p class="text-white/70 text-sm leading-relaxed">
                        {{ Str::limit(strip_tags($aboutText), 150) }}
                    </p>
                @endif
                <div class="space-y-2 text-sm text-white/70">
                    @if($shopAddress)
                        <p><i class="fas fa-map-marker-alt mr-2 text-[#a8d4c0]"></i> {{ $shopAddress }}</p>
                    @endif
                    @if($companyPhone)
                        <p><i class="fas fa-phone mr-2 text-[#a8d4c0]"></i> {{ $companyPhone }}</p>
                    @endif
                    @if($companyEmail)
                        <p><i class="fas fa-envelope mr-2 text-[#a8d4c0]"></i> <a href="mailto:{{ $companyEmail }}" class="hover:text-[#a8d4c0] transition-colors">{{ $companyEmail }}</a></p>
                    @endif
                </div>
            </div>

            <!-- Quick Links Column -->
            <div>
                <h4 class="font-bold text-lg mb-6">{{ translate('quick_links') ?? 'Quick Links' }}</h4>
                @if($defaultPages->count() > 0)
                    <ul class="space-y-3 text-sm text-white/70">
                        @foreach($defaultPages->take(7) as $page)
                            <li>
                                <a href="{{ route('business-page.view', ['slug' => $page->slug]) }}" 
                                   class="hover:text-[#a8d4c0] transition-colors">
                                    {{ $page->title }}
                                </a>
                            </li>
                        @endforeach
                        @php
                            $hasContactRoute = Route::has('contacts');
                        @endphp
                        @if($hasContactRoute)
                            <li>
                                <a href="{{ route('contacts') }}" class="hover:text-[#a8d4c0] transition-colors">
                                    {{ translate('contact_us') ?? 'Contact Us' }}
                                </a>
                            </li>
                        @endif
                    </ul>
                @else
                    {{-- Fallback links if no business pages configured --}}
                    <ul class="space-y-3 text-sm text-white/70">
                        @php
                            $hasAboutRoute = Route::has('business-page.view');
                            $hasContactRoute = Route::has('contacts');
                        @endphp
                        @if($hasAboutRoute)
                            <li><a href="{{ route('business-page.view', ['slug' => 'about-us']) }}" class="hover:text-[#a8d4c0] transition-colors">{{ translate('about_us') ?? 'About Us' }}</a></li>
                        @endif
                        @if($hasContactRoute)
                            <li><a href="{{ route('contacts') }}" class="hover:text-[#a8d4c0] transition-colors">{{ translate('contact_us') ?? 'Contact Us' }}</a></li>
                        @endif
                        @if($hasAboutRoute)
                            <li><a href="{{ route('business-page.view', ['slug' => 'privacy-policy']) }}" class="hover:text-[#a8d4c0] transition-colors">{{ translate('privacy_policy') ?? 'Privacy Policy' }}</a></li>
                            <li><a href="{{ route('business-page.view', ['slug' => 'terms-and-conditions']) }}" class="hover:text-[#a8d4c0] transition-colors">{{ translate('terms_and_conditions') ?? 'Terms & Conditions' }}</a></li>
                            <li><a href="{{ route('business-page.view', ['slug' => 'refund-policy']) }}" class="hover:text-[#a8d4c0] transition-colors">{{ translate('refund_policy') ?? 'Refund Policy' }}</a></li>
                            <li><a href="{{ route('business-page.view', ['slug' => 'shipping-policy']) }}" class="hover:text-[#a8d4c0] transition-colors">{{ translate('shipping_policy') ?? 'Shipping Policy' }}</a></li>
                        @endif
                    </ul>
                @endif
            </div>

            <!-- Follow Us Column -->
            <div>
                <h4 class="font-bold text-lg mb-6">{{ translate('follow_us') ?? 'Follow Us' }}</h4>
                @if($socialMediaLinks->count() > 0)
                    <div class="flex gap-4 mb-6 flex-wrap">
                        @foreach($socialMediaLinks as $social)
                            @php
                                // Get icon - convert old format to new format if needed
                                $iconClass = '';
                                $socialName = strtolower($social->name ?? '');
                                
                                if (!empty($social->icon)) {
                                    // If icon exists, use it but convert old format to new
                                    $iconClass = $social->icon;
                                    // Convert old FontAwesome 4/5 format to FontAwesome 6
                                    $iconClass = str_replace('fa fa-facebook', 'fab fa-facebook-f', $iconClass);
                                    $iconClass = str_replace('fa fa-twitter', 'fab fa-twitter', $iconClass);
                                    $iconClass = str_replace('fa fa-instagram', 'fab fa-instagram', $iconClass);
                                    $iconClass = str_replace('fa fa-linkedin', 'fab fa-linkedin-in', $iconClass);
                                    $iconClass = str_replace('fa fa-pinterest', 'fab fa-pinterest', $iconClass);
                                    $iconClass = str_replace('fa fa-youtube', 'fab fa-youtube', $iconClass);
                                    $iconClass = str_replace('fa fa-google-plus', 'fab fa-google-plus-g', $iconClass);
                                    // Ensure it has fab/fas prefix if it's just 'fa'
                                    if (strpos($iconClass, 'fab ') === false && strpos($iconClass, 'fas ') === false && strpos($iconClass, 'far ') === false) {
                                        $iconClass = str_replace('fa ', 'fab ', $iconClass);
                                    }
                                } else {
                                    // Fallback icons based on name
                                    if (str_contains($socialName, 'facebook')) {
                                        $iconClass = 'fab fa-facebook-f';
                                    } elseif (str_contains($socialName, 'whatsapp')) {
                                        $iconClass = 'fab fa-whatsapp';
                                    } elseif (str_contains($socialName, 'instagram')) {
                                        $iconClass = 'fab fa-instagram';
                                    } elseif (str_contains($socialName, 'twitter')) {
                                        $iconClass = 'fab fa-twitter';
                                    } elseif (str_contains($socialName, 'youtube')) {
                                        $iconClass = 'fab fa-youtube';
                                    } elseif (str_contains($socialName, 'linkedin')) {
                                        $iconClass = 'fab fa-linkedin-in';
                                    } elseif (str_contains($socialName, 'pinterest')) {
                                        $iconClass = 'fab fa-pinterest';
                                    } else {
                                        $iconClass = 'fas fa-link';
                                    }
                                }
                            @endphp
                            <a href="{{ $social->link }}" 
                               target="_blank" 
                               rel="noopener noreferrer"
                               class="w-12 h-12 rounded-full bg-white/10 flex items-center justify-center hover:bg-[#a8d4c0] transition-colors"
                               title="{{ ucfirst($social->name) }}">
                                <i class="{{ $iconClass }} text-xl"></i>
                            </a>
                        @endforeach
                    </div>
                @else
                    {{-- Fallback social links if none configured --}}
                    <div class="flex gap-4 mb-6">
                        <a href="#" class="w-12 h-12 rounded-full bg-white/10 flex items-center justify-center hover:bg-[#a8d4c0] transition-colors">
                            <i class="fab fa-facebook-f text-xl"></i>
                        </a>
                        <a href="#" class="w-12 h-12 rounded-full bg-white/10 flex items-center justify-center hover:bg-[#a8d4c0] transition-colors">
                            <i class="fab fa-whatsapp text-xl"></i>
                        </a>
                        <a href="#" class="w-12 h-12 rounded-full bg-white/10 flex items-center justify-center hover:bg-[#a8d4c0] transition-colors">
                            <i class="fab fa-instagram text-xl"></i>
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <div class="text-center text-sm text-white/50">
            <p>&copy; {{ date('Y') }} {{ $companyName }}. {{ translate('all_rights_reserved') ?? 'All Rights Reserved' }}.</p>
        </div>
    </div>
</footer>
