{{-- cart items in menu bar --}}
<div>
    <img src="{{asset('frontend/images/cart.png')}}" class="img-fluid blur-up lazyload" alt="">
    <i  class="ti-shopping-cart"></i>
</div>

<span class="cart_qty_cls" id="cart_qty_cls">
    {{ App\Models\Cart::totalQunt() }}                          
</span>
@if( App\Models\Cart::totalItems()->count() != 0 )
    <ul class="show-div shopping-cart" id="shoppingCart">
        @foreach( App\Models\Cart::totalItems()->take(3) as $cart )
            @if( $cart->product->status == 1 )
                <li>
                    <div class="media">
                        @if( !is_null( $cart->product->thumb_image ) )
                            <div>
                                <a href="{{ route('product-details', $cart->product->slug) }}">
                                    <img src="{{asset('uploads/product/thumb_image/' . $cart->product->thumb_image )}}" alt="" class="me-3">
                                </a>
                            </div>
                        @else
                            <div>
                                <a href="{{ route('product-details', $cart->product->slug) }}">
                                    <img src="{{asset('frontend/images/null.jpg')}}" alt="" class="me-3">
                                </a>
                            </div>
                        @endif
                        <div class="media-body">
                            <a href="{{ route('product-details', $cart->product->slug) }}">
                                <h4>
                                    {{ $cart->product->title }}
                                </h4>
                            </a>
                            <h4>
                                <span>
                                    @if( !is_null( $cart->product->offer_price ) )
                                        {{ $cart->product_quantity }} pcs x ৳{{ $cart->product->offer_price }}
                                    @else
                                        {{ $cart->product_quantity }} pcs x ৳{{ $cart->product->regular_price }}
                                    @endif
                                </span>
                            </h4>
                        </div>
                    </div>
                    <div class="close-circle">
                        <form class="delCartForm" id="delCartForm_{{ $loop->index }}">
                            @csrf 
                            @method('DELETE')
                            <input type="hidden" class="cartId" value="{{ $cart->id }}">
                            <button type="button" class="deleteCart" data-form-id="{{ $loop->index }}">
                                <i class="fa fa-times" aria-hidden="true"></i>
                            </button>
                        </form>
                    </div>
                </li>
            @endif
        @endforeach
        <li>
            <div class="total">
                <h5>subtotal : <span>৳{{ App\Models\Cart::totalAmount() }}</span></h5>
            </div>
        </li>
        <li>
            <div class="total totalItem">
                <h5>Total Cart : <span>{{ App\Models\Cart::totalItems()->count() }}</span></h5>
            </div>
        </li>
        <li>
            <div class="buttons">
                <a href="{{ route('cart-manage') }}" class="view-cart">view cart</a> 
                <a href="{{ url('/checkout') }}" class="checkout">checkout</a>
            </div>
        </li>
        
        {{-- loader --}}
        <div class="loader">
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
        </div>
        <input type="hidden" class="amn" value="{{ App\Models\Cart::totalAmount() }}">
    </ul>
@else
    <ul class="show-div shopping-cart">
        <input type="hidden" class="qynt" value="{{ App\Models\Cart::totalItems()->count() }}">
        <p>No Item Added Into Cart!</p>
    </ul>
@endif

