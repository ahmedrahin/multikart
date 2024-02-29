<!-- top panel start -->
{{-- <div class="top-panel-adv">
<div class="container">
<div class="row align-items-center">
<div class="col-10">
<div class="panel-left-content">
    <h4 class="mb-0">Welcome to Multikart!! Delivery in <span>10 Minutes.</span> </h4>
    <div class="delivery-area d-md-block d-none">
        <div>
            <h5>Limited Time offer</h5>
            <h4>code: 25FsfuABdS</h4>
        </div>
    </div>
</div>
</div>
<div class="col-2">
<a href="javascript:void(0)" class="close-btn"><i data-feather="x"></i></a>
</div>
</div>
</div>
</div> --}}
<!-- top panel end -->


<!-- header start -->
<header id="sticky-header" class="style-light header-compact">
<div class="mobile-fix-option"></div>
<div class="top-header top-header-theme">
<div class="container">
<div class="row">
<div class="col-lg-6">
    <div class="header-contact">
        <ul>
            <li>Welcome to Our store Multikart</li>
            <li><a href="become-vendor.html" class="text-white fw-bold">Become a Vendor</a></li>
        </ul>
    </div>
</div>
<div class="col-lg-6 text-end">
    <ul class="header-dropdown">


        @if( Auth::check() )
            <li class="onhover-dropdown mobile-account"><i class="fa fa-user" aria-hidden="true"></i>
                {{ Auth::user()->name }}
                <ul class="onhover-show-div">
                    <li><a href="{{ route('user-dashboard') }}">Dashboard</a></li>
                    <li><a href="{{ route('user-profile') }}">My Profile</a></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="{{ route('logout') }}" onclick="event.preventDefault();
                            this.closest('form').submit();">
                                Logout
                            </a>
                        </form>
                    </li>
                </ul>
            </li>
        @else
            <li class="onhover-dropdown mobile-account"><i class="fa fa-user" aria-hidden="true"></i>     
                My Account
                <ul class="onhover-show-div">
                    <li><a href="{{ route('login') }}">Login</a></li>
                    <li><a href="{{ route('register') }}">register</a></li>
                </ul>
            </li>
        @endif 
    </ul>
