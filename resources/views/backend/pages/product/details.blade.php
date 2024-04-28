@extends('backend.layout.template')

@section('page-title')
    <title>Product Details || {{ !is_null($siteTitle = App\Models\Settings::site_title()) ? $siteTitle->site_title : 'Shop' }}</title>
@endsection

@section('page-css')
    <link rel="stylesheet" href="{{ asset('backend/css/custom.css') }}" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/thinline.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
@endsection

@section('body-content')

    <div class="page-content">
       <!--breadcrumb-->
       <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">
            {{ !is_null($siteTitle = App\Models\Settings::site_title()) ? $siteTitle->site_title : 'Shop' }}
        </div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ route('adminDashboard') }}"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Product Details</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->
 
        <div class="card p-3">
            <div class="row g-0">
                <div class="col-md-4">
                @if( !is_null($product_detail->thumb_image) )
                    <img src="{{ asset('uploads/product/thumb_image/' . $product_detail->thumb_image) }}" class="img-fluid rounded" alt="...">
                @else
                    <img src="{{ asset('uploads/product/thumb_image/nothumb.jpg') }}" class="img-fluid rounded" alt="...">
                @endif
                <div class="row mb-3 row-cols-auto g-2 justify-content-center mt-3">
                    <div class="col"><img src="assets/images/products/12.png" width="70" class="border rounded cursor-pointer" alt=""></div>
                    <div class="col"><img src="assets/images/products/11.png" width="70" class="border rounded cursor-pointer" alt=""></div>
                    <div class="col"><img src="assets/images/products/14.png" width="70" class="border rounded cursor-pointer" alt=""></div>
                    <div class="col"><img src="assets/images/products/15.png" width="70" class="border rounded cursor-pointer" alt=""></div>
                </div>
                </div>
                <div class="col-md-8">
                <div class="card-body">
                    <h4 class="card-title">{{ $product_detail->title }}</h4>
                    <div class="d-flex gap-3 py-3">
                        {{-- review --}}
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

                        <div class="cursor-pointer">
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
                        </div>	
                        <div>{{ $reviewsCount }} Reviews</div>
                        <div class="text-success"><i class='bx bxs-cart-alt align-middle'></i> {{ App\Models\Cart::whereNotNull('order_id')->where('product_id', $product_detail->id)->count() }} orders</div>
                    </div>

                    <div class="mb-3"> 
                        @if( !is_null( $product_detail->offer_price ) )
                            @php
                                $regularPrice       = $product_detail->regular_price;
                                $offerPrice         = $product_detail->offer_price;
                                $discountPercentage = (($regularPrice - $offerPrice) / $regularPrice) * 100;
                            @endphp
                            <h3 class="price h4">৳{{ $product_detail->offer_price }}
                                <del class="offerPrice">৳{{ $product_detail->regular_price }}</del>
                                <span class="offerPrice">{{ round($discountPercentage) }}% off</span>
                            </h3>
                        @else
                            <h3 class="price h4">৳{{ $product_detail->regular_price }}</h3>
                        @endif
                    </div>

                    
                    @if( !is_null( $product_detail->short_details ) )
                        <div class="border-product">
                            <h6 class="product-title">Short Details</h6>
                            <div class="timer">
                                <p  class="card-text fs-6">
                                    @php
                                        echo $product_detail->short_details;
                                    @endphp
                                </p>
                            </div>
                        </div>
                    @endif

                    <dl class="row">
                    <dt class="col-sm-3">Category</dt>
                    <dd class="col-sm-9">
                        <span class="label-text" >
                            @if( isset($product_detail->category) ) 
                                 @if( $product_detail->category->status == 1 )
                                     {{ $product_detail->category->name }}
                                 @else
                                     <span style="color: #ff4c3b;text-transform:capitalize;">Uncategorize</span>
                                 @endif
                                 @else
                                    <span style="color: #ff4c3b;text-transform:capitalize;">Uncategorize</span>
                             @endif  

                             @if( isset($product_detail->category) ) 
                                 @if( $product_detail->category->status == 1 ) 
                                     @if( isset($product_detail->subCategory) ) 
                                         @if( $product_detail->subCategory->status == 1)
                                             / {{ $product_detail->subCategory->name }}
                                         @else
                                             /  <span style="color: #ff4c3b;text-transform:capitalize;">Uncategorize</span>
                                         @endif   
                                         @else
                                             /  <span style="color: #ff4c3b;text-transform:capitalize;">Uncategorize</span>
                                     @endif
                                 @endif
                             @endif 
                            
                         </span>
                    </dd>
                    
                    <dt class="col-sm-3">Brand</dt>
                    <dd class="col-sm-9">
                        @if (isset($product_detail->brand_id) && $product_detail->brand_id !== null && $product_detail->brand_id !== 0)
                            {{ optional($product_detail->brand)->name ?? 'Not found!' }}
                        @else
                            Not found!
                        @endif
                    </dd>
                    
                    <dt class="col-sm-3">Quantity</dt>
                    <dd class="col-sm-9">
                        @if( $product_detail->quantity != 0 )
                            <p class="stock text-success"><span class="availble stock text-success">{{ $product_detail->quantity }}</span> Psc</p>
                        @else
                            <h4 class="stock text-danger">Out of Stock!</h4>
                        @endif 
                    </dd>
                    </dl>
                    <hr>
                    <div class="row row-cols-auto row-cols-1 row-cols-md-3">
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
                            
                                <div class="col">
                                    <label class="form-label"><span>{{ $attr->ProductVariation->var_name }} <span></label>
                                    <div class="color-indigators d-flex align-items-center gap-2">
                                        @foreach ($variationValues as $valueId)
                                            @php
                                                $variationValue = App\Models\VariationValue::find($valueId);
                                            @endphp
                                                    
                                            @if( $variationValue->option_value != null )
                                                    <div class="color-indigator-item bg-primary" style="background-color:{{$variationValue->option_value}} !important"></div> 
                                            @else
                                                <div>{{$variationValue->option}}</div> 
                                            @endif
                                        @endforeach
                                    </div>
                                </div>

                                @else
                                    <div id="selectSize" class="addeffect-section product-description border-product">
                                        <h6 class="product-title size-text">{{ $attr->ProductVariation->var_name }}</h6>
                                        <div class="size-box">
                                            <ul class="attrBox" type="none">
                                                @foreach ($variationValues as $valueId)
                                                    @php
                                                        $variationValue = App\Models\VariationValue::find($valueId);
                                                    @endphp
                                                    <li>{{$variationValue->option}}</li>
                                                @endforeach
                                            </ul>
                                        </div>  
                                    </div>
                                @endif
                            @endforeach
                        @endif
                        
                    </div>
                <div class="d-flex gap-3 mt-3">
                    <a href="{{ route('edit-product', $product_detail->id) }}" class="btn btn-primary">
                        <span class="text">Update Product</span>
                    </a>
                </div>
                </div>
                </div>
            </div>
            <hr/>

            <div class="card-body">
                <ul class="nav nav-tabs nav-primary mb-0" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" data-bs-toggle="tab" href="#primaryhome" role="tab" aria-selected="true">
                            <div class="d-flex align-items-center">
                                <div class="tab-icon"><i class='bx bx-comment-detail font-18 me-1'></i>
                                </div>
                                <div class="tab-title"> Product Description </div>
                            </div>
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" data-bs-toggle="tab" href="#primaryprofile" role="tab" aria-selected="false">
                            <div class="d-flex align-items-center">
                                <div class="tab-icon"><i class='bx bx-bookmark-alt font-18 me-1'></i>
                                </div>
                                <div class="tab-title">Tags</div>
                            </div>
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" data-bs-toggle="tab" href="#primarycontact" role="tab" aria-selected="false">
                            <div class="d-flex align-items-center">
                                <div class="tab-icon"><i class='bx bx-star font-18 me-1'></i>
                                </div>
                                <div class="tab-title">Reviews</div>
                            </div>
                        </a>
                    </li>
                </ul>
                <div class="tab-content pt-3">
                    <div class="tab-pane fade show active" id="primaryhome" role="tabpanel">
                        @if( !is_null($product_detail->long_details) )
                            @php
                                echo $product_detail->long_details;
                            @endphp
                        @else
                            <h3 class="no-found">No description found in this product!</h3>
                        @endif
                    </div>
                    <div class="tab-pane fade" id="primaryprofile" role="tabpanel">
                        <?php
                            $tags = $product_detail->tags;
                            $tags_array = explode(',', $tags);
                            $tags_array = array_map('trim', $tags_array);
                            $tags_string = implode(' ', $tags_array);
                            echo $tags_string;
                        ?>
                    </div>
                    <div class="tab-pane fade" id="primarycontact" role="tabpanel">
                        @if( $reviews->count() > 0 )
                        @foreach( $reviews as $review )
                            <div class="allReview">
                                <ul>
                                    <li>
                                        @if( !is_null($review->user->image) )
                                            <img src="{{ asset('uploads/user/' . $review->user->image) }}" alt="">
                                        @else
                                            <img src="{{ asset('backend/images/default.jpg') }}" alt="">
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
                        @else
                            <h3 class="no-found">No review found in this product!</h3>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-script')
    
@endsection

		