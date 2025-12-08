@php
    use App\Utils\CartManager;
    use App\Models\Product;
    
    // Get cart data - this view is used for AJAX responses when updating cart quantity
    // The response is rendered as HTML string and returned in JSON
    // For greenmarket theme, we return minimal HTML that can be parsed if needed
    // The cart sidebar handles updates via its own AJAX calls
    $cart = CartManager::getCartListQuery();
    $cartTotal = CartManager::getCartListTotalAppliedDiscount($cart);
@endphp

<!-- Cart Details Response for Greenmarket Theme -->
<!-- This view is returned as HTML string in JSON response -->
<!-- The cart sidebar JavaScript handles updates separately -->
<div class="cart-details-response" style="display: none;">
    <div class="cart-total" data-total="{{ $cartTotal }}">{{ webCurrencyConverter(amount: $cartTotal) }}</div>
    @if($cart && $cart->count() > 0)
        @foreach($cart as $cartItem)
            @php
                $product = Product::find($cartItem->product_id ?? ($cartItem['product_id'] ?? null));
                $price = $cartItem->price ?? ($cartItem['price'] ?? 0);
                $discount = $cartItem->discount ?? ($cartItem['discount'] ?? 0);
                $quantity = $cartItem->quantity ?? ($cartItem['quantity'] ?? 1);
                $subtotal = ($price - $discount) * $quantity;
                $cartId = $cartItem->id ?? ($cartItem['id'] ?? '');
            @endphp
            <div class="cart-item-update" 
                 data-cart-id="{{ $cartId }}"
                 data-quantity="{{ $quantity }}"
                 data-subtotal="{{ webCurrencyConverter(amount: $subtotal) }}"
                 style="display: none;"></div>
        @endforeach
    @endif
</div>

