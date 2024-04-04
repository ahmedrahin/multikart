@extends('frontend.layout.template')

@section('page-title')
    <title>@if(isset($category)) {{ $category->name }} @elseif(isset($subCategory)) {{ $subCategory->name }} @endif || Multikart</title>
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
                        <h2>
                            @if(isset($category))
                                {{ $category->name }}
                            @elseif(isset($subCategory))
                                {{ $subCategory->name }}
                            @endif
                        </h2>
                    </div>
                </div>
                <div class="col-sm-6">
                    <nav aria-label="breadcrumb" class="theme-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">home</a></li>
                            <li class="breadcrumb-item"><a href="{{ url('/all-products') }}">All-Product</a></li>
                            <li class="breadcrumb-item active" aria-current="page">
                                @if(isset($category))
                                    {{ $category->name }}
                                @elseif(isset($subCategory))
                                    {{ $subCategory->name }}
                                @endif
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb end -->

    <!-- section start -->
    <section class="section-b-space ratio_asos">
        <div class="collection-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-sm-3 collection-filter">
                        @include('frontend.includes.shop-sidebar')
                    </div>

                    <div class="collection-content col">
                        <div class="page-main-content">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="top-banner-wrapper">
                                        <a href="#"><img src="{{asset('frontend/images/mega-menu/2.jpg')}}"
                                                class="img-fluid blur-up lazyload" alt=""></a>
                                        <div class="top-banner-content small-section">
                                            <h4>BIGGEST DEALS ON TOP BRANDS</h4>
                                            <p>The trick to choosing the best wear for yourself is to keep in mind your
                                                body type, individual style, occasion and also the time of day or
                                                weather.
                                                In addition to eye-catching products from top brands, we also offer an
                                                easy 30-day return and exchange policy, free and fast shipping across
                                                all pin codes, cash or card on delivery option, deals and discounts,
                                                among other perks. So, sign up now and shop for westarn wear to your
                                                heart’s content on Multikart. </p>
                                        </div>
                                    </div>
                                    <div class="collection-product-wrapper">
                                        <div class="product-top-filter">
                                            <div class="row">
                                                <div class="col-xl-12">
                                                    <div class="filter-main-btn">
                                                        <span class="filter-btn btn btn-theme">
                                                            <i class="fa fa-filter" aria-hidden="true"></i> Filter
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="product-filter-content">
                                                        <div class="search-count">
                                                            <h5 class="product-result">
                                                                Showing Products {{ $products->firstItem() }}-{{ $products->lastItem() }} of {{ $products->total() }} Results
                                                            </h5>
                                                        </div>
                                                        <div class="collection-view">
                                                            <ul>
                                                                <li><i class="fa fa-th grid-layout-view"></i></li>
                                                                <li><i class="fa fa-list-ul list-layout-view"></i></li>
                                                            </ul>
                                                        </div>

                                                        <div class="collection-grid-view">
                                                            <ul>
                                                                <li><img src="{{asset('frontend/images/icon/3.png')}}" alt=""
                                                                        class="product-3-layout-view"></li>
                                                                <li><img src="{{asset('frontend/images/icon/4.png')}}" alt=""
                                                                        class="product-4-layout-view"></li>
                                                            </ul>
                                                        </div>

                                                        <div class="product-page-per-view">
                                                            @php
                                                                $routeParam = isset($category) ? $category->slug : (isset($subCategory) ? $subCategory->slug : '');
                                                                $route = route('category-product', $routeParam);
                                                            @endphp
                                                            <form action="{{ $route }}" method="GET">
                                                                <form action="" method="GET">
                                                                <select name="perPage" id="perPage" onchange="this.form.submit()">
                                                                    <option value="20" {{ request('perPage') == 20 ? 'selected' : '' }}>20 Products Par Page</option>
                                                                    <option value="50" {{ request('perPage') == 50 ? 'selected' : '' }}>50 Products Par Page</option>
                                                                    <option value="100" {{ request('perPage') == 100 ? 'selected' : '' }}>100 Products Par Page</option>
                                                                </select>
                                                            </form>
                                                        </div>

                                                        <div class="product-page-filter">
                                                            @php
                                                                $routeParam = isset($category) ? $category->slug : (isset($subCategory) ? $subCategory->slug : '');
                                                                $route = route('category-product', $routeParam);
                                                            @endphp
                                                            <form action="{{ $route }}" method="GET">
                                                                <select name="sortItems" id="sortItems" onchange="this.form.submit()">
                                                                    <option value="menu_order" {{ request('sortItems') == "menu_order" ? 'selected' : '' }}>Sorting items</option>
                                                                    <option value="lowToHigh" {{ request('sortItems') == "lowToHigh" ? 'selected' : '' }}>Low to High Price</option>
                                                                    <option value="highToLow" {{ request('sortItems') == "highToLow" ? 'selected' : '' }}>High to Low Price</option>
                                                                </select>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        {{-- all prodcuts --}}
                                        <div class="product-wrapper-grid allProduct">
                                            <div class="row margin-res">
                                                @if( $products->count() != 0 )
                                                    @foreach($products as $product)
                                                        <div class="col-xl-3 col-6 col-grid-box">
                                                            <div class="product-box">
                                                                <div class="img-wrapper">
                                                                    @if(!is_null($product->thumb_image))
                                                                    <div class="front">
                                                                        <a href="{{ route('product-details', $product->slug) }}">
                                                                            <img src="{{asset('uploads/product/thumb_image/' . $product->thumb_image)}}" class="img-fluid blur-up lazyload bg-img" alt="">
                                                                        </a>
                                                                    </div>
                                                                    {{-- gallery image --}}
                                                                    @php
                                                                    $gallery = App\Models\ImageGallery::where('product_id', $product->id)->first();
                                                                    @endphp
                                                                    @if(!is_null($product->back_image))
                                                                    <div class="back">
                                                                        <a href="{{ route('product-details', $product->slug) }}">
                                                                            <img src="{{asset('uploads/product/back_image/' . $product->back_image)}}" class="img-fluid blur-up lazyload bg-img" alt="">
                                                                        </a>
                                                                    </div>
                                                                    @elseif(isset($gallery))
                                                                    <div class="back">
                                                                        <a href="{{ route('product-details', $product->slug) }}">
                                                                            <img src="{{asset($gallery->name)}}" class="img-fluid blur-up lazyload bg-img" alt="">
                                                                        </a>
                                                                    </div>
                                                                    @endif
                                                                    @else
                                                                    <div class="front">
                                                                        <a href="{{ route('product-details', $product->slug) }}">
                                                                            <img src="{{asset('frontend/images/null.jpg')}}" class="img-fluid blur-up lazyload bg-img" alt="">
                                                                        </a>
                                                                    </div>
                                                                    @endif

                                                                    <div class="cart-info cart-wrap">
                                                                        <button data-bs-toggle="modal" data-bs-target="#addtocart" title="Add to cart">
                                                                            <i class="ti-shopping-cart"></i>
                                                                        </button>
                                                                        <a href="javascript:void(0)" title="Add to Wishlist">
                                                                            <i class="ti-heart" aria-hidden="true"></i>
                                                                        </a>
                                                                        <a href="#" data-bs-toggle="modal" data-bs-target="#quick-view" title="Quick View">
                                                                            <i class="ti-search" aria-hidden="true"></i>
                                                                        </a>
                                                                        <a href="compare.html" title="Compare">
                                                                            <i class="ti-reload" aria-hidden="true"></i>
                                                                        </a>
                                                                    </div>

                                                                    {{-- show discount --}}
                                                                    @if(!is_null($product->offer_price))
                                                                    @php
                                                                    $regularPrice = $product->regular_price;
                                                                    $offerPrice = $product->offer_price;
                                                                    $discountPercentage = (($regularPrice - $offerPrice) / $regularPrice) * 100;
                                                                    @endphp
                                                                    <div class="discount">
                                                                        -{{ round($discountPercentage) }}%
                                                                    </div>
                                                                    @endif

                                                                </div>
                                                                <div class="product-detail">
                                                                    <div class="price_name">
                                                                        {{-- product review --}}
                                                                        @php
                                                                        $product_reviewDetails = App\Models\Product::with('review')->find($product->id);
                                                                        if ($product_reviewDetails) {
                                                                        $reviewsCount = $product_reviewDetails->review->count();
                                                                        $reviews = $product_reviewDetails->review;
                                                                        if ($reviews->count() > 0) {
                                                                            $averageRating = $reviews->avg('rating');
                                                                        } else {
                                                                            $averageRating = 0;
                                                                        }
                                                                        } else {
                                                                        $averageRating = 0;
                                                                        }
                                                                        @endphp
                                                                        @if(isset($averageRating) && ($averageRating) == 5)
                                                                        <div class="rating allStar">
                                                                            <i class="fa fa-star"></i>
                                                                            <i class="fa fa-star"></i>
                                                                            <i class="fa fa-star"></i>
                                                                            <i class="fa fa-star"></i>
                                                                            <i class="fa fa-star"></i>
                                                                        </div>
                                                                        @elseif(isset($averageRating) && ($averageRating >= 4.5) && ($averageRating <= 4.9))
                                                                        <div class="rating">
                                                                            <i class="fa fa-star"></i>
                                                                            <i class="fa fa-star"></i>
                                                                            <i class="fa fa-star"></i>
                                                                            <i class="fa fa-star"></i>
                                                                            <i class="fa fa-star-half-o noteqaul" aria-hidden="true"></i>
                                                                        </div>
                                                                        @elseif(isset($averageRating) && ($averageRating >= 4) && ($averageRating <= 4.4))
                                                                        <div class="rating">
                                                                            <i class="fa fa-star"></i>
                                                                            <i class="fa fa-star"></i>
                                                                            <i class="fa fa-star"></i>
                                                                            <i class="fa fa-star"></i>
                                                                            <i class="fa fa-star norating"></i>
                                                                        </div>
                                                                        @elseif(isset($averageRating) && ($averageRating >= 3.5) && ($averageRating <= 3.9))
                                                                        <div class="rating">
                                                                            <i class="fa fa-star"></i>
                                                                            <i class="fa fa-star"></i>
                                                                            <i class="fa fa-star"></i>
                                                                            <i class="fa fa-star-half-o noteqaul" aria-hidden="true"></i>
                                                                            <i class="fa fa-star norating"></i>
                                                                        </div>
                                                                        @elseif(isset($averageRating) && ($averageRating >= 3) && ($averageRating <= 3.4))
                                                                        <div class="rating">
                                                                            <i class="fa fa-star"></i>
                                                                            <i class="fa fa-star"></i>
                                                                            <i class="fa fa-star"></i>
                                                                            <i class="fa fa-star norating"></i>
                                                                            <i class="fa fa-star norating"></i>
                                                                        </div>
                                                                        @elseif(isset($averageRating) && ($averageRating >= 2.5) && ($averageRating <= 2.9))
                                                                        <div class="rating">
                                                                            <i class="fa fa-star"></i>
                                                                            <i class="fa fa-star"></i>
                                                                            <i class="fa fa-star-half-o noteqaul" aria-hidden="true"></i>
                                                                            <i class="fa fa-star norating"></i>
                                                                            <i class="fa fa-star norating"></i>
                                                                        </div>
                                                                        @elseif(isset($averageRating) && ($averageRating >= 2) && ($averageRating <= 2.4))
                                                                        <div class="rating">
                                                                            <i class="fa fa-star"></i>
                                                                            <i class="fa fa-star"></i>
                                                                            <i class="fa fa-star norating"></i>
                                                                            <i class="fa fa-star norating"></i>
                                                                            <i class="fa fa-star norating"></i>
                                                                        </div>
                                                                        @elseif(isset($averageRating) && ($averageRating >= 1.5) && ($averageRating <= 1.9))
                                                                        <div class="rating">
                                                                            <i class="fa fa-star"></i>
                                                                            <i class="fa fa-star-half-o noteqaul" aria-hidden="true"></i>
                                                                            <i class="fa fa-star norating"></i>
                                                                            <i class="fa fa-star norating"></i>
                                                                            <i class="fa fa-star norating"></i>
                                                                        </div>
                                                                        @elseif(isset($averageRating) && ($averageRating >= 1) && ($averageRating <= 1.4))
                                                                        <div class="rating">
                                                                            <i class="fa fa-star"></i>
                                                                            <i class="fa fa-star norating"></i>
                                                                            <i class="fa fa-star norating"></i>
                                                                            <i class="fa fa-star norating"></i>
                                                                            <i class="fa fa-star norating"></i>
                                                                        </div>
                                                                        @elseif(isset($averageRating) && ($averageRating >= 0.1) && ($averageRating <= 0.9))
                                                                        <div class="rating">
                                                                            <i class="fa fa-star-half-o noteqaul" aria-hidden="true"></i>
                                                                            <i class="fa fa-star norating"></i>
                                                                            <i class="fa fa-star norating"></i>
                                                                            <i class="fa fa-star norating"></i>
                                                                            <i class="fa fa-star norating"></i>
                                                                        </div>
                                                                        @else
                                                                        <div class="rating">
                                                                            <i class="fa fa-star norating"></i>
                                                                            <i class="fa fa-star norating"></i>
                                                                            <i class="fa fa-star norating"></i>
                                                                            <i class="fa fa-star norating"></i>
                                                                            <i class="fa fa-star norating"></i>
                                                                        </div>
                                                                        @endif

                                                                        <a href="{{ route('product-details', $product->slug) }}">
                                                                            <h6>{{ $product->title }}</h6>
                                                                        </a>

                                                                        @if($product->ProductAttribute->count() > 0)
                                                                        @php
                                                                        // Initialize an array to hold all prices including variation prices and the default regular price
                                                                        $allPrices = $product->ProductAttribute->pluck('regular_price')->toArray();

                                                                        $allPrices[] = $product->regular_price;

                                                                        if (!is_null($product->offer_price) && !empty($allPrices)) {
                                                                            $allPrices[] = $product->offer_price;
                                                                        }
                                                                        $allPrices = array_filter($allPrices);

                                                                        // Calculate the variation price
                                                                        if (empty($allPrices)) {
                                                                            $variationPrice = "৳" . $product->regular_price;
                                                                        } else {
                                                                            // Determine the minimum and maximum prices
                                                                            $minPrice = min($allPrices);
                                                                            $maxPrice = max($allPrices);

                                                                            // Format the variation price
                                                                            if ($minPrice === $maxPrice) {
                                                                                $variationPrice = "৳" . $minPrice;
                                                                            } else {
                                                                                $variationPrice = "৳" . $minPrice . " - ৳" . $maxPrice;
                                                                            }
                                                                        }
                                                                        @endphp

                                                                        <h4>{{ $variationPrice }}</h4>
                                                                        @else
                                                                        @if (!is_null($product->offer_price))
                                                                        <h4>৳{{ $product->offer_price }} <span class="old-price"><del>৳{{$product->regular_price}}</del></span> </h4>
                                                                        @else
                                                                        <h4>৳{{ $product->regular_price }}</h4>
                                                                        @endif
                                                                        @endif

                                                                    </div>
                                                                    <form action="{{ route('add-to-cart') }}" method="POST" name="cartForm" class="cartForm">
                                                                        @csrf
                                                                        <input type="hidden" name="quantity" value="{{ ($product->quantity == 0) ? '0' : '1' }}">
                                                                        <input type="hidden" name="productId" value="{{$product->id}}">

                                                                        {{-- product attribute --}}
                                                                        @if(($product->ProductAttribute->count() > 0))
                                                                            <a href="{{ route('product-details', $product->slug) }}" class="btn btn-solid hover-solid btn-animation btnAddto">
                                                                                <i class="fa fa-shopping-cart me-1" aria-hidden="true"></i>
                                                                                Select Option
                                                                            </a>
                                                                        @else
                                                                            @if($product->quantity != 0)
                                                                                <button class="btn btn-solid hover-solid btn-animation btnAddto btnAddtoCart" type="button">
                                                                                    <i class="fa fa-shopping-cart me-1" aria-hidden="true"></i>
                                                                                    Add to cart
                                                                                </button>
                                                                            @else
                                                                                <button class="btn btn-solid hover-solid btnAddto notAvailble">
                                                                                    <i class="fa fa-times" aria-hidden="true"></i>
                                                                                    Not Available!
                                                                                </button>
                                                                            @endif
                                                                        @endif
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @else
                                                <div class="bg bg-warning">Sorry!! No Product Found</div>
                                                @endif
                                            </div>
                                        </div>

                                        {{-- pagination --}}
                                        <div class="product-pagination">
                                            <div class="theme-paggination-block">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        @php 
                                                            $totalPages = ceil($products->total() / $products->perPage());
                                                        @endphp
                                                        @if( $totalPages > 1 )
                                                             {{ $products->appends(['brands' => $q_brands])->links() }}
                                                        @else
                                                        <nav aria-label="Page navigation">
                                                            <ul class="pagination static-pagination">
                                                                <li class="page-item">
                                                                    <a class="page-link" href="javascript:;" aria-label="Previous" disabled>
                                                                        <span aria-hidden="true">
                                                                            <i class="fa fa-chevron-left" aria-hidden="true"></i>
                                                                        </span> <span class="sr-only">Previous</span>
                                                                    </a>
                                                                </li>
                                                                <li class="page-item active">
                                                                    <a class="page-link" href="javascript:;" disabled>1</a>
                                                                </li>
                                                                <li class="page-item">
                                                                    <a class="page-link" href="javascript:;" aria-label="Next" disabled>
                                                                        <span aria-hidden="true">
                                                                            <i class="fa fa-chevron-right" aria-hidden="true"></i></span> <span class="sr-only">Next
                                                                        </span>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </nav>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="product-search-count-bottom">
                                                            <h5>
                                                                <!-- Show the range of products being displayed -->
                                                                Showing Products {{ $products->firstItem() }}-{{ $products->lastItem() }} of {{ $products->total() }} Results
                                                            </h5>
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
    <!-- section End -->
@endsection

@section('page-script')
    
@endsection
   

