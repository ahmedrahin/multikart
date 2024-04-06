<!-- latest jquery-->
<script src="{{asset('frontend/js/jquery-3.3.1.min.js')}}"></script>

<!-- portfolio js -->
<script src="{{asset('frontend/js/isotope.min.js')}}"></script>
<script src="{{asset('frontend/js/main.js')}}"></script>

<!-- menu js-->
<script src="{{asset('frontend/js/menu.js')}}"></script>
<script src="{{asset('frontend/js/sticky-menu.js')}}"></script>

<!-- feather icon js-->
<script src="{{asset('frontend/js/feather.min.js')}}"></script>

<!-- lazyload js-->
<script src="{{asset('frontend/js/lazysizes.min.js')}}"></script>

<!-- slick js-->
<script src="{{asset('frontend/js/slick.js')}}"></script>
<script src="{{asset('frontend/js/slick-animation.min.js')}}"></script>

<!-- Bootstrap js-->
<script src="{{asset('frontend/js/bootstrap.bundle.min.js')}}"></script>

<script src="{{asset('frontend/js/script.js')}}"></script>
<script src="{{asset('frontend/js/custom-slick-animated.js')}}"></script>

{{-- search box --}}
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
<script>
    
    $(window).on('click', function() {
        $('#suggestionDropdown').hide();
    });

    $(document).ready(function() {
        var searchXHR; 
        $('#searchInput').on('input', function() {
            var searchTerm = $(this).val().toLowerCase().trim();
            if (searchXHR && searchXHR.readyState !== 4) {
                searchXHR.abort();
            }

            if (searchTerm.length >= 2) {
                searchXHR = $.ajax({
                    url: '/search-product',
                    method: 'GET',
                    data: { term: searchTerm },
                    success: function(response) {
                        filterProducts(response, searchTerm);
                    }
                });
            } else if( searchTerm.length < 2 ) {
                $('.search_box').on('click', function(event) {
                    event.stopPropagation();
                    $('#suggestionDropdown').hide();
                });
                $('#suggestionDropdown').empty().hide();
            }
        });

    });

    function filterProducts(products, searchTerm) {
        var matchingProducts = products.filter(function(product) {
            var tags = (product['tags'] != null) ? product.tags.toLowerCase().split(', ') : [];
            return product.title.toLowerCase().includes(searchTerm) ||
                tags.some(tag => tag.includes(searchTerm));
        });

        startAutoComplete(matchingProducts);
    }

    function startAutoComplete(products) {
        var dropdownContent = '';
        if (products.length > 0) {
            $('.search_box').on('click', function(event) {
                event.stopPropagation();
                $('#suggestionDropdown').show();
            });
            products.forEach(function(product) {
                dropdownContent += `<div class="suggestion"> 
                        <a href="/product-details/${product.slug}">
                            <div class="search_pimage">
                                ${(product.thumb_image) ?
                                    `<img src="{{ asset('uploads/product/thumb_image') }}/${product.thumb_image}">` :
                                    `<img src="{{ asset('uploads/product/thumb_image/nothumb.jpg') }}">`
                                }
                            </div> 
                            <div class="search_title">
                                <p>${product.title}</p>
                                ${
                                    (product.offer_price) 
                                    ? `<span>৳${product.offer_price}</span><del>৳${product.regular_price}</del>` 
                                    : `<span>৳${product.regular_price}</span>`
                                }
                            </div>
                        </a>
                    </div>`;
        });
        } else {
            $('.search_box').on('click', function(event) {
                event.stopPropagation();
                $('#suggestionDropdown').show();
            });
            dropdownContent = '<div class="no-suggestions">No matching products found</div>';
        }
        $('#suggestionDropdown').html(dropdownContent).show(); // Show the dropdown after updating content
    }

    // search from validation
    let btnSearch = document.querySelectorAll('.btn-search');
    btnSearch.forEach((i) => {
        let searchField =  document.getElementById('searchInput');
        i.onclick = (e) => {
            if( searchField.value == '' ){
                e.preventDefault();
            }
        }
    })

</script>

