@extends('frontend.layout.template')

@section('page-title')
    <title>My Dashboard || Multikart</title>
@endsection

@section('page-css')
    <style>
        .theme-modal .btn-close{
            opacity: 1 !important;
        }
        .theme-modal .btn-close span{
            color: #ff4c3b !important;
            font-weight: 800 !important;
            font-size: 28px !important;
        }
        .theme-modal.exit-modal .media .media-body h5 {
            margin-bottom: 15px;
            font-size: 16px
        }
        .media .btn-primary {
            background: #ff4c3b;
            border-color: #ff4c3b;
        }
        .media button {
            border-radius: 3px;
        }
    </style>
@endsection

@section('body-content')
    <!-- breadcrumb start -->
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="page-title">
                        <h2>dashboard</h2>
                    </div>
                </div>
                <div class="col-sm-6">
                    <nav aria-label="breadcrumb" class="theme-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">dashboard</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb End -->

    <!--  dashboard section start -->
    <section class="dashboard-section section-b-space user-dashboard-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="dashboard-sidebar">
                        <div class="profile-top">
                            <div class="profile-image">
                                @if( !is_null(Auth::user()->image) )
                                    <img src="{{ asset('uploads/user/' . Auth::user()->image) }}" alt="" class="img-fluid">
                                @else
                                    <img src="{{ asset('backend/images/user.jpg') }}" alt="" class="img-fluid">
                                @endif
                                
                            </div>
                            <div class="profile-detail">
                                <h5>{{ Auth::user()->name }}</h5>
                                <h6>{{ Auth::user()->email }}</h6>
                            </div>
                        </div>
                        <div class="faq-tab">
                            <ul class="nav nav-tabs" id="top-tab" role="tablist">
                                <li class="nav-item">
                                    <a data-bs-toggle="tab" data-bs-target="#info" 
                                        class="nav-link active">Account Info</a></li>
                                <li class="nav-item"><a data-bs-toggle="tab" data-bs-target="#address"
                                        class="nav-link">Address Book</a></li>
                                <li class="nav-item"><a data-bs-toggle="tab" data-bs-target="#orders"
                                        class="nav-link">My Orders</a></li>
                                <li class="nav-item"><a data-bs-toggle="tab" data-bs-target="#wishlist"
                                        class="nav-link">My Wishlist</a></li>
                                <li class="nav-item"><a data-bs-toggle="tab" data-bs-target="#payment"
                                        class="nav-link">Saved Cards</a></li>
                                <li class="nav-item"><a data-bs-toggle="tab" data-bs-target="#profile"
                                        class="nav-link">Profile</a></li>
                                <li class="nav-item"><a data-bs-toggle="tab" data-bs-target="#security"
                                        class="nav-link">Settings</a> </li>
                                <li class="nav-item">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault();
                                        this.closest('form').submit();">
                                            Log Out
                                        </a>
                                    </form> 
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="faq-content tab-content" id="top-tabContent">
                        <div class="tab-pane fade show active" id="info">
                            <div class="counter-section">
                                <div class="welcome-msg">
                                    <h4>Hello, {{ Auth::user()->name }} !</h4>
                                    <p>From your My Account Dashboard you have the ability to view a snapshot of your
                                        recent
                                        account activity and update your account information. Select a link below to
                                        view or
                                        edit information.</p>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="counter-box">
                                            <img src="{{ asset('frontend/images/icon/dashboard/sale.png') }}" class="img-fluid">
                                            <div>
                                                <h3>{{ $orders->count() }}</h3>
                                                <h5>Total Order</h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="counter-box">
                                            <img src="{{ asset('frontend/images/icon/dashboard/homework.png') }}" class="img-fluid">
                                            <div>
                                                <h3>
                                                    {{ $orders->where('status', 'Pending')->count() }}
                                                </h3>
                                                <h5>Pending Orders</h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="counter-box">
                                            <img src="{{ asset('frontend/images/icon/dashboard/order.png') }}" class="img-fluid">
                                            <div>
                                                <h3>
                                                    @php
                                                        $wishlist = App\Models\Wishlist::where('user_id', Auth::user()->id)->count();
                                                        echo $wishlist;
                                                    @endphp
                                                </h3>
                                                <h5>Wishlist</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="box-account box-info">
                                    <div class="box-head">
                                        <h4>Account Information</h4>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="box">
                                                <div class="box-title">
                                                    <h3>Contact Information</h3><a href="{{ url('/my-profile') }}">Edit</a>
                                                </div>
                                                <div class="box-content">
                                                    <h6>{{ Auth::user()->name }}</h6>
                                                    <h6>{{ Auth::user()->email }}</h6>
                                                    <h6><a href="">Change Password</a></h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="box">
                                                <div class="box-title">
                                                    <h3>Newsletters</h3><a href="javascript:;">Edit</a>
                                                </div>
                                                <div class="box-content">
                                                    <p>You are currently not subscribed to any newsletter.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="box mt-3">
                                        <div class="box-title">
                                            <h3>Address Book</h3><a href="{{ url('/my-profile') }}">Manage Addresses</a>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <h6>Default Billing Address</h6>
                                                <address>
                                                    @if( !is_null(Auth::user()->address_line1) )
                                                        {{ Auth::user()->address_line1 }}, 
                                                        @if( !is_null(Auth::user()->address_line2) )
                                                            {{ Auth::user()->address_line2 }}
                                                            <br>
                                                        @endif
                                                        @if( isset( Auth::user()->district->id ) )
                                                            @if( !is_null(Auth::user()->district_id) && Auth::user()->district->status == 1)
                                                                {{ Auth::user()->district->name }},
                                                                @if( isset( Auth::user()->division_id ) )
                                                                    @if( !is_null(Auth::user()->division_id) && Auth::user()->state->status == 1)
                                                                        {{ Auth::user()->state->name }}
                                                                    @endif
                                                                @endif              
                                                            @endif
                                                        @endif                
                                                    @else
                                                        You have not set a default billing address.
                                                    @endif
                                                    <br>
                                                    <a href="{{ url('/my-profile') }}">Edit Address</a>
                                                </address>
                                            </div>
                                            <div class="col-sm-6">
                                                <h6>Default Shipping Address</h6>
                                                {{-- <address>
                                                    @if( !is_null(Auth::user()->address_line1) )
                                                        {{ Auth::user()->address_line1 }}, 
                                                        @if( !is_null(Auth::user()->address_line2) )
                                                            {{ Auth::user()->address_line2 }}
                                                            <br>
                                                        @endif
                                                        @if( !is_null(Auth::user()->district_id) )
                                                        {{ Auth::user()->district->name }},
                                                        @endif
                                                        @if( !is_null(Auth::user()->division_id) )
                                                            {{ Auth::user()->state->name }}
                                                            <br>
                                                        @endif                
                                                    @else
                                                        You have not set a default billing address.
                                                        <br>
                                                    @endif
                                                    <a href="{{ url('/my-profile') }}">Edit Address</a>
                                                </address> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="address">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card mt-0">
                                        <div class="card-body">
                                            <div class="top-sec">
                                                <h3>Address Book</h3>
                                                <a href="#" class="btn btn-sm btn-solid">+ add new</a>
                                            </div>
                                            <div class="address-book-section">
                                                <div class="row g-4">
                                                    <div class="select-box active col-xl-4 col-md-6">
                                                        <div class="address-box">
                                                            <div class="top">
                                                                <h6>mark jecno <span>home</span></h6>
                                                            </div>
                                                            <div class="middle">
                                                                <div class="address">
                                                                    <p>549 Sulphur Springs Road</p>
                                                                    <p>Downers Grove, IL</p>
                                                                    <p>60515</p>
                                                                </div>
                                                                <div class="number">
                                                                    <p>mobile: <span>+91 123 - 456 - 7890</span></p>
                                                                </div>
                                                            </div>
                                                            <div class="bottom">
                                                                <a href="javascript:void(0)"
                                                                    data-bs-target="#edit-address"
                                                                    data-bs-toggle="modal" class="bottom_btn">edit</a>
                                                                <a href="#" class="bottom_btn">remove</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="select-box col-xl-4 col-md-6">
                                                        <div class="address-box">
                                                            <div class="top">
                                                                <h6>mark jecno <span>office</span></h6>
                                                            </div>
                                                            <div class="middle">
                                                                <div class="address">
                                                                    <p>549 Sulphur Springs Road</p>
                                                                    <p>Downers Grove, IL</p>
                                                                    <p>60515</p>
                                                                </div>
                                                                <div class="number">
                                                                    <p>mobile: <span>+91 123 - 456 - 7890</span></p>
                                                                </div>
                                                            </div>
                                                            <div class="bottom">
                                                                <a href="javascript:void(0)"
                                                                    data-bs-target="#edit-address"
                                                                    data-bs-toggle="modal" class="bottom_btn">edit</a>
                                                                <a href="#" class="bottom_btn">remove</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="orders">
                            <div class="row">
                                <div class="col-12">
                                        @if( $orders->count() != 0 )
                                            <div class="card dashboard-table mt-0">
                                                <div class="card-body user-order-table table-responsive-sm">
                                                    <div class="top-sec">
                                                        <h3>My Orders</h3>
                                                    </div>
                                                    <div class="table-responsive-xl">
                                                        <table class="table cart-table order-table">
                                                            <thead>
                                                                <tr class="table-head">
                                                                    <th scope="col">Sl.</th>
                                                                    <th scope="col">Order Id</th>
                                                                    <th scope="col">Order Date</th>
                                                                    <th scope="col">Status</th>
                                                                    <th scope="col">Total Price</th>
                                                                    <th scope="col">View</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @php $sl = 0; @endphp
                                                                @foreach( $orders as $order )
                                                                    <tr>
                                                                        <td>{{ ++$sl }}</td>
                                                                        <td>
                                                                            <span class="mt-0">#{{ $order->id }}</span>
                                                                        </td>
                                                                        <td>
                                                                            <span class="fs-6">{{ $order->order_date }}</span>
                                                                        </td>
                                                                        <td>
                                                                            @if($order->status == "Pending")
                                                                                <span class="badge rounded-pill bg-secondary custom-badge">Pending</span>   
                                                                            @elseif($order->status == "Processing")
                                                                                <span class="badge rounded-pill bg-info custom-badge">Processing</span>   
                                                                            @elseif($order->status == "Completed")
                                                                                <span class="badge rounded-pill bg-success custom-badge">Completed</span>
                                                                            @elseif($order->status == "Canceled")
                                                                                <span class="badge rounded-pill bg-danger custom-badge">Canceled</span>
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                            <span class="theme-color fs-6">৳{{ $order->amount }}</span>
                                                                        </td>
                                                                        <td>
                                                                            <a href="{{ route('order-invoice', $order->id) }}" target="_blank">
                                                                                <i class="fa fa-eye text-theme"></i>
                                                                            </a>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <div class="bg bg-warning">Opps!! No Order Found</div>
                                        @endif
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="wishlist">
                            <div class="row">
                                <div class="col-12">
                                    @if( $wishlists->count() != 0 )
                                        <div class="card dashboard-table mt-0">
                                            <div class="card-body table-responsive-sm">
                                                <div class="top-sec">
                                                    <h3>My Wishlist</h3>
                                                </div>
                                                <div class="table-responsive-xl">
                                                    <table class="table cart-table wishlist-table">
                                                        <thead>
                                                            <tr class="table-head">
                                                                <th scope="col">Sl.</th>
                                                                <th scope="col">image</th>
                                                                <th scope="col">Product Title</th>
                                                                <th scope="col">Price</th>
                                                                <th scope="col">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @php
                                                                $sl = 0;
                                                            @endphp
                                                            @foreach($wishlists as $wishlist)
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
                                                                            <form action="{{ route('update-wishlist', $wishlist->id) }}" method="post">
                                                                                @csrf 
                                                                                <button type="submit" class="btn btn-xs btn-solid">
                                                                                    Move to Cart
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
                                            </div>
                                        </div>
                                    @else
                                        <div class="bg bg-warning">Opps!! No Wishlist Found</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="payment">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card mt-0">
                                        <div class="card-body">
                                            <div class="top-sec">
                                                <h3>Saved Cards</h3>
                                                <a href="#" class="btn btn-sm btn-solid">+ add new</a>
                                            </div>
                                            <div class="address-book-section">
                                                <div class="row g-4">
                                                    <div class="select-box active col-xl-4 col-md-6">
                                                        <div class="address-box">
                                                            <div class="bank-logo">
                                                                <img src="{{ asset('frontend/images/bank-logo.png') }}"
                                                                    class="bank-logo">
                                                                <img src="{{ asset('frontend/images/visa.png') }}"
                                                                    class="network-logo">
                                                            </div>
                                                            <div class="card-number">
                                                                <h6>Card Number</h6>
                                                                <h5>6262 6126 2112 1515</h5>
                                                            </div>
                                                            <div class="name-validity">
                                                                <div class="left">
                                                                    <h6>name on card</h6>
                                                                    <h5>Mark Jecno</h5>
                                                                </div>
                                                                <div class="right">
                                                                    <h6>validity</h6>
                                                                    <h5>XX/XX</h5>
                                                                </div>
                                                            </div>
                                                            <div class="bottom">
                                                                <a href="javascript:void(0)"
                                                                    data-bs-target="#edit-address"
                                                                    data-bs-toggle="modal" class="bottom_btn">edit</a>
                                                                <a href="#" class="bottom_btn">remove</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="select-box col-xl-4 col-md-6">
                                                        <div class="address-box">
                                                            <div class="bank-logo">
                                                                <img src="{{ asset('frontend/images/bank-logo1.png') }}"
                                                                    class="bank-logo">
                                                                <img src="{{ asset('frontend/images/visa.png') }}"
                                                                    class="network-logo">
                                                            </div>
                                                            <div class="card-number">
                                                                <h6>Card Number</h6>
                                                                <h5>6262 6126 2112 1515</h5>
                                                            </div>
                                                            <div class="name-validity">
                                                                <div class="left">
                                                                    <h6>name on card</h6>
                                                                    <h5>Mark Jecno</h5>
                                                                </div>
                                                                <div class="right">
                                                                    <h6>validity</h6>
                                                                    <h5>XX/XX</h5>
                                                                </div>
                                                            </div>
                                                            <div class="bottom">
                                                                <a href="javascript:void(0)"
                                                                    data-bs-target="#edit-address"
                                                                    data-bs-toggle="modal" class="bottom_btn">edit</a>
                                                                <a href="#" class="bottom_btn">remove</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="profile">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card mt-0">
                                        <div class="card-body">
                                            <div class="dashboard-box">
                                                <div class="dashboard-title">
                                                    <h4>profile</h4>
                                                    <a class="edit-link" href="{{ url('/my-profile') }}">edit</a>
                                                </div>
                                                <div class="dashboard-detail">
                                                    <ul>
                                                        <li>
                                                            <div class="details">
                                                                <div class="left">
                                                                    <h6>your name:</h6>
                                                                </div>
                                                                <div class="right">
                                                                    <h6>{{ Auth::user()->name }}</h6>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="details">
                                                                <div class="left">
                                                                    <h6>email address:</h6>
                                                                </div>
                                                                <div class="right">
                                                                    <h6 style="text-transform:lowercase;">{{ Auth::user()->email }}</h6>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="details">
                                                                <div class="left">
                                                                    <h6>Phone Number:</h6>
                                                                </div>
                                                                <div class="right">
                                                                    <h6>
                                                                        @if( !is_null(Auth::user()->phone) )
                                                                            {{ Auth::user()->phone }}   
                                                                        @endif
                                                                    </h6>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="details">
                                                                <div class="left">
                                                                    <h6>street address:</h6>
                                                                </div>
                                                                <div class="right">
                                                                    <h6>
                                                                        @if( !is_null(Auth::user()->address_line1) )
                                                                            {{ Auth::user()->address_line1 }}, 
                                                                            @if( !is_null(Auth::user()->address_line2) )
                                                                                {{ Auth::user()->address_line2 }}   
                                                                            @endif 
                                                                        @endif
                                                                    </h6>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="details">
                                                                <div class="left">
                                                                    <h6>city / state:</h6>
                                                                </div>
                                                                <div class="right">
                                                                    <h6>
                                                                        @if( isset( Auth::user()->district_id ) )
                                                                            @if( !is_null(Auth::user()->district_id) && Auth::user()->district->status == 1 )
                                                                                
                                                                                {{ Auth::user()->district->name }}, 
                                                                                @if( isset( Auth::user()->division_id ) )
                                                                                    @if( !is_null(Auth::user()->division_id) && Auth::user()->state->status == 1)
                                                                                        {{ Auth::user()->state->name }}
                                                                                    @endif
                                                                                @endif 
                                                                            @endif
                                                                        @endif
                                                                    </h6>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="details">
                                                                <div class="left">
                                                                    <h6>Country / Region:</h6>
                                                                </div>
                                                                <div class="right">
                                                                    <h6>
                                                                        @if( isset( Auth::user()->country_id ) )
                                                                            @if( !is_null(Auth::user()->country_id) && Auth::user()->country->status == 1)
                                                                                {{ Auth::user()->country->name }}
                                                                            @endif
                                                                        @endif 
                                                                    </h6>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="details">
                                                                <div class="left">
                                                                    <h6>zip:</h6>
                                                                </div>
                                                                <div class="right">
                                                                    <h6>
                                                                        @if( !is_null(Auth::user()->zipCode) )
                                                                            {{ Auth::user()->zipCode }}   
                                                                        @endif
                                                                    </h6>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="dashboard-title mt-lg-5 mt-3">
                                                    <h4>login details</h4>
                                                    <a class="edit-link" href="{{ url('/my-profile') }}">edit</a>
                                                </div>
                                                <div class="dashboard-detail">
                                                    <ul>
                                                        <li>
                                                            <div class="details">
                                                                <div class="left">
                                                                    <h6>Email Address</h6>
                                                                </div>
                                                                <div class="right">
                                                                    <h6>{{ Auth::user()->email }}</h6>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="details">
                                                                <div class="left">
                                                                    <h6>Phone No.</h6>
                                                                </div>
                                                                <div class="right">
                                                                    <h6>
                                                                        @if( !is_null(Auth::user()->phone) )
                                                                            {{ Auth::user()->phone }}
                                                                        @endif
                                                                    </h6>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="details">
                                                                <div class="left">
                                                                    <h6>Password</h6>
                                                                </div>
                                                                <div class="right">
                                                                    <h6>*******</h6>
                                                                </div>
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
                        <div class="tab-pane fade" id="security">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card mt-0">
                                        <div class="card-body">
                                            <div class="dashboard-box">
                                                <div class="dashboard-title">
                                                    <h4>settings</h4>
                                                </div>
                                                <div class="dashboard-detail">
                                                    <div class="account-setting">
                                                        <h5>Notifications</h5>
                                                        <div class="row">
                                                            <div class="col">
                                                                <div class="form-check">
                                                                    <input class="radio_animated form-check-input"
                                                                        type="radio" name="exampleRadios"
                                                                        id="exampleRadios1" value="option1" checked>
                                                                    <label class="form-check-label"
                                                                        for="exampleRadios1">
                                                                        Allow Desktop Notifications
                                                                    </label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="radio_animated form-check-input"
                                                                        type="radio" name="exampleRadios"
                                                                        id="exampleRadios2" value="option2">
                                                                    <label class="form-check-label"
                                                                        for="exampleRadios2">
                                                                        Enable Notifications
                                                                    </label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="radio_animated form-check-input"
                                                                        type="radio" name="exampleRadios"
                                                                        id="exampleRadios3" value="option3">
                                                                    <label class="form-check-label"
                                                                        for="exampleRadios3">
                                                                        Get notification for my own activity
                                                                    </label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="radio_animated form-check-input"
                                                                        type="radio" name="exampleRadios"
                                                                        id="exampleRadios4" value="option4">
                                                                    <label class="form-check-label"
                                                                        for="exampleRadios4">
                                                                        DND
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="account-setting">
                                                        <h5>deactivate account</h5>
                                                        <div class="row">
                                                            <div class="col">
                                                                <div class="form-check">
                                                                    <input class="radio_animated form-check-input"
                                                                        type="radio" name="exampleRadios1"
                                                                        id="exampleRadios4" value="option4" checked>
                                                                    <label class="form-check-label"
                                                                        for="exampleRadios4">
                                                                        I have a privacy concern
                                                                    </label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="radio_animated form-check-input"
                                                                        type="radio" name="exampleRadios1"
                                                                        id="exampleRadios5" value="option5">
                                                                    <label class="form-check-label"
                                                                        for="exampleRadios5">
                                                                        This is temporary
                                                                    </label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="radio_animated form-check-input"
                                                                        type="radio" name="exampleRadios1"
                                                                        id="exampleRadios6" value="option6">
                                                                    <label class="form-check-label"
                                                                        for="exampleRadios6">
                                                                        other
                                                                    </label>
                                                                </div>
                                                                <button type="button" class="btn btn-solid btn-xs" data-bs-toggle="modal" data-bs-target="#deactiveAcount" >Deactivate Account

                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="account-setting">
                                                        <h5>Delete account</h5>
                                                        <div class="row">
                                                            <div class="col">
                                                                
                                                                    <div class="form-check">
                                                                        <input class="radio_animated form-check-input"
                                                                            type="radio" name="exampleRadios3"
                                                                            id="exampleRadios7" value="option7" checked>
                                                                        <label class="form-check-label"
                                                                            for="exampleRadios7">
                                                                            No longer usable
                                                                        </label>
                                                                    </div>
                                                                    <div class="form-check">
                                                                        <input class="radio_animated form-check-input"
                                                                            type="radio" name="exampleRadios3"
                                                                            id="exampleRadios8" value="option8">
                                                                        <label class="form-check-label"
                                                                            for="exampleRadios8">
                                                                            Want to switch on other account
                                                                        </label>
                                                                    </div>
                                                                    <div class="form-check">
                                                                        <input class="radio_animated form-check-input"
                                                                            type="radio" name="exampleRadios3"
                                                                            id="exampleRadios9" value="option9">
                                                                        <label class="form-check-label"
                                                                            for="exampleRadios9">
                                                                            other
                                                                        </label>
                                                                    </div>

                                                                    <button type="button" class="btn btn-solid btn-xs" data-bs-toggle="modal" data-bs-target="#deleteAcount">
                                                                        Delete Account
                                                                    </button>
                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--  dashboard section end -->

    {{-- delete account --}}
    <div class="modal fade bd-example-modal-lg theme-modal exit-modal show" id="deleteAcount" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body modal1">
                    <div class="container-fluid p-0">
                        <div class="row">
                            <div class="col-12">
                                <div class="modal-bg">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                    <div class="media">
                                        <div class="media-body text-start align-self-center">
                                            <div>
                                                <h2>wait!</h2>
                                                <h4>
                                                    Are you sure?
                                                </h4>
                                                <h5>Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.</h5>
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                &nbsp; 
                                                <form method="post" action="{{ route('profile-destroy', Auth::user()->id) }}" class="p-6" style="display: inline">
                                                        @csrf
                                                        @method('delete')
                                                    <button type="submit" class="btn btn-primary">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- deactive account --}}
    <div class="modal fade bd-example-modal-lg theme-modal exit-modal show" id="deactiveAcount" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body modal1">
                    <div class="container-fluid p-0">
                        <div class="row">
                            <div class="col-12">
                                <div class="modal-bg">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                    <div class="media">
                                        <div class="media-body text-start align-self-center">
                                            <div>
                                                <h2>wait!</h2>
                                                <h4>
                                                    Are you sure?
                                                </h4>
                                                <h5>Once your account is deactive, you will need to contact multikart community to inactive your account again. Thank You.</h5>
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                &nbsp; 
                                                <form method="post" action="{{ route('deactive-account', Auth::user()->id) }}" class="p-6" style="display: inline">
                                                        @csrf
                                                        @method('PATCH')
                                                    <button type="submit" class="btn btn-primary">Deactive</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('page-script')
    {!! Toastr::message() !!}
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
       