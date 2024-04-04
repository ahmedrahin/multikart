@extends('frontend.layout.template')

@section('page-title')
    <title> {{ $product_detail->title }} || Multikart</title>
@endsection

@section('page-css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
@endsection

@section('body-content')

    <!-- breadcrumb start -->
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="page-title">
                        <h2>product details</h2>
                    </div>
                </div>
                <div class="col-sm-6">
                    <nav aria-label="breadcrumb" class="theme-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ url('/all-products') }}">All Product</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $product_detail->slug }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb End -->


    <!-- section start -->
    <section>
        <div class="collection-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        {{-- product image slider --}}
                        <div class="product-slick">
                            @if( !is_null( $product_detail->thumb_image ) )
                                <div>
                                    <img src="{{asset('uploads/product/thumb_image/' . $product_detail->thumb_image )}}" alt="" class="img-fluid blur-up lazyload" id="NZoomImg" data-NZoomscale="2">
                                </div>
                            @else
                                <div>
                                    <img src="{{asset('frontend/images/null.jpg')}}" alt="" class="img-fluid blur-up lazyload ">
                                </div>
                            @endif
                            @php
                                $gallery = App\Models\ImageGallery::where('product_id', $product_detail->id)->get();
                            @endphp
                            @if( $gallery->count() > 0 )
                                @foreach( $gallery as $gallery_img )
                                    <div>
                                        <img src="{{asset($gallery_img->name)}}" alt="" class="img-fluid blur-up lazyload ">
                                    </div>
                                @endforeach
                            @endif
                        </div>

                        {{-- thumbnail & gallery image --}}
                        <div class="row">
                            <div class="col-12 p-0">
                                <div class="slider-nav">
                                    @if( !is_null( $product_detail->thumb_image ) )
                                        <img src="{{asset('uploads/product/thumb_image/' . $product_detail->thumb_image )}}" alt="" class="img-fluid blur-up lazyload">
                                    @else
                                        <img src="{{asset('frontend/images/null.jpg')}}" alt="" class="img-fluid blur-up lazyload">
                                    @endif
                                    @if( $gallery->count() > 0 )
                                        @foreach( $gallery as $gallery_nav )
                                            <div>
                                                <img src="{{asset($gallery_nav->name)}}" alt="" class="img-fluid blur-up lazyload">
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 rtl-text">
                        <div class="product-right">
                            {{-- top details --}}
                            <div class="product-count">
                                <ul>
                                    <li>
                                        <span>
                                            <i class="fa fa-shopping-bag" aria-hidden="true"></i>
                                            Total Orders: 
                                            {{ App\Models\Cart::whereNotNull('order_id')->where('product_id', $product_detail->id)->count() }}
                                        </span>
                                    </li>
                                    <li>
                                        <span>
                                            <i class="fa fa-heart" aria-hidden="true"></i>
                                            Active Wishlists: 
                                            {{ App\Models\Wishlist::where('product_id', $product_detail->id)->count() }}
                                        </span>
                                    </li>
                                    @if( isset($product_detail->brand_id) && !is_null( $product_detail->brand_id ) && !($product_detail->brand_id == 0) )
                                        <li>
                                            <span>
                                                <i class="fa fa-check-square-o" aria-hidden="true"></i>
                                                Brand: 
                                                {{ isset($product_detail->brand) ? $product_detail->brand->name : '' }}
                                            </span>
                                        </li>
                                    @endif
                                </ul>
                            </div>

                            <h2>{{ $product_detail->title }}</h2>
                            @php
                                $product_reviewDetails = App\Models\Product::with('review')->find($product_detail->id);
                                if ($product_reviewDetails) {
                                    $reviewsCount = $product_reviewDetails->review->count();
                                    $reviews = $product_reviewDetails->review;
                                    if ($reviews->count() > 0) {
                                        // Calculate the average rating
                                        $averageRating = ($reviews->avg('rating'));
                                    } 
                                }
                            @endphp
                            <div class="rating-section">
                                @if( isset($averageRating) && ($averageRating) == 5 )
                                    <div class="rating allStar">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                    </div>
                                @elseif( isset($averageRating) && ($averageRating >= 4.5) && ($averageRating <= 4.9))
                                    <div class="rating">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star-half-o noteqaul" aria-hidden="true"></i>
                                    </div>
                                @elseif( isset($averageRating) && ($averageRating >= 4) && ($averageRating <= 4.4) )
                                    <div class="rating">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star norating"></i>
                                    </div>
                                @elseif( isset($averageRating) && ($averageRating >= 3.5) && ($averageRating <= 3.9) )
                                    <div class="rating">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star-half-o noteqaul" aria-hidden="true"></i>
                                        <i class="fa fa-star norating"></i>
                                    </div>
                                @elseif( isset($averageRating) && ($averageRating >= 3) && ($averageRating <= 3.4) )
                                    <div class="rating">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star norating"></i>
                                        <i class="fa fa-star norating"></i>
                                    </div>
                                @elseif( isset($averageRating) && ($averageRating >= 2.5) && ($averageRating <= 2.9) )
                                    <div class="rating">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star-half-o noteqaul" aria-hidden="true"></i>
                                        <i class="fa fa-star norating"></i>
                                        <i class="fa fa-star norating"></i>
                                    </div>
                                @elseif( isset($averageRating) && ($averageRating >= 2) && ($averageRating <= 2.4) )
                                    <div class="rating">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star norating"></i>
                                        <i class="fa fa-star norating"></i>
                                        <i class="fa fa-star norating"></i>
                                    </div>
                                @elseif( isset($averageRating) && ($averageRating >= 1.5) && ($averageRating <= 1.9) )
                                    <div class="rating">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star-half-o noteqaul" aria-hidden="true"></i>
                                        <i class="fa fa-star norating"></i>
                                        <i class="fa fa-star norating"></i>
                                        <i class="fa fa-star norating"></i>
                                    </div>
                                @elseif( isset($averageRating) && ($averageRating >= 1) && ($averageRating <= 1.4) )
                                    <div class="rating">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star norating"></i>
                                        <i class="fa fa-star norating"></i>
                                        <i class="fa fa-star norating"></i>
                                        <i class="fa fa-star norating"></i>
                                    </div>
                                @elseif( isset($averageRating) && ($averageRating >= 0.1) && ($averageRating <= 0.9) )
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

                                <h6>{{ $reviewsCount }} Reviews</h6>
                                @if(isset($product_detail->brand_id) && !is_null($product_detail->brand_id))
                                    <div class="brand-img">
                                        @if(!is_null($product_detail->brand) && !is_null($product_detail->brand->image))
                                            <img src="{{ asset('uploads/brands/' . $product_detail->brand->image) }}" alt="" title="brand logo">
                                        @endif
                                    </div>
                                @endif
                            </div>
                            
                            {{-- product category --}}
                            <div class="label-section">
                                <span class="category">Category:</span>
                                <span class="label-text" style="color: #ff4c3b;font-weight: 500;text-transform:capitalize;">
                                   @if( isset($product_detail->category) ) 
                                        @if( $product_detail->category->status == 1 )
                                            {{ $product_detail->category->name }}
                                        @else
                                            Uncategorize
                                        @endif
                                        @else
                                           Uncategorize
                                    @endif  

                                    @if( isset($product_detail->category) ) 
                                        @if( $product_detail->category->status == 1 ) 
                                            @if( isset($product_detail->subCategory) ) 
                                                @if( $product_detail->subCategory->status == 1)
                                                    / {{ $product_detail->subCategory->name }}
                                                @else
                                                    / Uncategorize
                                                @endif   
                                                @else
                                                    / Uncategorize
                                            @endif
                                        @endif
                                    @endif 
                                   
                                </span>
                            </div>

                            {{-- product price --}}
                            @if( !is_null( $product_detail->offer_price ) )
                                @php
                                    $regularPrice       = $product_detail->regular_price;
                                    $offerPrice         = $product_detail->offer_price;
                                    $discountPercentage = (($regularPrice - $offerPrice) / $regularPrice) * 100;
                                @endphp
                                <h3 class="price-detail">৳{{ $product_detail->offer_price }}
                                    <del>৳{{ $product_detail->regular_price }}</del>
                                    <span>{{ round($discountPercentage) }}% off</span>
                                </h3>
                            @else
                                <h3 class="price-detail">৳{{ $product_detail->regular_price }}</h3>
                            @endif

                            <form id="AddCartForm" name="cartForm">

                                {{-- product variation --}}
                                @php
                                    $attrs = $product_detail->ProductAttribute;
                                @endphp

                                @if ($attrs->count() > 0)
                                    @php
                                        $uniqueVariationIds = $attrs->pluck('variation_id')->unique()->sort();
                                    @endphp

                                    @foreach ($uniqueVariationIds as $variationId)
                                        @php
                                            $attr = $attrs->where('variation_id', $variationId)->first();
                                            $variationValues = $attrs->where('variation_id', $variationId)->pluck('value_id');
                                        @endphp
                                        @if ($attr->ProductVariation->var_name == "Color" || $attr->ProductVariation->var_name == "color")
                                            <div class="border-product">
                                                <h6 class="product-title size-text mb-2"><span>select {{ $attr->ProductVariation->var_name }} <span></h6>
                                                <ul class="color-variant variationItem">
                                                    @foreach ($variationValues as $valueId)
                                                        @php
                                                            $variationValue = App\Models\VariationValue::find($valueId);
                                                        @endphp
                                                        @if( $variationValue->option_value != null )
                                                            <li class="bg-light hasColor" style="background-color:{{$variationValue->option_value}} !important">
                                                                <input type="radio" name="p_attr" id="{{$variationValue->id}}" class="VariationId" value="{{$variationValue->option}}">
                                                            </li>
                                                        @else
                                                            <li class="no-color">
                                                                <div>
                                                                    <input type="radio" name="p_attr" id="{{$variationValue->id}}" class="VariationId" value="{{$variationValue->option}}">
                                                                    <label for="attr{{$variationValue->id}}" class="attrColor">{{$variationValue->option}}</label>
                                                                </div>
                                                            </li>
                                                        @endif
                                                    @endforeach
                                                    <div class="clear">
                                                        &times; Clear
                                                    </div>
                                                </ul>
                                            </div>
                                        @else
                                            <div id="selectSize" class="addeffect-section product-description border-product">
                                                <h6 class="product-title size-text">select {{ $attr->ProductVariation->var_name }}</h6>
                                                <h6 class="error-message">please select {{ $attr->ProductVariation->var_name }}</h6>
                                                <div class="size-box">
                                                    <ul class="selected variationItem">
                                                        @foreach ($variationValues as $valueId)
                                                            @php
                                                                $variationValue = App\Models\VariationValue::find($valueId);
                                                            @endphp
                                                            <li>
                                                                <a href="javascript:void(0)">{{$variationValue->option}}</a>
                                                                <input type="radio" name="size" id="{{$variationValue->id}}" class="VariationId" value="{{$variationValue->option}}">
                                                            </li>
                                                        @endforeach
                                                        <div class="clear">
                                                            &times; Clear
                                                        </div>
                                                    </ul>
                                                </div>  
                                            </div>
                                        @endif
                                    @endforeach
                                @else
                                    <span class="" style="visibility: hidden">No variation</span>
                                @endif

                                <div class="product-buttons">
                                        @csrf
                                        <h6 class="product-title">quantity</h6>
                                        <div class="qty-box">
                                            <div class="input-group">
                                                <span class="input-group-prepend">
                                                    <button type="button" class="btn quantity-left-minus" data-type="minus" data-field="">
                                                        <i class="ti-angle-left"></i>
                                                    </button> 
                                                </span>
                                                <input type="text" name="quantity" class="form-control input-number qty-input" value="{{ ($product_detail->quantity == 0) ? '0' : '1' }}" {{ ($product_detail->quantity == 0) ? 'disabled' : '' }}>
                                                <input type="hidden" id="totalQuant" value="{{$product_detail->quantity}}">
                                                <span class="input-group-prepend">
                                                    <button type="button" class="btn quantity-right-plus " data-type="plus" data-field="">                                           <i class="ti-angle-right"></i>
                                                    </button>
                                                </span>

                                            </div>
                                        </div>

                                        @if( $product_detail->quantity != 0 )
                                            <h4 class="stock text-success">Stock Quantity: <span class="availble stock text-success">{{ $product_detail->quantity }}</span> Psc</h4>
                                        @else
                                            <h4 class="stock text-danger">Out of Stock!</h4>
                                        @endif  

                                        <div class="buyNowBeforesend" style="display: inline;">
                                            <button id="cartEffect" class="btn btn-solid hover-solid btn-animation " type="submit">
                                                <i class="fa fa-shopping-cart me-1" aria-hidden="true"></i> 
                                                Buy Now
                                            </button>
                                        </div>
                                        
                                        <input type="hidden" name="productId" id="" value="{{ $product_detail->id }}">
                                    </form>

                                    {{-- wishlist button --}}
                                    <div class="wishlist-form" style="display: inline">
                                        <form action="{{ route('store-wishlist') }}" method="POST" class="wishlistForm" style="margin-left: -3px;">
                                            @csrf
                                            <div class="wishlistBeforesend">
                                                @if (isset($wishlist_detail))
                                                    @if ($product_detail->id != $wishlist_detail->product_id)
                                                        <button class="btn btn-solid btnAddWs" type="button" style="padding: 8px 25px;margin-left: 13px;">
                                                            <i class="fa fa-bookmark fz-16 me-2" aria-hidden="true"></i>
                                                            wishlist
                                                        </button>
                                                    @else
                                                        <button type="button" class="btn btn-solid" id="existWishlist" style="padding: 8px 25px;margin-left: 13px;">
                                                            <i class="fa fa-bookmark fz-16 me-2" aria-hidden="true"></i>
                                                            wishlist
                                                        </button>
                                                    @endif
                                                @else
                                                    <button class="btn btn-solid btnAddWs" type="button" style="padding: 8px 25px;margin-left: 13px;">
                                                        <i class="fa fa-bookmark fz-16 me-2" aria-hidden="true"></i>
                                                        wishlist
                                                    </button>
                                                @endif
                                            </div>
                                            
    
                                            <input type="hidden" name="productId" id="" value="{{ $product_detail->id }}">
                                        </form>
                                    </div>
                                    
                                </div>

                                <div class="product-count">
                                    <ul>
                                        <li>
                                            <img src="{{asset('frontend/images/icon/truck.png')}}" class="img-fluid" alt="image">
                                            <span class="lang">Free shipping for orders above $500 USD</span>
                                        </li>
                                    </ul>
                                </div>

                                @if( !is_null( $product_detail->short_details ) )
                                    <div class="border-product">
                                        <h6 class="product-title">Short Details</h6>
                                        <div class="timer">
                                            <p id="demo">
                                                @php
                                                    echo $product_detail->short_details;
                                                @endphp
                                            </p>
                                        </div>
                                    </div>
                                @endif
                                <div class="border-product">
                                    <h6 class="product-title">shipping info</h6>
                                    <ul class="shipping-info">
                                        <li>100% Original Products</li>
                                        <li>Free Delivery on order above Rs. 799</li>
                                        <li>Pay on delivery is available</li>
                                        <li>Easy 30 days returns and exchanges</li>
                                    </ul>
                                </div>
                                <div class="border-product">
                                    <h6 class="product-title">share it</h6>
                                    <div class="product-icon">
                                        <ul class="product-social">
                                            <li><a href="#"><i class="fa fa-facebook-f"></i></a></li>
                                            <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                                            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                            <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                                            <li><a href="#"><i class="fa fa-rss"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Section ends -->

    <!-- product-tab starts -->
    <section class="tab-product m-0">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-lg-12">
                    <ul class="nav nav-tabs nav-material" id="top-tab" role="tablist">
                        <li class="nav-item"><a class="nav-link active" id="top-home-tab" data-bs-toggle="tab"
                                href="#top-home" role="tab" aria-selected="true"><i
                                    class="icofont icofont-ui-home"></i>Details</a>
                            <div class="material-border"></div>
                        </li>
                        <li class="nav-item"><a class="nav-link" id="profile-top-tab" data-bs-toggle="tab"
                                href="#top-profile" role="tab" aria-selected="false"><i
                                    class="icofont icofont-man-in-glasses"></i>Specification</a>
                            <div class="material-border"></div>
                        </li>
                        <li class="nav-item"><a class="nav-link" id="contact-top-tab" data-bs-toggle="tab"
                                href="#top-contact" role="tab" aria-selected="false"><i
                                    class="icofont icofont-contacts"></i>Video</a>
                            <div class="material-border"></div>
                        </li>
                        <li class="nav-item"><a class="nav-link" id="review-top-tab" data-bs-toggle="tab"
                                href="#top-reviews-item" role="tab" aria-selected="false"><i
                                    class="icofont icofont-contacts"></i>Write Review</a>
                            <div class="material-border"></div>
                        </li>
                    </ul>
                    <div class="tab-content nav-material" id="top-tabContent">
                        <div class="tab-pane fade show active" id="top-home" role="tabpanel"
                            aria-labelledby="top-home-tab">
                            <div class="product-tab-discription">
                                @if( !is_null($product_detail->long_details) )
                                    @php
                                        echo $product_detail->long_details;
                                    @endphp
                                @else
                                    <h3 class="no-found">No description found in this product!</h3>
                                @endif
                            </div>
                        </div>
                        <div class="tab-pane fade" id="top-profile" role="tabpanel" aria-labelledby="profile-top-tab">
                            <p>The Model is wearing a white blouse from our stylist's collection, see the image for a
                                mock-up of what the actual blouse would look like.it has text written on it in a black
                                cursive language which looks great on a white color.</p>
                            <div class="single-product-tables">
                                <table>
                                    <tbody>
                                        <tr>
                                            <td>Sleeve Length</td>
                                            <td>Sleevless</td>
                                        </tr>
                                        <tr>
                                            <td>Neck</td>
                                            <td>Round Neck</td>
                                        </tr>
                                        <tr>
                                            <td>Occasion</td>
                                            <td>Sports</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table>
                                    <tbody>
                                        <tr>
                                            <td>Fabric</td>
                                            <td>Polyester</td>
                                        </tr>
                                        <tr>
                                            <td>Fit</td>
                                            <td>Regular Fit</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="top-contact" role="tabpanel" aria-labelledby="contact-top-tab">
                            <div class="">
                            @if( !is_null( $product_detail->video_link ) )
                                @php
                                    $video_url = $product_detail->video_link;

                                    // Check if the URL contains "youtu.be" or "youtube.com"
                                    if (strpos($video_url, 'youtu.be') !== false) {
                                        $convert_url = str_replace("https://youtu.be", "https://www.youtube.com/embed", $video_url);
                                    } 
                                    elseif (strpos($video_url, 'watch?v=') !== false) {
                                        $convert_url = str_replace("watch?v=", "embed/", $video_url);
                                    } 
                                    else {
                                        $convert_url = null;
                                    }
                                @endphp

                                @if (!is_null($convert_url))
                                    <iframe src="@php echo $convert_url; @endphp" title="Video" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                                @else
                                    <h3 class="no-found" style="color: #ff0000b5;">Invalid YouTube video link!</h3>
                                @endif
                            @else
                                <h3 class="no-found">No video found in this product!</h3>
                            @endif
                            </div>
                        </div>

                        <div class="tab-pane fade" id="top-reviews-item" role="tabpanel" aria-labelledby="review-top-tab">
                            <div id="top-review">
                                @if( Auth::check() )
                                    @php
                                        $product_review = App\Models\Review::where('product_id', $product_detail->id)->where('user_id', Auth::user()->id)->first();
                                    @endphp
                                    @if( !(isset($product_review)) )
                                        <form action="{{ route('review-store') }}" method="post" class="theme-form" name="reviewForm">
                                            @csrf
                                            <h3>Leave a review</h3>
                                            <div class="form-row row">
                                                <div class="col-md-12">
                                                    <div class="media mb-1">
                                                        <label>Rating:</label>
                                                        <div class="media-body ms-3">
                                                            <fieldset class="rating">
                                                                <input type="radio" id="star5" name="rating" value="5" /><label class = "full" for="star5" title="5 stars"></label>
                                                                <input type="radio" id="star4half" name="rating" value="4.5" /><label class="half" for="star4half" title="4.5 stars"></label>
                                                                <input type="radio" id="star4" name="rating" value="4" /><label class = "full" for="star4" title="4 stars"></label>
                                                                <input type="radio" id="star3half" name="rating" value="3.5" /><label class="half" for="star3half" title="3.5 stars"></label>
                                                                <input type="radio" id="star3" name="rating" value="3" /><label class = "full" for="star3" title="3 stars"></label>
                                                                <input type="radio" id="star2half" name="rating" value="2.5" /><label class="half" for="star2half" title="2.5 stars"></label>
                                                                <input type="radio" id="star2" name="rating" value="2" /><label class = "full" for="star2" title="2 stars"></label>
                                                                <input type="radio" id="star1half" name="rating" value="1.5" /><label class="half" for="star1half" title="1.5 stars"></label>
                                                                <input type="radio" id="star1" name="rating" value="1" /><label class = "full" for="star1" title="1 star"></label>
                                                                <input type="radio" id="starhalf" name="rating" value="0.5" /><label class="half" for="starhalf" title="0.5 stars"></label>
                                                                <input type="radio" class="reset-option" name="rating" value="reset" />
                                                            </fieldset>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <label for="review">Write Review:</label>
                                                    <textarea class="form-control" placeholder="Wrire Your Testimonial Here.."
                                                        id="review" name="review" rows="6"></textarea>
                                                        @error('review')
                                                            <div class="text-danger">{{$message}}</div>
                                                        @enderror
                                                </div>
                                                <div class="col-md-12">
                                                    <input type="hidden" name="productId" value="{{ $product_detail->id }}">
                                                    <button class="btn btn-solid" name="submit" type="submit">
                                                        Submit YOur Review
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    @else
                                        <div class="user-review">
                                            <h4>You already submited your review for this product</h4>
                                            <p>Your Rating: 
                                                @if( $product_review->rating == 5 )
                                                    <div class="rating fiveStar">
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                    </div>
                                                @elseif( $product_review->rating == 4.5 )
                                                    <div class="rating">
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star-half-o noteqaul" aria-hidden="true"></i>
                                                    </div>
                                                @elseif( $product_review->rating == 4 )
                                                    <div class="rating">
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star norating"></i>
                                                    </div>
                                                @elseif( $product_review->rating == 3.5 )
                                                    <div class="rating">
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star-half-o noteqaul" aria-hidden="true"></i>
                                                        <i class="fa fa-star norating"></i>
                                                    </div>
                                                @elseif( $product_review->rating == 3 )
                                                    <div class="rating">
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star norating"></i>
                                                        <i class="fa fa-star norating"></i>
                                                    </div>
                                                @elseif( $product_review->rating == 2.5 )
                                                    <div class="rating">
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star-half-o noteqaul" aria-hidden="true"></i>
                                                        <i class="fa fa-star norating"></i>
                                                        <i class="fa fa-star norating"></i>
                                                    </div>
                                                @elseif( $product_review->rating == 2 )
                                                    <div class="rating">
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star norating"></i>
                                                        <i class="fa fa-star norating"></i>
                                                        <i class="fa fa-star norating"></i>
                                                    </div>
                                                @elseif( $product_review->rating == 1.5 )
                                                    <div class="rating">
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star-half-o noteqaul" aria-hidden="true"></i>
                                                        <i class="fa fa-star norating"></i>
                                                        <i class="fa fa-star norating"></i>
                                                        <i class="fa fa-star norating"></i>
                                                    </div>
                                                @elseif( $product_review->rating == 1 )
                                                    <div class="rating">
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star norating"></i>
                                                        <i class="fa fa-star norating"></i>
                                                        <i class="fa fa-star norating"></i>
                                                        <i class="fa fa-star norating"></i>
                                                    </div>
                                                @elseif( $product_review->rating == 0.5 )
                                                    <div class="rating">
                                                        <i class="fa fa-star-half-o noteqaul" aria-hidden="true"></i>
                                                        <i class="fa fa-star norating"></i>
                                                        <i class="fa fa-star norating"></i>
                                                        <i class="fa fa-star norating"></i>
                                                        <i class="fa fa-star norating"></i>
                                                    </div>
                                                @endif
                                                {{ $product_review->rating }} Star
                                            </p>
                                            <div></div>
                                            <p>
                                                Your Review:
                                            </p>
                                            <span>{{ $product_review->review }}</span>
                                        </div>
                                    @endif
                                @else
                                    <div class="alert alert-warning">
                                        You must be login before review! <a href="{{ route('login') }}">Please Login.</a>
                                    </div>
                                @endif
                            </div>
                            {{-- previous review --}}
                            @if( $reviews->count() != 0 )
                                <div class="customer-review">
                                    <h3>Customer's Reviews</h3>
                                    @foreach( $reviews as $review )
                                        <div class="allReview">
                                            <ul>
                                                <li>
                                                    @if( !is_null($review->user->image) )
                                                        <img src="{{ asset('uploads/user/' . $review->user->image) }}" alt="">
                                                    @else
                                                        <img src="{{ asset('uploads/images/default.jpg') }}" alt="">
                                                    @endif
                                                </li>
                                                <li class="messageItem">
                                                    <span>{{ $review->user->name }}</span>
                                                    <p>{{ $review->review }}</p>
                                                    @if( $review->rating == 5 )
                                                        <div class="rating fiveStar">
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                        </div>
                                                    @elseif( $review->rating == 4.5 )
                                                        <div class="rating">
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star-half-o noteqaul" aria-hidden="true"></i>
                                                        </div>
                                                    @elseif( $review->rating == 4 )
                                                        <div class="rating">
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star norating"></i>
                                                        </div>
                                                    @elseif( $review->rating == 3.5 )
                                                        <div class="rating">
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star-half-o noteqaul" aria-hidden="true"></i>
                                                            <i class="fa fa-star norating"></i>
                                                        </div>
                                                    @elseif( $review->rating == 3 )
                                                        <div class="rating">
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star norating"></i>
                                                            <i class="fa fa-star norating"></i>
                                                        </div>
                                                    @elseif( $review->rating == 2.5 )
                                                        <div class="rating">
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star-half-o noteqaul" aria-hidden="true"></i>
                                                            <i class="fa fa-star norating"></i>
                                                            <i class="fa fa-star norating"></i>
                                                        </div>
                                                    @elseif( $review->rating == 2 )
                                                        <div class="rating">
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star norating"></i>
                                                            <i class="fa fa-star norating"></i>
                                                            <i class="fa fa-star norating"></i>
                                                        </div>
                                                    @elseif( $review->rating == 1.5 )
                                                        <div class="rating">
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star-half-o noteqaul" aria-hidden="true"></i>
                                                            <i class="fa fa-star norating"></i>
                                                            <i class="fa fa-star norating"></i>
                                                            <i class="fa fa-star norating"></i>
                                                        </div>
                                                    @elseif( $review->rating == 1 )
                                                        <div class="rating">
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star norating"></i>
                                                            <i class="fa fa-star norating"></i>
                                                            <i class="fa fa-star norating"></i>
                                                            <i class="fa fa-star norating"></i>
                                                        </div>
                                                    @elseif( $review->rating == 0.5 )
                                                        <div class="rating">
                                                            <i class="fa fa-star-half-o noteqaul" aria-hidden="true"></i>
                                                            <i class="fa fa-star norating"></i>
                                                            <i class="fa fa-star norating"></i>
                                                            <i class="fa fa-star norating"></i>
                                                            <i class="fa fa-star norating"></i>
                                                        </div>
                                                    @endif
                                                </li>
                                            </ul>
                                            
                                        </div>
                                    @endforeach
                                </div>
                            @else
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- product-tab ends -->

    <!-- releted product section start -->
    <section class="section-b-space ratio_asos">
        <div class="container">
            <div class="row">
                <div class="col-12 product-related">
                    <h2>related products</h2>
                </div>
            </div>
            <div class="row related-product">
                @php
                    $related_product = App\Models\Product::where('category_id', $product_detail->category_id )->where('subCategory_id', $product_detail->subCategory_id)->where('id', '!=', $product_detail->id)->where('status', 1)->get() ;
                @endphp
                @if( $related_product->count() > 0 )
                    @if($related_product->count() > 6)
                        <div class="feature-slider product-slider row g-3">
                    @endif

                    @foreach( $related_product as $product )
                        <div class="col-md-2 col-lg-2 col-6 col-grid-box">
                            <div class="product-box">
                                <div class="img-wrapper">
                                    @if( !is_null($product->thumb_image) )
                                        <div class="front">
                                            <a href="{{ route('product-details', $product->slug) }}">
                                                <img src="{{asset('uploads/product/thumb_image/' . $product->thumb_image )}}" class="img-fluid blur-up lazyload bg-img" alt="">
                                            </a>
                                        </div>
                                        {{-- gallery image --}}
                                        @php
                                            $gallery = App\Models\ImageGallery::where('product_id', $product->id)->first();
                                        @endphp
                                        @if( !is_null($product->back_image) )
                                            <div class="back">
                                                <a href="{{ route('product-details', $product->slug) }}">
                                                    <img src="{{asset('uploads/product/back_image/' . $product->back_image )}}" class="img-fluid blur-up lazyload bg-img" alt="">
                                                </a>
                                            </div>
                                        @elseif( isset( $gallery ) )
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
                                            <i class="ti-heart" aria-hidden="true"></i></a> 
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#quick-view" title="Quick View">
                                            <i class="ti-search" aria-hidden="true"></i>
                                        </a> 
                                        <a href="compare.html" title="Compare">
                                            <i class="ti-reload" aria-hidden="true"></i>
                                        </a>
                                    </div>

                                    {{-- show discount --}}
                                    @if( !is_null( $product->offer_price ) )
                                        @php
                                            $regularPrice       = $product->regular_price;
                                            $offerPrice         = $product->offer_price;
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
                                            @if( isset($averageRating) && ($averageRating) == 5 )
                                                <div class="rating allStar">
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                </div>
                                            @elseif( isset($averageRating) && ($averageRating >= 4.5) && ($averageRating <= 4.9))
                                                <div class="rating">
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star-half-o noteqaul" aria-hidden="true"></i>
                                                </div>
                                            @elseif( isset($averageRating) && ($averageRating >= 4) && ($averageRating <= 4.4) )
                                                <div class="rating">
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star norating"></i>
                                                </div>
                                            @elseif( isset($averageRating) && ($averageRating >= 3.5) && ($averageRating <= 3.9) )
                                                <div class="rating">
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star-half-o noteqaul" aria-hidden="true"></i>
                                                    <i class="fa fa-star norating"></i>
                                                </div>
                                            @elseif( isset($averageRating) && ($averageRating >= 3) && ($averageRating <= 3.4) )
                                                <div class="rating">
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star norating"></i>
                                                    <i class="fa fa-star norating"></i>
                                                </div>
                                            @elseif( isset($averageRating) && ($averageRating >= 2.5) && ($averageRating <= 2.9) )
                                                <div class="rating">
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star-half-o noteqaul" aria-hidden="true"></i>
                                                    <i class="fa fa-star norating"></i>
                                                    <i class="fa fa-star norating"></i>
                                                </div>
                                            @elseif( isset($averageRating) && ($averageRating >= 2) && ($averageRating <= 2.4) )
                                                <div class="rating">
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star norating"></i>
                                                    <i class="fa fa-star norating"></i>
                                                    <i class="fa fa-star norating"></i>
                                                </div>
                                            @elseif( isset($averageRating) && ($averageRating >= 1.5) && ($averageRating <= 1.9) )
                                                <div class="rating">
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star-half-o noteqaul" aria-hidden="true"></i>
                                                    <i class="fa fa-star norating"></i>
                                                    <i class="fa fa-star norating"></i>
                                                    <i class="fa fa-star norating"></i>
                                                </div>
                                            @elseif( isset($averageRating) && ($averageRating >= 1) && ($averageRating <= 1.4) )
                                                <div class="rating">
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star norating"></i>
                                                    <i class="fa fa-star norating"></i>
                                                    <i class="fa fa-star norating"></i>
                                                    <i class="fa fa-star norating"></i>
                                                </div>
                                            @elseif( isset($averageRating) && ($averageRating >= 0.1) && ($averageRating <= 0.9) )
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
                                        <form action="{{ route('add-to-cart') }}" method="POST" name="cartForm">
                                            @csrf
                                            <input type="hidden" name="quantity" value="{{ ($product->quantity == 0) ? '0' : '1' }}">
                                            <input type="hidden" name="productId" value="{{$product->id}}">
                                            {{-- product attribute --}}
                                            
                                            
                                            @if( ($product->ProductAttribute->count() > 0) )
                                                <a href="{{ route('product-details', $product->slug) }}" class="btn btn-solid hover-solid btn-animation btnAddto">
                                                    <i class="fa fa-shopping-cart me-1" aria-hidden="true"></i> 
                                                    Select Option
                                                </a>
                                            @else
                                                @if( $product->quantity != 0 )
                                                    @if( App\Models\Cart::totalItems()->where('product_id', $product->id)->count() == 0 )
                                                        <button id="cartEffect" class="btn btn-solid hover-solid btn-animation btnAddto" type="submit">
                                                            <i class="fa fa-shopping-cart me-1" aria-hidden="true"></i> 
                                                            Add to cart
                                                        </button>
                                                    @else
                                                        <a href="{{ route('cart-manage') }}" class="btn btn-solid hover-solid btnAddto ExistCart">
                                                            <i class="fa fa-eye text-theme" style="color: #fff !important"></i>
                                                            Exist Your Cart
                                                        </a>
                                                    @endif
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

                    @if($related_product->count() > 6)
                        </div>
                    @endif
                @else
                   <h3 class="no-found">No related product found!</h3>
                @endif
            </div>
        </div>
    </section>
    <!-- product section end -->

