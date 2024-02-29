@extends('frontend.layout.template')

@section('page-title')
    <title> Cart || Multikart</title>
@endsection

@section('page-css')
    
@endsection

@section('body-content')
    <!-- breadcrumb start -->
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="page-title">
                        <h2>cart</h2>
                    </div>
                </div>
                <div class="col-sm-6">
                    <nav aria-label="breadcrumb" class="theme-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                            <li class="breadcrumb-item active">cart</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb End -->

    <!--section start-->
    <section class="cart-section section-b-space">
        <div class="container">
            <div class="row">
                @if( App\Models\Cart::totalQunt() != 0 )
                    <div class="col-sm-12">
                        <!-- <div class="cart_counter">
                            <div class="countdownholder">
                                Your cart will be expired in<span id="timer"></span> minutes!
                            </div>
                            <a href="checkout.html" class="cart_checkout btn btn-solid btn-xs">check out</a>
                        </div> -->
                    </div>
                    <div class="col-sm-12 table-responsive-xs">
                        <table class="table cart-table">
                            <thead>
                                <tr class="table-head">
                                    <th scope="col">action</th>
                                    <th scope="col">image</th>
                                    <th scope="col">product name</th>
                                    <th scope="col">price</th>
                                    <th scope="col">quantity</th>                                   
                                    <th scope="col">total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach( App\Models\Cart::totalItems() as $cart )
                                @if( $cart->product->status == 1 )
                                    <tr>
                                        <td>
                                            <form action="{{ route('cart-delete', $cart->id) }}" method="POST">
                                                @csrf 
                                                @method('DELETE')
                                                <input type="hidden" id="cartId" value="274">
                                                <button class="icon deleteWc deleteCart" type="submit">
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
                            </tbody>
                        </table>
                        
                        <div class="table-responsive-md">
                            <table class="table cart-table ">
                                <tfoot>
                                    <tr>
                                        <td>total price :</td>
                                        <td>
                                            <h2>
                                                ৳{{ App\Models\Cart::totalAmount() }}
                                            </h2>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                @else
                    <div class="bg bg-warning">Sorry!! No Item Added Into Cart!</div>
                @endif
            </div>
            <div class="row cart-buttons">
                <div class="col-6"><a href="{{ url('/all-products') }}" class="btn btn-solid">continue shopping</a></div>
                    <div class="col-6">
                        @if( App\Models\Cart::totalQunt() != 0 )
                            <a href="{{ url('/checkout') }}" class="btn btn-solid">check out</a>
                        @endif
                    </div>
            </div>
        </div>
    </section>
    <!--section end-->
@endsection

@section('page-script')
    <script src="{{ asset('frontend/js/timer1.js') }}"></script>
@endsection