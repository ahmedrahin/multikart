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

                    {{-- cart item start --}}
                    <li class="onhover-div mobile-cart">
                        <div class="cart-items">
                            @include('frontend.includes.cartItem')
                        </div>
                    </li>
                    {{-- cart item end --}}

                    <li class="onhover-div mobile-setting">
                        <div class="wishlist-items">
                            @include('frontend.includes.wishlistItem')
                        </div>
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