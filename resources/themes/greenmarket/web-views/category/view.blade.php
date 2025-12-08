@extends('web-views.layouts.app')

@section('title', ($category->name ?? translate('category')) . ' - ' . ($web_config['company_name'] ?? ''))

@push('css_or_js')
    <meta property="og:image" content="{{ $web_config['web_logo']['path'] ?? '' }}" />
    <meta property="og:title" content="{{ $category->name ?? translate('category') }} - {{ $web_config['company_name'] ?? '' }}" />
    <meta property="og:url" content="{{ env('APP_URL') }}/category/{{ $category->id ?? '' }}">
    <meta property="og:description" content="{{ $category->description ?? $web_config['meta_description'] ?? '' }}">
    <meta name="description" content="{{ $category->description ?? $web_config['meta_description'] ?? '' }}">

    <style>
        /* Container */
        .container-ds {
            max-width: 1240px;
            margin-left: auto;
            margin-right: auto;
            padding-left: 2rem;
            padding-right: 2rem;
        }

        /* Breadcrumb Styles */
        .breadcrumb {
            margin: 0;
            padding: 0;
            list-style: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
        }

        .breadcrumb-item {
            display: flex;
            align-items: center;
        }

        .breadcrumb-item a {
            color: var(--primary-color);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .breadcrumb-item a:hover {
            color: var(--primary-color-light);
            text-decoration: underline;
        }

        .breadcrumb-item.text-gray-400 {
            color: #9ca3af;
        }

        .breadcrumb-item.text-gray-900 {
            color: #111827;
        }

        /* Category Title */
        .category-title {
            color: var(--primary-color);
        }

        /* Products Grid */
        .products-grid {
            display: grid;
            grid-template-columns: repeat(1, minmax(0, 1fr));
            gap: 1.5rem;
        }

        @media (min-width: 640px) {
            .products-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (min-width: 768px) {
            .products-grid {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
        }

        @media (min-width: 1024px) {
            .products-grid {
                grid-template-columns: repeat(4, minmax(0, 1fr));
            }
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 4rem 0;
        }

        .empty-state-icon {
            font-size: 4rem;
            color: #d1d5db;
            margin-bottom: 1rem;
        }

        .empty-state-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.5rem;
        }

        .empty-state-text {
            color: #6b7280;
            margin-bottom: 1.5rem;
        }

        .empty-state-button {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            background-color: var(--primary-color);
            color: white;
            border-radius: 0.5rem;
            font-weight: 600;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .empty-state-button:hover {
            background-color: var(--primary-color-hover);
        }

        /* Pagination Styles */
        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0.5rem;
            margin-top: 2rem;
        }

        .pagination a,
        .pagination span {
            padding: 0.5rem 1rem;
            border: 1px solid #e5e7eb;
            border-radius: 0.375rem;
            color: #374151;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .pagination a:hover {
            background-color: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }

        .pagination .active span {
            background-color: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .container-ds {
                padding-left: 1rem;
                padding-right: 1rem;
            }
        }
    </style>
@endpush

@section('content')
    <!-- Breadcrumb -->
    <div class="bg-gray-50 py-4">
        <div class="container-ds">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}">
                            {{ translate('home') ?? 'Home' }}
                        </a>
                    </li>
                    <li class="breadcrumb-item text-gray-400">/</li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('products') }}">
                            {{ translate('products') ?? 'Products' }}
                        </a>
                    </li>
                    <li class="breadcrumb-item text-gray-400">/</li>
                    <li class="breadcrumb-item text-gray-900 font-semibold" aria-current="page">
                        {{ $category->name ?? translate('category') }}
                    </li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Category Content Area -->
    <div class="container-ds py-8">
        <!-- Category Title -->
        <div class="mb-8">
            <h1 class="text-3xl md:text-4xl font-bold category-title mb-2">
                {{ $category->name ?? translate('category') }}
            </h1>
            @if($category->description)
                <p class="text-gray-600 text-base md:text-lg mt-2">
                    {{ $category->description }}
                </p>
            @endif
        </div>

        <!-- Products Grid -->
        @if(isset($products) && $products->count() > 0)
            <div class="products-grid mb-8">
                @foreach($products as $product)
                    @include('web-views.partials.product-card', ['product' => $product])
                @endforeach
            </div>

            <!-- Pagination -->
            @if(method_exists($products, 'links'))
                <div class="pagination">
                    {{ $products->links() }}
                </div>
            @endif
        @else
            <!-- No Products Found -->
            <div class="empty-state">
                <div class="mb-4">
                    <i class="fas fa-box-open empty-state-icon"></i>
                </div>
                <h3 class="empty-state-title">
                    {{ translate('no_products_found') ?? 'No Products Found' }}
                </h3>
                <p class="empty-state-text">
                    {{ translate('no_products_in_this_category') ?? 'There are no products available in this category at the moment.' }}
                </p>
                <a href="{{ route('home') }}" class="empty-state-button">
                    {{ translate('view_all_products') ?? 'View All Products' }}
                </a>
            </div>
        @endif
    </div>
@endsection