<script>
    $(window).on('load', function () {
        setTimeout(function () {
            $('#exampleModal').modal('show');
        }, 2500);
    });

    function openSearch() {
        document.getElementById("search-overlay").style.display = "block";
    }

    function closeSearch() {
        document.getElementById("search-overlay").style.display = "none";
    }
    feather.replace();
</script>
<!-- Toastr Js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "8000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }

    @if( Session::has('message') )
        let type = "{{ Session::get('alert-type') }}";

        switch( type ){
            case 'info':
                toastr.info("{{ Session::get('message') }}");
                break;

            case 'success':
                toastr.success("{{ Session::get('message') }}");
                break;

            case 'warning':
                toastr.warning("{{ Session::get('message') }}");
                break;

            case 'error':  
                toastr.error("{{ Session::get('message') }}");          
        }

    @endif    

</script>

{{-- category dropdown --}}
<script>
    const parentCat = document.querySelectorAll('.p-cat');
    for( let i = 0; i < parentCat.length; i++ ){
        parentCat[i].addEventListener('mouseover', function(category){
            parentCat.forEach(function (list){
                list.classList.remove('activeCategory');
            })
            this.classList.add('activeCategory');
        })

        parentCat[i].addEventListener('mouseout', function(category){
            this.classList.remove('activeCategory');
        })
    }

    const subCatLists = document.querySelectorAll('.sub-cat');
    subCatLists.forEach((subCatList) => {
        const activeItem = subCatList.querySelector('.active');
            if (activeItem) {
                subCatList.classList.add('showSubCat');
            const parentPcat = subCatList.closest('.p-cat');
            if (parentPcat) {
                parentPcat.classList.add('activeParentCat');
            }
        }
    });

</script>

{{-- not availble button --}}
<script>
    const notAvailble = document.querySelectorAll('.notAvailble')
    notAvailble.forEach(function(btn){
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            toastr.info('The product is not available! <br> Check back later.', '', {"positionClass": "toast-top-right", "closeButton": true});
        })
    })
</script>

{{-- wishlist button --}}
<script>
    let existWishlist    = document.getElementById('existWishlist');
    // let btnExistWishlist = document.querySelectorAll('.existWishlist');
        if( existWishlist ){
            existWishlist.onclick = (e) => {
            e.preventDefault();
            toastr.info('The Product is exist in Wishlist', '', {"positionClass": "toast-top-right", "closeButton": true});
        }
    }
    // btnExistWishlist.forEach(function(exist){
    //     exist.onclick = (e) => {
    //         e.preventDefault();
    //         toastr.info('The Product is exist in Wishlist', '', {"positionClass": "toast-top-right", "closeButton": true});
    //     }  
      
    // })
</script>

{{-- add to cart --}}
<script>
   $(document).ready(function() {
        $('.btnAddtoCart').click(function() {
            var $form = $(this).closest('.cartForm');
            var $button = $(this);
            var formData = $form.serialize();

            $.ajax({
                type: 'POST',
                url: $form.attr('action'),
                data: formData,
                beforeSend : function()
                {
                    $button.prop('disabled', true).html(`
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    `);
                    $button.addClass('padding');
                },
                success: function(response) {
                    toastr.success(response.msg, '', {"positionClass": "toast-top-right", "closeButton": true});
                    $('.cart-items').html(response.html);
                    $button.removeClass('padding');
                    $button.prop('disabled', false).html(`
                        <i class="fa fa-shopping-cart me-1" aria-hidden="true"></i> 
                        Add to cart
                    `);
                },
                error: function(xhr, textStatus, errorThrown) {
                    $button.prop('disabled', false).html(`
                        <i class="fa fa-shopping-cart me-1" aria-hidden="true"></i> 
                        Add to cart
                    `);
                    // Handle error response for the specific form
                    console.error('Error adding product to cart:', errorThrown);
                }
            });
        });
    });
</script>

