@php
  use Illuminate\Support\Str;

  // Get footer settings
  $companyName = $web_config['company_name'] ?? (getWebConfig('company_name') ?? '');
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
<footer class="footer-bg pb-8 pt-12 text-white">
  <div class="container-ds">
    <div class="mb-12 grid grid-cols-1 gap-12 border-b border-white/10 pb-12 md:grid-cols-3">
      <!-- Brand Column -->
      <div class="space-y-4">
        <div class="flex-shrink-0">
          <a href="{{ route('home') }}" class="flex items-center">
            <img src="{{ $web_config['web_logo']['path'] ?? '' }}" alt="{{ $web_config['company_name'] ?? 'Logo' }}"
                 class="h-8 w-auto object-contain sm:h-10 md:h-12 lg:h-14"
                 onerror="this.src='{{ $web_config['web_logo']['path'] ?? '' }}'">
          </a>
        </div>
        @if ($aboutText)
          <p class="text-sm leading-relaxed text-white/70">
            {{ Str::limit(strip_tags($aboutText), 150) }}
          </p>
        @endif
        <div class="space-y-2 text-sm text-white/70">
          @if ($shopAddress)
            <p><i class="fas fa-map-marker-alt mr-2 text-[#a8d4c0]"></i> {{ $shopAddress }}</p>
          @endif
          @if ($companyPhone)
            <p><i class="fas fa-phone mr-2 text-[#a8d4c0]"></i> {{ $companyPhone }}</p>
          @endif
          @if ($companyEmail)
            <p><i class="fas fa-envelope mr-2 text-[#a8d4c0]"></i> <a href="mailto:{{ $companyEmail }}"
                 class="transition-colors hover:text-[#a8d4c0]">{{ $companyEmail }}</a></p>
          @endif
        </div>
      </div>

      <!-- Quick Links Column -->
      <div>
        <h4 class="mb-6 text-lg font-bold">{{ translate('quick_links') ?? 'Quick Links' }}</h4>
        @if ($defaultPages->count() > 0)
          <ul class="space-y-3 text-sm text-white/70">
            @foreach ($defaultPages->take(7) as $page)
              <li>
                <a href="{{ route('business-page.view', ['slug' => $page->slug]) }}"
                   class="transition-colors hover:text-[#a8d4c0]">
                  {{ $page->title }}
                </a>
              </li>
            @endforeach
            @php
              $hasContactRoute = Route::has('contacts');
            @endphp
            @if ($hasContactRoute)
              <li>
                <a href="{{ route('contacts') }}" class="transition-colors hover:text-[#a8d4c0]">
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
            @if ($hasAboutRoute)
              <li><a href="{{ route('business-page.view', ['slug' => 'about-us']) }}"
                   class="transition-colors hover:text-[#a8d4c0]">{{ translate('about_us') ?? 'About Us' }}</a></li>
            @endif
            @if ($hasContactRoute)
              <li><a href="{{ route('contacts') }}"
                   class="transition-colors hover:text-[#a8d4c0]">{{ translate('contact_us') ?? 'Contact Us' }}</a>
              </li>
            @endif
            @if ($hasAboutRoute)
              <li><a href="{{ route('business-page.view', ['slug' => 'privacy-policy']) }}"
                   class="transition-colors hover:text-[#a8d4c0]">{{ translate('privacy_policy') ?? 'Privacy Policy' }}</a>
              </li>
              <li><a href="{{ route('business-page.view', ['slug' => 'terms-and-conditions']) }}"
                   class="transition-colors hover:text-[#a8d4c0]">{{ translate('terms_and_conditions') ?? 'Terms & Conditions' }}</a>
              </li>
              <li><a href="{{ route('business-page.view', ['slug' => 'refund-policy']) }}"
                   class="transition-colors hover:text-[#a8d4c0]">{{ translate('refund_policy') ?? 'Refund Policy' }}</a>
              </li>
              <li><a href="{{ route('business-page.view', ['slug' => 'shipping-policy']) }}"
                   class="transition-colors hover:text-[#a8d4c0]">{{ translate('shipping_policy') ?? 'Shipping Policy' }}</a>
              </li>
            @endif
          </ul>
        @endif
      </div>

      <!-- Follow Us Column -->
      <div>
        <h4 class="mb-6 text-lg font-bold">{{ translate('follow_us') ?? 'Follow Us' }}</h4>
        @if ($socialMediaLinks->count() > 0)
          <div class="mb-6 flex flex-wrap gap-4">
            @foreach ($socialMediaLinks as $social)
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
    if (
        strpos($iconClass, 'fab ') === false &&
        strpos($iconClass, 'fas ') === false &&
        strpos($iconClass, 'far ') === false
    ) {
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
              <a href="{{ $social->link }}" target="_blank" rel="noopener noreferrer"
                 class="flex h-12 w-12 items-center justify-center rounded-full bg-white/10 transition-colors hover:bg-[#a8d4c0]"
                 title="{{ ucfirst($social->name) }}">
                <i class="{{ $iconClass }} text-xl"></i>
              </a>
            @endforeach
          </div>
        @else
          {{-- Fallback social links if none configured --}}
          <div class="mb-6 flex gap-4">
            <a href="#"
               class="flex h-12 w-12 items-center justify-center rounded-full bg-white/10 transition-colors hover:bg-[#a8d4c0]">
              <i class="fab fa-facebook-f text-xl"></i>
            </a>
            <a href="#"
               class="flex h-12 w-12 items-center justify-center rounded-full bg-white/10 transition-colors hover:bg-[#a8d4c0]">
              <i class="fab fa-whatsapp text-xl"></i>
            </a>
            <a href="#"
               class="flex h-12 w-12 items-center justify-center rounded-full bg-white/10 transition-colors hover:bg-[#a8d4c0]">
              <i class="fab fa-instagram text-xl"></i>
            </a>
          </div>
        @endif
      </div>
    </div>

    <div class="text-center text-sm text-white/50">
      <p>&copy; {{ date('Y') }} {{ $companyName }}.
        {{ translate('all_rights_reserved') ?? 'All Rights Reserved' }}.</p>
    </div>
  </div>
</footer>
