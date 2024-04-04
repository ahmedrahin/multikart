<div>
    <img src="{{asset('frontend/images/wishlist.jpg')}}" class="img-fluid blur-up lazyload wishlist" alt=""><i class="ti-settings"></i>
</div>
<span class="cart_qty_cls">
    {{ App\Models\Wishlist::totalItem() }}                          
</span>
@if( App\Models\Wishlist::totalPsc()->count() != 0 )
    <ul class="show-div shopping-cart" id="wishlistItemsAll">
        @foreach( App\Models\Wishlist::totalPsc()->take(2) as $wishlist )
            <li>
                <div class="media">
                    @if( !is_null( $wishlist->product->thumb_image ) )
                        <div>
                            <a href="{{ route('product-details', $wishlist->product->slug) }}">
                                <img src="{{asset('uploads/product/thumb_image/' . $wishlist->product->thumb_image )}}" alt="" class="me-3">
                            </a>
                        </div>
                    @else
                        <div>
                            <a href="{{ route('product-details', $wishlist->product->slug) }}">
                                <img src="{{asset('frontend/images/null.jpg')}}" alt="" class="me-3">
                            </a>
                        </div>
                    @endif
                    <div class="media-body">
                        <a href="{{ route('product-details', $wishlist->product->slug) }}">
                            <h4>
                                {{ $wishlist->product->title }}
                            </h4>
                        </a>
                        <h4>
                            <span>
                                @if( !is_null( $wishlist->product->offer_price ) )
                                    ৳{{ $wishlist->product->offer_price }}
                                @else
                                    ৳{{ $wishlist->product->regular_price }}
                                @endif
                            </span>
                        </h4>
                    </div>
                </div>
                <div class="close-circle">
                    <form action="{{ route('del-wishlist', $wishlist->id) }}" method="POST" id="delWishlistForm_{{ $loop->index }}">
                        @csrf 
                        @method('DELETE')
                        <input type="hidden" class="wishlistId" value="{{ $wishlist->id }}">
                        <button type="submit" class="deleteWishlist" data-form-id="{{ $loop->index }}">
                            <i class="fa fa-times" aria-hidden="true"></i>
                        </button>
                    </form>
                </div>
            </li>
        @endforeach
        <li>
            <div class="total">
                <h5>Total Item : <span>{{ App\Models\Wishlist::totalItem() }} Item</span></h5>
            </div>
        </li>
        <li>
            <div class="buttons">
                <a href="{{ route('manage-wishlist') }}" class="view-wishlist">View All Wishlist</a>
            </div>
        </li>

        {{-- loader --}}
        <div class="loader">
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
        </div>
    </ul>
@else
    <input type="hidden" class="wcqunt" value="{{ App\Models\Wishlist::totalItem() }}">
    <ul class="show-div shopping-cart">
        <p>No Item Added Into Wishlist!</p>
    </ul>
@endif