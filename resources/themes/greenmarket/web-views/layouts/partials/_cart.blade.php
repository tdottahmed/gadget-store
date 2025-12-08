@php
    use App\Utils\CartManager;
    use App\Models\Product;
    
    // This view is returned by cart.nav-cart route for AJAX updates
    // It should return the cart sidebar HTML
    $cart = CartManager::getCartListQuery();
    $cartTotal = CartManager::getCartListTotalAppliedDiscount($cart);
@endphp

@include('web-views.layouts.partials._cart-sidebar')

