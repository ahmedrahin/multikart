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

{{-- cart remove --}}
<script>

    let deleteCart = document.querySelectorAll('.deleteCart');
    let shoppingCart = document.getElementById('shoppingCart');
    let subtotalElement = document.querySelector('.total span');
    let totalItemsElement = document.querySelector('.totalItem span');
    const cartId = document.querySelector('.cartId').value;

    deleteCart.forEach(function(cart){
        cart.addEventListener('click', () => {
            event.preventDefault();

            let delCart = cart.closest('form');
            let xhrCart = new XMLHttpRequest(); 
            xhrCart.open('DELETE', delCart.getAttribute('action'), true); 
            xhrCart.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}'); 
            xhrCart.onreadystatechange = function () {
                if (xhrCart.readyState === XMLHttpRequest.DONE) {
                    if (xhrCart.status === 200) {
                        // Slide up animation before removing the deleted item from the DOM
                        $(cart.closest('li')).slideUp(300, function(){
                            this.remove();
                        });
                        toastr.warning('The Item Removed From Cart', '', {"positionClass": "toast-top-right", "closeButton": true});
                        
                    } else {
                        console.error('Error:', xhrCart.status);
                    }
                }
            };
            xhrCart.send(); // Send the AJAX request
        });
    });

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
@yield('page-script')