{{-- delete cart item  --}}
<script>
    $(document).on('click', '.deleteCart', function(e) {
        e.preventDefault();
        var formId = $(this).data('form-id');
        var $form = $('#delCartForm_' + formId);
        var id = $form.find('.cartId').val();
        delCart(id, $form);
    });

    function delCart(id, $form)
    {
        if(id != '')
        {
            $.ajax({
                type : 'DELETE',
                url: '/carts/delete/' + id,
                beforeSend : function()
                {
                    $("#shoppingCart .loader").css('z-index', '2');
                    $("#shoppingCart .loader").css('visibility', 'visible');

                    var currentUrl = window.location.href;
                    if( currentUrl.includes('carts') ){
                        $(".cartLists .loader").css('z-index', '2');
                        $(".cartLists .loader").css('visibility', 'visible');
                    }
                },
                success : function(response)
                {
                    toastr.info(response.msg, '', {"positionClass": "toast-top-right", "closeButton": true});
                    $form.closest('.cart-items').html(response.html);

                    $("#shoppingCart .loader").css('z-index', '-1');
                    $("#shoppingCart .loader").css('visibility', 'hidden');
                    
                    //redirect to all-product-page if cart item is null
                    var qynt = parseInt($('.qynt').val());
                    var currentUrl = window.location.href;
                    if (currentUrl.includes('checkout') && (qynt === 0)) {
                        window.location.href = "{{ route('all-products') }}";
                    }else if( currentUrl.includes('carts') ){
                        if( qynt === 0 ){
                            window.location.href = "{{ route('all-products') }}";
                        }else {
                            $('#cartItems').html(response.cartItem)
                            $(".cartLists .loader").css('z-index', '-1');
                            $(".cartLists .loader").css('visibility', 'hidden');
                            $("#cartsAmn").html("৳" + $('.amn').val());

                            // Function to increment quantity
                            function test(){
                                $('.quantity-right-plus').on('click', function() {
                                var $input = $(this).closest('.qty-box').find('.input-number');
                                var currentVal = parseInt($input.val()) || 0;
                                var totalQuant = parseInt($input.siblings('.totalQuant').val());
                                if (currentVal < totalQuant) {
                                    $input.val(currentVal + 1);
                                    sendAjaxRequest($input);
                                }
                            });
                
                            // Function to decrement quantity
                            $('.quantity-left-minus').on('click', function() {
                                var $input = $(this).closest('.qty-box').find('.input-number');
                                var currentVal = parseInt($input.val()) || 0;
                                if (currentVal > 1) {
                                    $input.val(currentVal - 1);
                                    sendAjaxRequest($input);
                                }
                            });
                
                            // Function to handle input change and validation
                            $('.input-number').on('input', function() {
                                var $input = $(this);
                                var enteredQty = parseInt($input.val()) || 0;
                                var totalQuant = parseInt($input.siblings('.totalQuant').val());
                                var inputQynt = parseInt($input.siblings('.input-qynt').val());
                
                                // Validate quantity
                                if (enteredQty < 1 || isNaN(enteredQty)) {
                                    $input.val(inputQynt);
                                    toastr.warning('Value must be greater than or equal to 1', '', {"positionClass": "toast-top-right", "closeButton": true});
                                } else if (enteredQty > totalQuant) {
                                    $input.val(totalQuant); 
                                    toastr.warning('Exceeds available quantity', '', {"positionClass": "toast-top-right", "closeButton": true});
                                    toastr.info(`Available Product is ${totalQuant} Pc`, '', {"positionClass": "toast-top-right", "closeButton": true});
                                    sendAjaxRequest($input);
                                }else {
                                    toastr.clear();
                                    sendAjaxRequest($input);
                                }
                
                                // Enable/disable buttons based on quantity
                                $input.siblings('.quantity-right-plus').prop('disabled', enteredQty >= totalQuant);
                                $input.siblings('.quantity-left-minus').prop('disabled', enteredQty <= 1);
                
                            });
                            }

                            test();
                            function sendAjaxRequest($input) {
                                var cartId = $input.closest('tr').data('cart-id');
                                var newQuantity = $input.val();
                                var requestData = {
                                    newQuantity: newQuantity
                                };
                
                                // Send the AJAX request
                                $.ajax({
                                    type: 'POST',
                                    url: 'carts/update/'+cartId,
                                    data: requestData,
                                    success: function(response) {
                                        toastr.success(response.msg, '', {"positionClass": "toast-top-right", "closeButton": true});
                                        $('#cartItems').html(response.cartItem);
                                        $('.cart-items').html(response.html);
                                        $("#cartsAmn").html("৳" + $('.amn').val());
                                        
                                        test();
                                    },
                                    error: function(xhr, textStatus, errorThrown) {
                                        console.error('Error in AJAX request:', errorThrown);
                                    }
                                });
                            }
                            
                        }
                        
                    } else if( currentUrl.includes('wishlists') ){
                        $('.wishlistBody').html(response.delWc)
                    }
                }
            })
        }
    }      