@endsection

@section('footer-content')
    

    <!-- sticky cart bottom start -->
    <div class="sticky-bottom-cart d-sm-block d-none">
        <div class="container">
            <div class="cart-content">
                <div class="product-image">
                    <img src="{{asset('frontend/images/pro3/1.jpg')}}" class="img-fluid" alt="">
                    <div class="content d-lg-block d-none">
                        <h5>WOMEN PINK SHIRT</h5>
                        <h6>$32.96<del>$459.00</del><span>55% off</span></h6>
                    </div>
                </div>
                <div class="selection-section">
                    <div class="form-group mb-0">
                        <select id="inputState" class="form-control">
                            <option selected>Choose color...</option>
                            <option>pink</option>
                            <option>blue</option>
                            <option>grey</option>
                        </select>
                    </div>
                    <div class="form-group mb-0">
                        <select id="inputState" class="form-control">
                            <option selected>Choose size...</option>
                            <option>small</option>
                            <option>medium</option>
                            <option>large</option>
                            <option>extra large</option>
                        </select>
                    </div>
                </div>
                <div class="add-btn">
                    <a data-bs-toggle="modal" data-bs-target="#addtocart" href="" class="btn btn-solid btn-sm">add to
                        cart</a>
                </div>
            </div>
        </div>
    </div>
    <!-- sticky cart bottom end -->

     <!-- added to cart notification -->
     <div class="added-notification">
        <img src="{{asset('frontend/images/fashion/pro/1.jpg')}}" class="img-fluid" alt="">
        <h3>added to cart</h3>
     </div>
     <!-- added to cart notification -->
