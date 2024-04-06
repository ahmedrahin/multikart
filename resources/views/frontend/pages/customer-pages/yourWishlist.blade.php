@php
    $sl = 0;
@endphp
@foreach(App\Models\Wishlist::totalPsc() as $wishlist)
<tr>
    <td>{{ ++$sl }}</td>
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
        <span>
            <a href="{{ route('product-details', $wishlist->product->slug) }}" class="mt-0" style="color: black;">{{ $wishlist->product->title }}</a>
        </span>
    </td>
    <td>
        <span class="theme-color fs-6">
            @if( !is_null( $wishlist->product->offer_price ) )
                ৳{{ $wishlist->product->offer_price }}
            @else
                ৳{{ $wishlist->product->regular_price }}
            @endif
        </span>
    </td>
    <td>
        {{-- <form action="{{ route('del-wishlist', $wishlist->id) }}" method="post">
            @csrf 
            @method('DELETE')
            <button type="submit" class="deleteWc">
                <i class="ti-close"></i>
            </button>
        </form> --}}
        @php
            $matchingCartItem = App\Models\Cart::totalItems()->where('product_id', $wishlist->product_id)->where('user_id', $wishlist->user_id)->where('ip_address', $wishlist->ip_address)->first();
        @endphp
        @if( $wishlist->product->status != 1 || $wishlist->product->quantity == 0 )
            <button class="btn btn-xs btn-solid" id="notAdd">
                Move to Cart
            </button>
        @elseif( isset($matchingCartItem) && $wishlist->product_id == $matchingCartItem->product_id )
            <button class="btn btn-xs btn-solid" id="existCart">
                Move to Cart
            </button>
        @else
            <form action="{{ route('update-wishlist', $wishlist->id) }}" method="post" class="moveToCartForm" id="delWishlistForm_{{ $loop->index }}">
                @csrf 
                <button type="button" class="btn btn-xs btn-solid moveToCart" data-form-id="{{ $loop->index }}">
                    Move to Cart
                </button>
                <input type="hidden" name="quantity" value="1">
                <input type="hidden" name="productId" value="{{ $wishlist->product->id }}">
            </form>
        @endif
    </td>
</tr>
@endforeach