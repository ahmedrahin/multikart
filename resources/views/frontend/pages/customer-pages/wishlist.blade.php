@extends('frontend.layout.template')

@section('page-title')
    <title>Wishlist || Multikart</title>
@endsection

@section('page-css')
    <link rel="stylesheet" href="{{ asset('frontend/fonts/icon.all.min.css') }}">
@endsection

@section('body-content')

    <!-- breadcrumb start -->
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="page-title">
                        <h2>Wishlist</h2>
                    </div>
                </div>
                <div class="col-sm-6">
                    <nav aria-label="breadcrumb" class="theme-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">wishlist</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb End -->

    <!--section start-->
    <section class="wishlist-section section-b-space">
        <div class="container">
            <div class="row">
                @if( $wishlists->count() != 0 )
                    <div class="col-sm-12 table-responsive-xs">
                        <table class="table cart-table">
                            <thead>
                                <tr class="table-head">
                                    <th scope="col">image</th>
                                    <th scope="col">product name</th>
                                    <th scope="col">price</th>
                                    <th scope="col">availability</th>
                                    <th scope="col">action</th>
                                </tr>
                            </thead>
                            <tbody class="wishlistBody">
                                @foreach ($wishlists as $wishlist)
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
                                            <form action="{{ route('del-wishlist', $wishlist->id) }}" method="post">
                                                @csrf 
                                                @method('DELETE')
                                                <button type="submit" class="deleteWc">
                                                    <i class="ti-close"></i>
                                                </button>
                                            </form>
                                            @php
                                                $matchingCartItem = App\Models\Cart::totalItems()->where('product_id', $wishlist->product_id)->where('user_id', $wishlist->user_id)->where('ip_address', $wishlist->ip_address)->first();
                                            @endphp
                                            @if( $wishlist->product->status != 1 || $wishlist->product->quantity == 0 )
                                                <button class="deleteWc" id="notAdd">
                                                    <i class="ti-shopping-cart"></i>
                                                </button>
                                            @elseif( isset($matchingCartItem) && $wishlist->product_id == $matchingCartItem->product_id )
                                                <button class="deleteWc" id="existCart">
                                                    <i class="ti-shopping-cart"></i>
                                                </button>
                                            @else
                                                <form action="{{ route('update-wishlist', $wishlist->id) }}" method="post">
                                                    @csrf 
                                                    <button type="submit" class="deleteWc">
                                                        <i class="ti-shopping-cart"></i>
                                                    </button>
                                                    <input type="hidden" name="quantity" value="1">
                                                    <input type="hidden" name="productId" value="{{ $wishlist->product->id }}">
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="bg bg-warning">Sorry!! No Item Added Into Wishlist!</div>
                @endif
            </div>
            <div class="row wishlist-buttons">
                <div class="col-12">
                    <a href="{{ route('all-products') }}" class="btn btn-solid">continue shopping</a> 
                </div>
            </div>
        </div>
    </section>
    <!--section end-->

@endsection

@section('page-script')
    <script>
         let notAdd    = document.getElementById('notAdd');
         let existCart = document.getElementById('existCart');
         if( notAdd ){
            notAdd.onclick = (e) => {
            e.preventDefault();
            toastr.info('The product is not available! <br> Check Back Later.', '', {"positionClass": "toast-top-right", "closeButton": true});
            }
         }
        
        if( existCart ){
            existCart.addEventListener('click', function(e){
            e.preventDefault();
            toastr.info('The product is exsit in your cart', '', {"positionClass": "toast-top-right", "closeButton": true});
          })
        }
        
    </script>
@endsection