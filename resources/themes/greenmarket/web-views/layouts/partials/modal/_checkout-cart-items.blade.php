@php
  use App\Utils\CartManager;
  use App\Models\Product;

  $cart = CartManager::getCartListQuery();
  $cartTotal = CartManager::getCartListTotalAppliedDiscount($cart);
@endphp

<!-- Order Summary Section -->
@if ($cart->count() > 0)
  <div class="mb-6" id="checkout-cart-items">
    @foreach ($cart as $cartItem)
      @php
        $product = Product::find($cartItem['product_id'] ?? ($cartItem->product_id ?? null));
        if ($product) {
            $productImage = getStorageImages(
                path: $product->thumbnail_full_url ?? ($product->thumbnail ?? ''),
                type: 'product',
            );
            if (empty($productImage) || $productImage == asset('')) {
                $productImage = asset('themes/greenmarket/assets/images/placeholder.png');
            }
        } else {
            $productImage = asset('themes/greenmarket/assets/images/placeholder.png');
        }
        $productName = $product ? $product->name : 'Product';
        $price = $cartItem['price'] ?? ($cartItem->price ?? 0);
        $discount = $cartItem['discount'] ?? ($cartItem->discount ?? 0);
        $quantity = $cartItem['quantity'] ?? ($cartItem->quantity ?? 1);
        $subtotal = ($price - $discount) * $quantity;
        $cartId = $cartItem['id'] ?? ($cartItem->id ?? '');
      @endphp
      <div class="checkout-item flex items-center gap-4 border-b border-gray-100 py-4" data-cart-id="{{ $cartId }}">
        <!-- Product Image -->
        <div
             class="flex h-[60px] w-[60px] flex-shrink-0 items-center justify-center rounded-lg border border-gray-200 bg-gray-50 p-2">
          <img src="{{ $productImage }}" alt="{{ $productName }}" class="h-full w-full object-contain">
        </div>

        <!-- Product Details -->
        <div class="min-w-0 flex-1">
          <h3 class="mb-1 text-sm font-medium leading-tight text-black"
              style="font-family: 'Hind Siliguri', 'Noto Sans Bengali', sans-serif;">
            {{ $productName }}
          </h3>
          <p class="text-sm font-bold text-black">
            {{ webCurrencyConverter(amount: $price - $discount) }}</p>
        </div>
      </div>
    @endforeach
  </div>

  <!-- Price Summary -->
  <div class="mb-6 rounded-lg bg-gray-50 p-4">
    <div class="flex items-center justify-between py-2">
      <span class="text-sm font-medium text-gray-600"
            style="font-family: 'Hind Siliguri', 'Noto Sans Bengali', sans-serif;">মোট</span>
      <span class="text-sm font-semibold text-black"
            id="checkout-subtotal">{{ webCurrencyConverter(amount: $cartTotal) }}</span>
    </div>
    <div class="flex items-center justify-between py-2">
      <span class="text-sm font-medium text-gray-600"
            style="font-family: 'Hind Siliguri', 'Noto Sans Bengali', sans-serif;">ডেলিভারি
        চার্জ</span>
      <span class="text-sm font-medium text-green-600" id="checkout-delivery-charge">Select
        Delivery Area</span>
    </div>
    <div class="mt-2 flex items-center justify-between border-t-2 border-gray-200 py-3">
      <span class="text-base font-bold text-black"
            style="font-family: 'Hind Siliguri', 'Noto Sans Bengali', sans-serif;">সর্বমোট</span>
      <span class="text-xl font-extrabold text-black"
            id="checkout-grand-total">{{ webCurrencyConverter(amount: $cartTotal) }}</span>
    </div>
  </div>
@else
  <!-- Empty Cart -->
  <div class="mb-6 flex flex-col items-center justify-center rounded-lg bg-white px-4 py-16 shadow-md">
    <div class="mb-4 flex h-24 w-24 items-center justify-center rounded-full bg-gray-100">
      <i class="fas fa-shopping-cart text-4xl text-gray-400"></i>
    </div>
    <h3 class="mb-2 text-lg font-semibold text-gray-700">
      {{ translate('your_cart_is_empty') ?? 'Your cart is empty' }}
    </h3>
    <p class="mb-6 text-center text-sm text-gray-500">
      {{ translate('add_items_to_cart') ?? 'Add items to your cart to continue shopping' }}
    </p>
    <a href="{{ route('home') }}"
       class="bg-primary-dynamic rounded-md px-6 py-2 font-semibold text-white transition-colors hover:bg-[#2d8659]">
      {{ translate('continue_shopping') ?? 'Continue Shopping' }}
    </a>
  </div>
@endif
