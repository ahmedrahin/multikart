@foreach( App\Models\Cart::totalItems() as $cart )
    @if( $cart->product->status == 1 )
        <tr>
            <td>
                <form class="delCartForm" id="delCartForm_{{ $loop->index }}">
                    @csrf 
                    @method('DELETE')
                    <input type="hidden" class="cartId" value="{{ $cart->id }}">
                    <button type="button" class="icon deleteWc deleteCart" data-form-id="{{ $loop->index }}">
                        <i class="ti-close"></i>
                    </button>
                </form>
            </td>
            <td>
                @if( !is_null( $cart->product->thumb_image ) )
                    <div>
                        <a href="{{ route('product-details', $cart->product->slug) }}">
                            <img src="{{asset('uploads/product/thumb_image/' . $cart->product->thumb_image )}}" alt="">
                        </a>
                    </div>
                @else
                    <div>
                        <a href="{{ route('product-details', $cart->product->slug) }}">
                            <img src="{{asset('frontend/images/null.jpg')}}" alt="">
                        </a>
                    </div>
                @endif
            </td>
            <td>
                <a href="{{ route('product-details', $cart->product->slug) }}">
                    {{ $cart->product->title }}
                </a>
                <div class="mobile-cart-content row">
                    <div class="col">
                        <div class="qty-box">
                            <div class="input-group">
                                <input type="text" name="quantity" class="form-control input-number" value="{{ $cart->product_quantity }}">
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <h2 class="td-color">
                            @if( !is_null( $cart->product->offer_price ) )
                                ৳{{ $cart->product->offer_price }}
                            @else
                                ৳{{ $cart->product->regular_price }}
                            @endif
                        </h2>
                    </div>
                    <div class="col">
                        <h2 class="td-color"><a href="#" class="icon"><i class="ti-close"></i></a></h2>
                    </div>
                </div>
            </td>
            <td>
                <h2>
                    @if( !is_null( $cart->product->offer_price ) )
                        ৳{{ $cart->product->offer_price }}
                    @else
                        ৳{{ $cart->product->regular_price }}
                    @endif
                </h2>
            </td>
            <td>
                <div class="qty-box">
                    <div class="input-group">
                        <span class="input-group-prepend">
                            <button type="button" class="btn quantity-left-minus" data-type="minus" data-field="">
                                <i class="ti-angle-left"></i>
                            </button> 
                        </span>
                        <input type="text" name="quantity" class="form-control input-number" value="{{ $cart->product_quantity }}">
                        <span class="input-group-prepend">
                            <button type="button" class="btn quantity-right-plus" data-type="plus" data-field="">                                           <i class="ti-angle-right"></i>
                            </button>
                        </span>
                    </div>
                </div>
            </td>
            
            <td>
                <h2 class="td-color">
                    @if( !is_null( $cart->product->offer_price ) )
                        ৳{{ $cart->product->offer_price * $cart->product_quantity }}
                    @else
                        ৳{{ $cart->product->regular_price * $cart->product_quantity }}
                    @endif
                </h2>
            </td>
        </tr>
    @endif
@endforeach