</script>

 {{-- add wishlist item --}}
 <script>
   $(document).ready(function() {
        $('.btnAddWs').click(function() {
            addWishlist($(this));
        });
    });

    function addWishlist($button) {
        var $form = $button.closest('.wishlistForm'); // Use $button instead of $(this)
        var formData = $form.serialize();

        $.ajax({
            type: 'POST',
            url: $form.attr('action'),
            data: formData,
            beforeSend: function() {
                $button.prop('disabled', true).html(`
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                `);
                $button.css('width', '146px');
            },
            success: function(response) {
                toastr.success(response.msg, '', {"positionClass": "toast-top-right", "closeButton": true});
                $('.wishlist-items').html(response.html);
                $button.prop('disabled', false).html(`
                    <i class="fa fa-bookmark fz-16 me-2" aria-hidden="true"></i>
                    wishlist
                `);
                $button.attr('id', 'existWishlist');
                $button.removeClass('btnAddWs');

                // Rebind click event for the new button ID
                $button.off('click').on('click', function(e) {
                    e.preventDefault();
                    toastr.info('The Product is exist in Wishlist', '', {"positionClass": "toast-top-right", "closeButton": true});
                });
            },
            error: function(xhr, textStatus, errorThrown) {
                // Handle error response for the specific form
                console.error('Error adding product to cart:', errorThrown);
            }
        });
    }

</script>

{{-- wishlist item delete --}}
<script>
     $(document).on('click', '.deleteWishlist', function(e) {
        e.preventDefault();
        var formId = $(this).data('form-id');
        var $form = $('#delWishlistForm_' + formId);
        var id = $form.find('.wishlistId').val();
        delWishlist(id, $form);
    });

    function delWishlist(id, $form)
    {
        if(id != '')
        {
            $.ajax({
                type : 'DELETE',
                url: $form.attr('action'),
                beforeSend : function()
                {
                    $("#wishlistItemsAll .loader").css('z-index', '2');
                    $("#wishlistItemsAll .loader").css('visibility', 'visible');

                    var currentUrl = window.location.href;
                    if( currentUrl.includes('wishlists') ){
                        $(".wishlistLists .loader").css('z-index', '2');
                        $(".wishlistLists .loader").css('visibility', 'visible');
                    }
                },
                success : function(response)
                {
                    toastr.info(response.msg, '', {"positionClass": "toast-top-right", "closeButton": true});
                    $form.closest('.wishlist-items').html(response.html);

                    $("#wishlistItemsAll .loader").css('z-index', '-1');
                    $("#wishlistItemsAll .loader").css('visibility', 'hidden');

                    // again click add wisihlist button
                    $('.wishlistBeforesend').html(`
                        <button class="btn btn-solid btnAddWs" type="button" style="padding: 8px 25px;margin-left: 13px;">
                            <i class="fa fa-bookmark fz-16 me-2" aria-hidden="true"></i>
                            wishlist
                        </button>
                    `);
                    $(document).on('click', '.btnAddWs', function() {
                        addWishlist($(this));
                    });

                     //redirect to all-product-page if wishlist item is null
                    var wcqunt = parseInt($('.wcqunt').val());
                    var currentUrl = window.location.href;
                    if (currentUrl.includes('wishlists') && (wcqunt === 0)) {
                        window.location.href = "{{ route('all-products') }}";
                    }else if( currentUrl.includes('wishlists') ){
                        if( wcqunt === 0 ){
                            window.location.href = "{{ route('all-products') }}";
                        }else {
                            $('.wishlistBody').html(response.delWc)
                            $(".wishlistLists .loader").css('z-index', '-1');
                            $(".wishlistLists .loader").css('visibility', 'hidden');
                        }
                    }
                }
            })
        }
    }  
</script>

@yield('page-script')