</div>
</div>
</div>
</div>
<div class="container">
<div class="row">
<div class="col-sm-12">
<div class="main-menu">
    <div class="menu-left">
        <div class="brand-logo">
            <a href="{{ url('/') }}">
                @php
                    $logo = \App\Models\Settings::shop_logo();
                @endphp
                @if(!is_null($logo))
                    <img src="{{ asset('uploads/fav_logo/' . $logo->logo) }}" class="img-fluid blur-up lazyload" alt="">
                @else 
                     <span class="logo">Logo</span>
                @endif
            </a>
        </div>
    </div>
    <div>
        <div class="search_box">
            <form action="/search" method="GET" class="form_search" role="form">
                
                <input type="search" name="term" id="searchInput" placeholder="Search for products...">
                <button type="submit" class="btn-search">
                    <i class="ti-search"></i>
                </button>
            </form>
            <!-- Dropdown menu for suggestions -->
            <div id="suggestionDropdown"></div>
        </div>
    </div>
    <div class="menu-right pull-right">
        <div>
            <div class="icon-nav">
                <ul>
                    <li class="onhover-div mobile-search d-xl-none d-inline-block">
                        <div><img src="{{asset('frontend/images/icon/search.png')}}" onclick="openSearch()"
                                class="img-fluid blur-up lazyload" alt=""><i class="ti-search"
                                onclick="openSearch()"></i></div>
                        <div id="search-overlay" class="search-overlay">
                            <div><span class="closebtn" onclick="closeSearch()"
                                    title="Close Overlay">×</span>
                                <div class="overlay-content">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <div class="search_box">
                                                    <form action="{{ route('search-product') }}"  class="form_search" role="form">
                                                        @csrf
                                                        <input type="search" name="term" id="searchInput" placeholder="Search for products...">
                                                        <button type="submit" name="nav-submit-button" class="btn-search">
                                                            <i class="ti-search"></i>
                                                        </button>
                                                    </form>
                                                    <!-- Dropdown menu for suggestions -->
                                                    <div id="suggestionDropdown"></div>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>

                    <li class="onhover-div mobile-setting">
                        <div>
                            <img src="{{asset('frontend/images/setting.png')}}" class="img-fluid blur-up lazyload" alt=""><i class="ti-settings"></i>
                        </div>
                        <div class="show-div setting">
                            <h6>language</h6>
                            <ul>
                                <li><a href="#">english</a></li>
                                <li><a href="#">french</a></li>
                            </ul>
                            <h6>currency</h6>
                            <ul class="list-inline">
                                <li><a href="#">euro</a></li>
                                <li><a href="#">rupees</a></li>
                                <li><a href="#">pound</a></li>
                                <li><a href="#">doller</a></li>
                            </ul>
                        </div>
                    </li>

                    <li class="onhover-div mobile-cart">
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
                                                <form action="{{ route('cart-delete', $cart->id) }}" method="POST" name="delCart">
                                                    @csrf 
                                                    @method('DELETE')
                                                    <input type="hidden" class="cartId" value="{{$cart->id}}">
                                                    <button type="submit" class="deleteCart">
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
                            </ul>
                        @else
                            <ul class="show-div shopping-cart">
                                <p>No Item Added Into Cart!</p>
                            </ul>
                        @endif
                    </li>

                    <li class="onhover-div mobile-setting">
                        <div>
                            <img src="{{asset('frontend/images/wishlist.jpg')}}" class="img-fluid blur-up lazyload wishlist" alt=""><i class="ti-settings"></i>
                        </div>
                        <span class="cart_qty_cls">
                            {{ App\Models\Wishlist::totalItem() }}                          
                        </span>
                        @if( App\Models\Wishlist::totalPsc()->count() != 0 )
                                <ul class="show-div shopping-cart">
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
                                                <form action="{{ route('del-wishlist', $wishlist->id) }}" method="POST">
                                                    @csrf 
                                                    @method('DELETE')
                                                    <button type="submit" class="deleteWishlist">
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
                                </ul>
                            @else
                                <ul class="show-div shopping-cart">
                                    <p>No Item Added Into Wishlist!</p>
                                </ul>
                            @endif
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>
<div class="bottom-part bottom-light">
<div class="container">
<div class="row">
<div class="col-12 menu-row">
    <div data-bs-toggle="modal" data-bs-target="#deliveryarea" class="delivery-area d-md-flex d-none">
        <i data-feather="map-pin"></i>
        <div>
            <h6>Delivery to</h6>
            <h5>400520</h5>
        </div>
    </div>
    <div class="main-nav-center">
        <nav id="main-nav" class="">
            <div class="toggle-nav"><i class="fa fa-bars sidebar-bar"></i></div>
            <ul id="main-menu" class="sm pixelstrap sm-horizontal">
                <li>
                    <div class="mobile-back text-end">Back<i class="fa fa-angle-right ps-2" aria-hidden="true"></i></div>
                </li>
                <li><a href="{{ route('homepage') }}" class="{{ Request::is('/') ? 'active' : '' }}">Home</a></li>
                <li>
                    <a href="{{ route('all-products') }}" class="{{ Request::is('all-products') ? 'active' : '' }}">All Products</a>
                </li>
                <li>
                    <a href="{{ route('offer-products') }}" class="{{ Request::is('offer-products') ? 'active' : '' }}">Offer products</a>
                </li>
                <li>
                    <a href="{{ route('aboutpage') }}" class="{{ Request::is('about') ? 'active' : '' }}">About Us</a>
                </li>
                <li>
                    <a href="{{ route('contactpage') }}" class="{{ Request::is('contact') ? 'active' : '' }}">Contact</a>
                </li>
            </ul>
        </nav>
    </div>
    <div class="delivery-area d-xl-flex d-none">
        <div>
            <h5>Call us: 123-456-7898</h5>
        </div>
    </div>
</div>
</div>
</div>
</div>
</header>
<!-- header end -->