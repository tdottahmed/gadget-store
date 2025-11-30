<!-- Footer -->
<footer class="bg-[#0d3d26] text-white pt-12 pb-8">
    <div class="container-ds">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12 mb-12 border-b border-white/10 pb-12">
            <!-- Brand Column -->
            <div class="space-y-4">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="text-3xl font-bold tracking-wider">{{ $web_config['company_name'] ?? 'NATURO BD' }}</div>
                        <i class="fas fa-leaf text-[#a8d4c0] text-2xl"></i>
                    </div>
                    <p class="text-white/70 text-sm leading-relaxed">
                        {{ getWebConfig('about') ?? translate('providing_high_quality_organic_and_natural_products') }}
                    </p>
                    <div class="space-y-2 text-sm text-white/70">
                    <p><i class="fas fa-map-marker-alt mr-2 text-[#a8d4c0]"></i> {{ getWebConfig('address') ?? '123 Nature Street, Dhaka, Bangladesh' }}</p>
                    <p><i class="fas fa-phone mr-2 text-[#a8d4c0]"></i> {{ getWebConfig('phone') ?? '+880 1711-111111' }}</p>
                    <p><i class="fas fa-envelope mr-2 text-[#a8d4c0]"></i> {{ getWebConfig('email') ?? 'info@natrobd.com' }}</p>
                    </div>
            </div>

            <!-- Quick Links Column -->
            <div>
                <h4 class="font-bold text-lg mb-6">Quick Links</h4>
                <ul class="space-y-3 text-sm text-white/70">
                    <li><a href="#" class="hover:text-[#a8d4c0] transition-colors">About Us</a></li>
                    <li><a href="#" class="hover:text-[#a8d4c0] transition-colors">Contact Us</a></li>
                    <li><a href="#" class="hover:text-[#a8d4c0] transition-colors">Privacy Policy</a>
                    </li>
                    <li><a href="#" class="hover:text-[#a8d4c0] transition-colors">Terms &
                            Conditions</a>
                    </li>
                    <li><a href="#" class="hover:text-[#a8d4c0] transition-colors">Refund Policy</a>
                    </li>
                    <li><a href="#" class="hover:text-[#a8d4c0] transition-colors">Shipping Policy</a>
                    </li>
                    <li><a href="#" class="hover:text-[#a8d4c0] transition-colors">Blog</a></li>
                </ul>
            </div>

            <!-- Follow Us Column -->
            <div>
                <h4 class="font-bold text-lg mb-6">Follow Us</h4>
                <div class="flex gap-4 mb-6">
                        <a href="#"
                            class="w-12 h-12 rounded-full bg-white/10 flex items-center justify-center hover:bg-[#a8d4c0] transition-colors">
                            <i class="fab fa-facebook-f text-xl"></i>
                        </a>
                        <a href="#"
                            class="w-12 h-12 rounded-full bg-white/10 flex items-center justify-center hover:bg-[#a8d4c0] transition-colors">
                            <i class="fab fa-whatsapp text-xl"></i>
                        </a>
                        <a href="#"
                            class="w-12 h-12 rounded-full bg-white/10 flex items-center justify-center hover:bg-[#a8d4c0] transition-colors">
                            <i class="fab fa-instagram text-xl"></i>
                        </a>
                </div>
            </div>
        </div>

            <div class="text-center text-sm text-white/50">
                <p>&copy; {{ date('Y') }} {{ $web_config['company_name'] ?? 'NATURO BD' }}. {{ translate('all_rights_reserved') }}.</p>
            </div>
    </div>
</footer>
