    <!-- side-bar colleps block stat -->
    <div class="collection-filter-block">
        <!-- brand filter start -->
        <div class="collection-mobile-back"><span class="filter-back">
            <i class="fa fa-angle-left" aria-hidden="true"></i> back</span></div>
        <div class="collection-collapse-block open">
            <h3 class="collapse-block-title">brand</h3>
            <div class="collection-collapse-block-content">
                <div class="collection-brand-filter">
                    @foreach(App\Models\Brand::orderBy('name', 'asc')->where('status', 1)->get() as $brand)
                        <div class="form-check collection-filter-checkbox">
                            <input type="checkbox" name="brands" value="{{ $brand->id }}" class="form-check-input brand" id="{{ $brand->name }}" @if(in_array($brand->id, explode(',', $q_brands))) checked="checked" @endif onchange="filterByBrand(this)">
                            <label class="form-check-label" for="{{ $brand->name }}">{{ $brand->name }}</label>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    
        <!-- Category filter start here -->
        <div class="collection-collapse-block open">
            <h3 class="collapse-block-title">Category</h3>
            <div class="collection-collapse-block-content">
                <div class="collection-category-filter">
                <div class="mb-4"></div>
                    @foreach( App\Models\Category::with('allSubcategory')->orderBy('name', 'asc')->where('status', 1)->get() as $category )          <div class="p-cat">                 
                        <h4>
                            <a href="{{ route('category-product', $category->slug) }}" class="category-link {{ Request::is('category-product/'. $category->slug) ? 'active' : '' }}">
                                {{ $category->name }}
                            </a>
                            
                            @if( $category->allSubcategory->where('status', 1)->count() != 0 )
                                <i class="fa fa-angle-down {{ Request::is('category-product/'. $category->slug) ? 'pageiconRotate' : '' }}" aria-hidden="true"></i>
                            @endif
                        </h4>

                        {{--all subcategory  --}}
                        @if( $category->allSubcategory->where('status', 1)->count() > 0 )
                            <ul class="sub-cat {{ Request::is('category-product/'. $category->slug) ? 'showSubCat' : '' }}">
                            @foreach( $category->allSubcategory()->where('status', 1)->orderBy('name', 'asc')->get() as $subCategory )
                                <li class="{{ Request::is('category-product/'. $subCategory->slug) ? 'active' : '' }}">
                                    <a href="{{ route('category-product', $subCategory->slug) }}" class="subcategory-link">

                                        @if(isset( $subCategory ))
                                            @if( $subCategory->status == 1 )
                                                {{ $subCategory->name }}
                                            @endif
                                        @endif

                                    </a>
                                </li>
                            @endforeach
                            </ul>
                        @endif
                    </div>  
                    @endforeach
                </div>
            </div>
        </div>

        <!-- color filter start here -->
        <div class="collection-collapse-block open">
            <h3 class="collapse-block-title">colors</h3>
            <div class="collection-collapse-block-content">
                <div class="color-selector">
                    <ul>
                        <li class="color-1 active"></li>
                        <li class="color-2"></li>
                        <li class="color-3"></li>
                        <li class="color-4"></li>
                        <li class="color-5"></li>
                        <li class="color-6"></li>
                        <li class="color-7"></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- price filter start here -->
        <div class="collection-collapse-block border-0 open">
            <h3 class="collapse-block-title">price</h3>
            <div class="collection-collapse-block-content">
                <div class="wrapper mt-3">
                    <div class="range-slider">
                        <input type="text" class="js-range-slider" value="" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- silde-bar colleps block end here -->
    <!-- side-bar single product slider start -->
    <div class="theme-card">
        <h5 class="title-border">new product</h5>
        <div class="offer-slider slide-1">
            <div>
                @foreach( App\Models\Product::orderBy('id', 'desc')->where('status', 1)->take(3)->get() as $newProduct )
                    <div class="media">
                        <a href="{{ route('product-details', $newProduct->slug) }}">
                            @if( !is_null($newProduct->thumb_image) )
                                <img class="img-fluid blur-up lazyload" src="{{ asset('uploads/product/thumb_image/' . $newProduct->thumb_image) }}" alt="">      
                            @else
                                <img class="img-fluid blur-up lazyload" src="{{ asset('uploads/product/thumb_image/nothumb.jpg') }}" alt="">    
                            @endif
                        </a>
                        <div class="media-body align-self-center">
                            <div class="rating">
                                @php
                                    $time = Carbon\Carbon::parse($newProduct->created_at);
                                    $timeDiff = $time->diffInSeconds();
                                    
                                    if ($timeDiff < 60) {
                                        echo $timeDiff . ' sec ago';
                                    } elseif ($timeDiff < 3600) {
                                        echo $time->diffInMinutes() . ' min ago';
                                    } elseif ($timeDiff < 86400) {
                                        echo $time->diffInHours() . ' hr ago';
                                    } elseif ($timeDiff < 31536000) {
                                        echo $time->diffInDays() . ' days ago';
                                    } else {
                                        echo $time->diffInYears() . ' years ago';
                                    }
                                @endphp
                            </div>
                            <a href="{{ route('product-details', $newProduct->slug) }}">
                                <h6>{{ $newProduct->title }}</h6>
                            </a>
                                @if( !is_null( $newProduct->offer_price ) )
                                    <h4>৳{{ $newProduct->offer_price }} <span class="old-price"><del>৳{{$newProduct->regular_price}}</del></span> </h4>
                                @else
                                    <h4>৳{{ $newProduct->regular_price }}</h4>    
                                @endif
                        </div>
                    </div>
                @endforeach
            </div>
            <div>
                @foreach(App\Models\Product::where('status', 1)->orderBy('id', 'desc')->skip(3)->take(3)->get() as $newProduct2)
                    <div class="media">
                        <a href="{{ route('product-details', $newProduct2->slug) }}">
                            @if( !is_null($newProduct2->thumb_image) )
                                <img class="img-fluid blur-up lazyload" src="{{ asset('uploads/product/thumb_image/' . $newProduct2->thumb_image) }}" alt="">      
                            @else
                                <img class="img-fluid blur-up lazyload" src="{{ asset('uploads/product/thumb_image/nothumb.jpg') }}" alt="">    
                            @endif
                        </a>
                        <div class="media-body align-self-center">
                            <div class="rating">
                                @php
                                    $time = Carbon\Carbon::parse($newProduct2->created_at);
                                    $timeDiff = $time->diffInSeconds();
                                    
                                    if ($timeDiff < 60) {
                                        echo $timeDiff . ' sec ago';
                                    } elseif ($timeDiff < 3600) {
                                        echo $time->diffInMinutes() . ' min ago';
                                    } elseif ($timeDiff < 86400) {
                                        echo $time->diffInHours() . ' hr ago';
                                    } elseif ($timeDiff < 31536000) {
                                        echo $time->diffInDays() . ' days ago';
                                    } else {
                                        echo $time->diffInYears() . ' years ago';
                                    }
                                @endphp
                            </div>
                            <a href="{{ route('product-details', $newProduct->slug) }}">
                                <h6>{{ $newProduct2->title }}</h6>
                            </a>
                                @if( !is_null( $newProduct2->offer_price ) )
                                    <h4>৳{{ $newProduct2->offer_price }} <span class="old-price"><del>৳{{$newProduct2->regular_price}}</del></span> </h4>
                                @else
                                    <h4>৳{{ $newProduct2->regular_price }}</h4>    
                                @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- side-bar single product slider end -->
    <!-- side-bar banner start here -->
    <div class="collection-sidebar-banner">
        <a href="#">
            <img src="{{asset('frontend/images/side-banner.png')}}" class="img-fluid blur-up lazyload" alt="">
        </a>
    </div>
    <!-- side-bar banner end here -->

    {{-- filter form --}}
    <form id="filterFrm" method="get">
        <input type="hidden" name="brands" id="brands" value="{{$q_brands}}">
    </form>


@section('page-script')
    {{-- brand filtering --}}
    <script>
        function filterByBrand() {
        let brands = [];
        $("input[name='brands']:checked").each(function() {
            brands.push(this.value);
        });
        
        let baseUrl = "{{ route('all-products') }}";
        let queryString = (brands.length > 0) ? "?brands=" + brands.join(',') : "";
        window.location.href = baseUrl + queryString;
    }
    </script>
    
    {{-- price-range --}}
    <script src="{{asset('frontend/js/price-range.js')}}"></script>
@endsection