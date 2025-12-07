@php
    use Illuminate\Support\Str;
    
    // Get categories - use $categories from controller or fallback to main_categories from web_config
    $categories = $categories ?? ($web_config['main_categories'] ?? collect());
    
    // Filter only parent categories (position = 0) - Category model doesn't have 'status' field
    // Filter by position = 0 (parent categories) and optionally by home_status if needed
    $parentCategories = $categories->filter(function($category) {
        return ($category->position ?? 0) == 0 && ($category->parent_id ?? 0) == 0;
    })->take(12);
    
    // Default icon mapping for categories
    $defaultIcons = [
        'honey' => 'fas fa-leaf',
        'মধু' => 'fas fa-leaf',
        'wellness' => 'fas fa-spa',
        'স্বাস্থ্য' => 'fas fa-spa',
        'organic' => 'fas fa-leaf',
        'cosmetics' => 'fas fa-palette',
        'gift' => 'fas fa-gift',
        'herb' => 'fas fa-leaf',
        'food' => 'fas fa-apple-alt',
        'health' => 'fas fa-heart',
    ];
    
    // Function to get icon for category
    $getCategoryIcon = function($categoryName) use ($defaultIcons) {
        $nameLower = strtolower($categoryName);
        foreach ($defaultIcons as $key => $icon) {
            if (str_contains($nameLower, strtolower($key))) {
                return $icon;
            }
        }
        return 'fas fa-th-large'; // Default icon
    };
@endphp

<!-- Category Bar -->
<section class="bg-primary-light py-3">
    <div class="container-ds">
        <div class="category-slider">
            @if($parentCategories->count() > 0)
                @foreach($parentCategories as $category)
                    @php
                        // icon_full_url returns an array with 'path' key from storageLink()
                        $categoryIconArray = $category->icon_full_url ?? null;
                        $categoryIconPath = null;
                        if ($categoryIconArray && is_array($categoryIconArray) && isset($categoryIconArray['path'])) {
                            $categoryIconPath = $categoryIconArray['path'];
                        } elseif ($category->icon) {
                            // Fallback: use getStorageImages helper with icon field
                            $iconResult = getStorageImages(path: $category->icon, type: 'category');
                            if (is_array($iconResult) && isset($iconResult['path'])) {
                                $categoryIconPath = $iconResult['path'];
                            } elseif (is_string($iconResult)) {
                                $categoryIconPath = $iconResult;
                            }
                        }
                        
                        $categoryName = $category->name ?? '';
                        $categorySlug = $category->slug ?? '';
                        $categoryId = $category->id ?? '';
                        $iconClass = $getCategoryIcon($categoryName);
                    @endphp
                    <div>
                        <a href="{{ route('products', ['data_from' => 'category', 'id' => $categoryId, 'page' => 1]) }}"
                            class="flex flex-col items-center gap-2 text-[#052E16] hover:text-[#389e63] hover:scale-110 transition-transform group">
                            <div
                                class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center group-hover:bg-white/30 transition-colors">
                                @if($categoryIconPath)
                                    <img src="{{ $categoryIconPath }}" 
                                         alt="{{ $categoryName }}" 
                                         class="w-8 h-8 object-contain">
                                @else
                                    <i class="{{ $iconClass }} text-xl"></i>
                                @endif
                            </div>
                            <span class="text-sm font-semibold text-center">{{ Str::limit($categoryName, 15) }}</span>
                        </a>
                    </div>
                @endforeach
            @else
                {{-- Fallback static categories if no categories found --}}
                <div>
                    <a href="{{ route('products') }}"
                        class="flex flex-col items-center gap-2 text-[#052E16] hover:text-[#389e63] hover:scale-110 transition-transform group">
                        <div
                            class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center group-hover:bg-white/30 transition-colors">
                            <i class="fas fa-th-large text-xl"></i>
                        </div>
                        <span class="text-lg font-bold">{{ translate('all') ?? 'All' }}</span>
                    </a>
                </div>
            @endif
        </div>
    </div>
</section>

