@extends('frontend.layout.template')

@section('page-title')
    <title>Wishlist || Multikart</title>
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
                    <div class="col-sm-12 table-responsive-xs wishlistLists">
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
                                {{-- wihslist item --}}
                                @include('frontend.includes.wishlistDetails')
                                
                                {{-- loader --}}
                                <div class="loader">
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                </div>
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
    {{-- validation --}}
    <script>
        let notAdd = document.querySelectorAll('.notAdd');
        let existCart = document.querySelectorAll('.existCart');

        if (notAdd) {
            notAdd.forEach(element => {
                element.addEventListener('click', function(e) {
                    toastr.info('The product is not available! <br> Check Back Later.', '', {"positionClass": "toast-top-right", "closeButton": true});
                });
            });
        }

        if (existCart) {
            existCart.forEach(element => {
                element.addEventListener('click', function(e) {
                    toastr.info('The product is exsit in your cart', '', {"positionClass": "toast-top-right", "closeButton": true});
                });
            });
        }
    </script>

    {{-- move wishlist to cart --}}
    <script>
        $(document).ready(function() {
            $(document).on('click', '.moveToCart', function() {
                var $form = $(this).closest('.moveToCartForm');
                var $button = $(this);
                var formData = $form.serialize();

                $.ajax({
                    type: 'POST',
                    url: $form.attr('action'),
                    data: formData,
                    beforeSend: function() {
                        $("#wishlistItemsAll .loader").css('z-index', '2');
                        $("#wishlistItemsAll .loader").css('visibility', 'visible');

                        var currentUrl = window.location.href;
                        if (currentUrl.includes('wishlists')) {
                            $(".wishlistLists .loader").css('z-index', '2');
                            $(".wishlistLists .loader").css('visibility', 'visible');
                        }
                    },
                    success: function(response) {
                        toastr.info(response.msg, '', {"positionClass": "toast-top-right", "closeButton": true});
                        toastr.info(response.msgs, '', {"positionClass": "toast-top-right", "closeButton": true});
                        $('.wishlist-items').html(response.html);
                        $('.cart-items').html(response.addCart);

                        $("#wishlistItemsAll .loader").css('z-index', '-1');
                        $("#wishlistItemsAll .loader").css('visibility', 'hidden');

                        // validation
                        $(document).on('click', '.notAdd', function() {
                            toastr.info('The product is not available! <br> Check Back Later.', '', {"positionClass": "toast-top-right", "closeButton": true});
                        });

                        $(document).on('click', '.existCart', function() {
                            toastr.info('The product is exsit in your cart', '', {"positionClass": "toast-top-right", "closeButton": true});
                        });

                        //redirect to all-product-page if wishlist item is null
                        var wcqunt = parseInt($('.wcqunt').val());
                        var currentUrl = window.location.href;
                        if (currentUrl.includes('wishlists') && (wcqunt === 0)) {
                            window.location.href = "{{ route('all-products') }}";
                        } else if (currentUrl.includes('wishlists')) {
                            if (wcqunt === 0) {
                                window.location.href = "{{ route('all-products') }}";
                            } else {
                                $('.wishlistBody').html(response.delWc)
                                $(".wishlistLists .loader").css('z-index', '-1');
                                $(".wishlistLists .loader").css('visibility', 'hidden');
                            }
                        }
                    },
                });
            });
        });

    </script>
@endsection
