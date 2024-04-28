@foreach (App\Models\Wishlist::totalPsc() as $wishlist)
    <tr>
        <td>
            @if( !is_null( $wishlist->product->thumb_image ) )
                <div>
                    <a href="{{ route('product-details', $wishlist->product->slug) }}">
                        <img src="{{asset('uploads/product/thumb_image/' . $wishlist->product->thumb_image )}}" alt="">
                    </a>
                </div>
            @else
                <div>
                    <a href="{{ route('product-details', $wishlist->product->slug) }}">
                        <img src="{{asset('frontend/images/null.jpg')}}" alt="">
                    </a>
                </div>
            @endif
        </td>
        <td>
            <a href="{{ route('product-details', $wishlist->product->slug) }}">{{ $wishlist->product->title }}</a>
            <div class="mobile-cart-content row">
                <div class="col">
                    <p>in stock</p>
                </div>
                <div class="col">
                    <h2 class="td-color">$63.00</h2>
                </div>

                <div class="col">
                    <h2 class="td-color">
                        <a href="#" class="icon me-1"><i class="ti-close"></i></a>
                        <a href="#" class="cart"><i class="ti-shopping-cart"></i></a>
                    </h2>
                </div>
            </div>
        </td>
        <td>
            <h2>
                @if( !is_null( $wishlist->product->offer_price ) )
                    ৳{{ $wishlist->product->offer_price }}
                @else
                    ৳{{ $wishlist->product->regular_price }}
                @endif
            </h2>
        </td>
        <td>
            @if( $wishlist->product->status != 1 )
                <p class="unavailble">Not Available!</p>
            @elseif(  $wishlist->product->quantity == 0 )
                <p class="unavailble">Out of Stock</p>
            @else
                <p class="availble">Availble: {{ $wishlist->product->quantity }} Psc</p>
            @endif
        </td>
        <td>
            {{-- delete wishlist --}}
            <form action="{{ route('del-wishlist', $wishlist->id) }}" method="POST" id="delWishlistForm_{{ $loop->index }}">
                @csrf 
                @method('DELETE')
                <input type="hidden" class="wishlistId" value="{{ $wishlist->id }}">
                <button type="button" class="deleteWishlist deleteWc" data-form-id="{{ $loop->index }}">
                    <i class="ti-close"></i>
                </button>
            </form>

            {{-- wishlsit to cart --}}
            @php
                $matchingCartItem = App\Models\Cart::totalItems()->where('product_id', $wishlist->product_id)->where('user_id', $wishlist->user_id)->where('ip_address', $wishlist->ip_address)->first();
            @endphp
            @if( $wishlist->product->status != 1 || $wishlist->product->quantity == 0 )
                <button class="deleteWc notAdd">
                    <i class="ti-shopping-cart"></i>
                </button>
            @elseif( isset($matchingCartItem) && $wishlist->product_id == $matchingCartItem->product_id )
                <button class="deleteWc existCart">
                    <i class="ti-shopping-cart"></i>
                </button>
            @else
                <form action="{{ route('update-wishlist', $wishlist->id) }}" method="POST" class="moveToCartForm" id="delWishlistForm_{{ $loop->index }}">
                    @csrf 
                    <span>
                        <button type="button" class="deleteWc moveToCart" data-form-id="{{ $loop->index }}">
                            <i class="ti-shopping-cart"></i>
                        </button>
                    </span>
                    <input type="hidden" name="quantity" value="1">
                    <input type="hidden" name="productId" value="{{ $wishlist->product->id }}">
                </form>
            @endif
        </td>
    </tr>
@endforeach