@endsection

@section('page-script')
    @if( !is_null($product_detail->thumb_image) )
        <script src="{{asset('frontend/js/nzoom.min.js')}}"></script>
    @endif

    @if( $product_detail->quantity == 0 )
        <script>
            let cartEffect = document.getElementById('cartEffect');
            cartEffect.setAttribute('disabled', 'disabled');
            cartEffect.onclick = (event) => {
                event.preventDefault();
                toastr.info('The product is not available', '', {"positionClass": "toast-top-right", "closeButton": true});
            }
            document.addEventListener("DOMContentLoaded", function() {
                toastr.info('The product is not available', '', {"positionClass": "toast-top-right", "closeButton": true});
            });
        </script>
    @endif

    {{-- variation --}}
    <script>
        @if( $attrs->count() > 0 )
           // Click event handler for color variant list items
        $(".color-variant li").click(function() {
            $(this).find('input[type="radio"]').prop('checked', true).trigger('change');
            $(this).closest('.variationItem').find('.clear').css('visibility', 'visible');
        });

        // Click event handler for selected list items
        $(".selected li").click(function() {
            $(this).find('input[type="radio"]').prop('checked', true).trigger('change');
            $(this).closest('.variationItem').find('.clear').css('visibility', 'visible');
        });

        $(".clear").hide();
        $(".variationItem").each(function() {
            $(this).find('input[type="radio"]').change(function() {
                $(this).closest('.variationItem').find('.clear').toggle(Boolean($(this).prop('checked')));
            });
        });

        $(".clear").click(function() {
            var radioButton = $(this).closest('.variationItem').find('input[type="radio"]');
            radioButton.prop('checked', false);
            radioButton.closest('li').removeClass('active');
            // Hide the clear div
            $(this).css('visibility', 'hidden');
        });

        @endif
    </script>
    
    {{-- quantity --}}
    <script>
        // Quantity Counter
        var isDisabled = false;

        $('.collection-wrapper .qty-box .quantity-right-plus').on('click', function () {
            var $qty = $('.qty-box .input-number');
            var totalQuant = parseInt($('#totalQuant').val(), 10);
            var currentVal = parseInt($qty.val(), 10);

            if (!isNaN(currentVal) && currentVal < totalQuant) {
                $qty.val(currentVal + 1);
            }

            if (currentVal + 1 >= totalQuant) {
                $(this).prop('disabled', true);
                isDisabled = true;
            }
        });

        $('.collection-wrapper .qty-box .quantity-right-plus').on('mouseout', function () {
            if (isDisabled) {
                $(this).prop('disabled', false);
                isDisabled = false;
            }
        });

        //minus quantity 
        $('.collection-wrapper .qty-box .quantity-left-minus').on('click', function () {
            var $qty = $('.qty-box .input-number');
            var currentVal = parseInt($qty.val(), 10);
            if (!isNaN(currentVal) && currentVal > 1) {
                $qty.val(currentVal - 1);
            }
        });

        // validation
        let cartForm = document.forms['cartForm'];
        cartForm.addEventListener('submit', function(event) {
            let qtyBox = document.querySelector('.qty-input');
            let totalQuant = document.getElementById('totalQuant').value;
            let enteredQty = qtyBox.value;

            if (qtyBox.value === '0') {
                event.preventDefault();
                toastr.info('Please select a quantity', '', {"positionClass": "toast-top-right", "closeButton": true});
            }else if(qtyBox.value < '1'){
                event.preventDefault();
                toastr.error('Value must be greater than or equal to 1', '', {"positionClass": "toast-top-right", "closeButton": true});
            }else if (parseInt(enteredQty) > parseInt(totalQuant)) {
                let availbleItem = document.getElementsByClassName('availble')[0];
                event.preventDefault();
                toastr.error('Exceeds available quantity', '', {"positionClass": "toast-top-right", "closeButton": true});
                toastr.info(`Available Product is ${availbleItem.innerText} Pcs`, '', {"positionClass": "toast-top-right", "closeButton": true});

            }else{
                event.preventDefault();

                var newform = $(cartForm).serialize();
                var variation_id = [];
                $('input.VariationId:checked').each(function(){
                    variation_id.push($(this).attr('id'));
                });

                $.ajax({
                    type : 'POST',
                    url : '{{ route("cart-store") }}',
                    data : {
                        newform : newform,
                        variation_id : variation_id
                    },
                    beforeSend : function(){
                        $('.buyNowBeforesend').html(`
                        <button id="cartEffect" class="btn btn-solid hover-solid btn-animation " type="submit" style="width: 156px;" disabled>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        </button>
                    `);
                    },
                    success:function(response)
                    {
                        $('.buyNowBeforesend').html(`
                            <button id="cartEffect" class="btn btn-solid hover-solid btn-animation " type="submit">
                                <i class="fa fa-shopping-cart me-1" aria-hidden="true"></i> 
                                Buy Now
                            </button>
                    `   );
                        toastr.success(response.msg, '', {"positionClass": "toast-top-right", "closeButton": true});
                        $('.cart-items').html(response.html);

                        // redirect to checkout page
                        setTimeout(function() {
                            window.location.href = "{{ route('checkout') }}";
                        }, 1000);
                    }

                })
                
       
            }
        });

    </script>

    @if( Auth::check() )
        {{-- validation review --}}
        <script>
            let reviewForm = document.forms['reviewForm'];
            reviewForm['submit'].addEventListener('click', (e) => {
                if( reviewForm['review'].value == '' ){
                    e.preventDefault();
                    toastr.error('Wrire Your Testimonial', '', {"positionClass": "toast-top-right", "closeButton": true});
                    reviewForm['review'].style.border = "2px solid #ff0000c7";
                }
                else if( reviewForm['rating'].value == '' ){
                    e.preventDefault();
                    toastr.error('Please Select an Rating', '', {"positionClass": "toast-top-right", "closeButton": true});
                }else if( reviewForm['review'].value != '' ) {
                    toastr.clear();
                    reviewForm['review'].style.border = "none";
                }
            })
        </script>
    @endif
@endsection