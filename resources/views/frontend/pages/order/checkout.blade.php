@extends('frontend.layout.template')

@section('page-title')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title> Checkout || Multikart</title>
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
                        <h2>Check-out</h2>
                    </div>
                </div>
                <div class="col-sm-6">
                    <nav aria-label="breadcrumb" class="theme-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Check-out</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb End -->

    <!-- section start -->
    <section class="section-b-space">
        <div class="container">
            <div class="checkout-page">
                <div class="checkout-form">
                    <form action="{{ route('make-payment') }}" method="POST" name="checkout">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6 col-sm-12 col-xs-12">
                                <div class="checkout-title">
                                    <h3>Billing Details</h3>
                                </div>
                                <div class="row check-out">
                                    <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                        <div class="field-label">Your Name</div>
                                        <input type="text" name="name" value="{{ ( Auth::check() ) ? Auth::user()->name : "" }}" placeholder="Enter Your Name">
                                        @error('name')
                                            <span class="text-danger"> {{ $message }} </span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                        <div class="field-label">Phone Number</div>
                                        <input type="text" name="phone" value="{{ ( Auth::check() && !is_null(Auth::user()->phone) ) ? Auth::user()->phone : "" }}" placeholder="Your Phone Number">
                                        @error('phone')
                                            <span class="text-danger"> {{ $message }} </span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-12 col-sm-6 col-xs-12">
                                        <div class="field-label">Email Address</div>
                                        <input type="text" name="email" value="{{ ( Auth::check() ) ? Auth::user()->email : "" }}" placeholder="Your Email Address">
                                        @error('email')
                                            <span class="text-danger"> {{ $message }} </span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                        <div class="field-label">Address Line 1</div>
                                        <input type="text" name="address_line1" value="{{ ( Auth::check() && !is_null(Auth::user()->address_line1) ) ? Auth::user()->address_line1 : "" }}" placeholder="Street address">
                                        @error('address_line1')
                                            <span class="text-danger"> {{ $message }} </span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                        <div class="field-label">Address Line 2 (optional)</div>
                                        <input type="text" name="address_line2" value="{{ ( Auth::check() && !is_null(Auth::user()->address_line2) ) ? Auth::user()->address_line2 : "" }}" placeholder="Street address">
                                    </div>

                                    <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                        <div class="field-label">Country</div>
                                        <select name="country" id="country">
                                            <option value="">Please Select your Country</option>
                                            @if( Auth::check() && Auth::user()->country_id )
                                                @foreach( $countries as $country )
                                                    <option value="{{ $country->id }}" {{  ( Auth::user()->country_id == $country->id ) ? "selected" : "" }} >{{ $country->name }}</option>
                                                @endforeach
                                            @else
                                                @foreach( $countries as $country )
                                                    <option value="{{ $country->id }}" >{{ $country->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        @error('country')
                                            <span class="text-danger"> {{ $message }} </span>
                                        @enderror
                                    </div>
                                    
                                    <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                        <div class="field-label">State / Division</div>
                                        <select name="state" id="state" disabled>
                                            <option value="">Please Select your Division</option>
                                        </select>
                                        @error('state')
                                            <span class="text-danger"> {{ $message }} </span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                        <div class="field-label">District / Area</div>
                                        <select name="district" id="district" disabled>
                                            <option value="">Please Select your District</option>
                                        </select>
                                        @error('district')
                                            <span class="text-danger"> {{ $message }} </span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-12 col-sm-6 col-xs-12">
                                        <div class="field-label">Postal / Zip Code</div>
                                        <input type="text" name="zipCode" value="{{ ( Auth::check() && !is_null(Auth::user()->zipCode) ) ? Auth::user()->zipCode : "" }}" placeholder="Your Zip Code">
                                        @error('zipCode')
                                            <span class="text-danger"> {{ $message }} </span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <input type="checkbox" name="shipping-option" id="account-option"> &ensp;
                                        <label for="account-option">Create An Account?</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 col-sm-12 col-xs-12">
                                {{-- cupone --}}
                                <div class="cupon mb-4">
                                    <p>
                                        <span>Have an coupon?</span>
                                        Here you can apply your code
                                    </p>
                                    <input type="text" placeholder="Cupon Code" name="code" id="code" value="{{session()->get('code') ? session()->get('code')->cupon_code : ''}}">
                                    @if( session()->has('code') )
                                        @if( session()->get('code') )
                                            <button type="button" id="delCupon">Cancel Coupon</button>
                                        @endif
                                    @else
                                        <button type="button" id="applyCupon" disabled>Apply Coupon</button>
                                    @endif
                                </div>

                                <div class="checkout-details">
                                    <div class="order-box">
                                        <div class="title-box">
                                            <div>Product <span>Total</span></div>
                                        </div>
                                        <ul class="qty">
                                            @foreach( App\Models\Cart::totalItems() as $items )
                                                @if( $items->product->status == 1 )
                                                    <li>{{ $items->product->title }} × {{ $items->product_quantity }} Pcs 
                                                        <span>
                                                            @if( !is_null( $items->product->offer_price ) )
                                                                ৳{{ $items->product->offer_price }}
                                                            @else
                                                                ৳{{ $items->product->regular_price }}
                                                            @endif
                                                        </span>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                        <ul class="sub-total">
                                            <li>Subtotal <span class="count">৳{{ App\Models\Cart::totalAmount() }}</span></li>
                                            <li>Shipping
                                                <div class="shipping">
                                                    <div class="method">
                                                       
                                                    </div>
                                                    <span class='noShip'>No shipping method is available</span>
                                                </div>
                                            </li>
                                            <li class="discountAmount" style="display: {{ (session('discount.discount') > 0) ? 'block' : 'none' }}">Discount <span class="count"> - ৳{{ session('discount.discount') }}</span></li>
                                        </ul>
                                        <ul class="total">
                                            <li>Total <span class="count count2">৳{{ App\Models\Cart::discountAmount()['totalAmount'] }}</span></li>
                                        </ul>
                                    </div>

                                    <div class="payment-box">
                                        <div class="upper-box">
                                            <div class="payment-options">
                                                <ul>
                                                    <li>
                                                        <div class="radio-option">
                                                            <input type="radio" name="paymentMethod" id="payment-2" value="1" checked="checked">
                                                            <label for="payment-2">Cash On Delivery
                                                                <span class="small-text"  style="display: block">
                                                                    <img src="{{ asset('frontend/images/cod.png') }}" alt="" class="cod">
                                                                    Please send a check to Store Name, Store Street, Store Town, Store State / County, Store Postcode.                                                                 
                                                                </span>
                                                            </label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="radio-option">
                                                            <input type="radio" name="paymentMethod" id="payment-1" value="2">
                                                            <label for="payment-1">Pay with SSL Commerz
                                                                <span class="small-text">
                                                                    <img src="{{ asset('frontend/images/sslcommerz.png') }}" alt="" class="sslcommerz">
                                                                </span>
                                                            </label>
                                                        </div>
                                                    </li>
                                                </ul>   
                                            </div>
                                        </div>
                                        <div class="text-end">
                                            <button type="submit" id="submitBtn" class="btn-solid btn">Place Order</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- section end -->
@endsection



@section('page-script')
    <script>
        (function (window, document) {
            var loader = function () {
                var script = document.createElement("script"), tag = document.getElementsByTagName("script")[0];
                script.src = "https://sandbox.sslcommerz.com/embed.min.js?" + Math.random().toString(36).substring(7);
                tag.parentNode.insertBefore(script, tag);
            };

            window.addEventListener ? window.addEventListener("load", loader, false) : window.attachEvent("onload", loader);
        })(window, document);

        // Get all radio buttons and their associated spans
        let radioButtons = document.querySelectorAll('input[name="paymentMethod"]');
        let spans = document.querySelectorAll('.small-text');

        // Add change event listener to radio buttons
        radioButtons.forEach((radio, index) => {
            radio.addEventListener('change', () => {
                // Hide all spans
                spans.forEach((span) => {
                    span.style.display = 'none';
                });

                if (radio.checked) {
                    spans[index].style.display = 'block';
                }
            });
        });

    </script>

    {{-- country state district --}}
    <script>
        let country     = document.getElementById('country');
        let state       = document.getElementById('state');
        let district    = document.getElementById('district');
        let allOptions  = '';
        let countryId   = country.value;
        let stateId     = state.value;
        let methodOption = "";

        let allStateOptions = '';
        let allDistrictOptions = '';
        @if( (Auth::check()) && (!is_null(Auth::user()->country_id)) )
            if (countryId != 0 || countryId != '') {
                if ('{{ Auth::user()->country->name }}' !== "Bangladesh") {
                    $('.noShip').show();
                    $('.method').hide();
                    document.querySelector('.count2').innerText = "৳" + {{ App\Models\Cart::discountAmount()['totalAmount'] }};
                } else {
                    $('.noShip').hide();
                    $.get('get-qriour/', function(qData){
                        QAllData = JSON.parse(qData);
                        let Qoption = "";
                        if( QAllData.length > 0 ){
                            QAllData.forEach( (data) => {
                                methodOption +=  `
                                    <div class="shopping-option">
                                        <input type="radio" name="shipping" class="shippingCost${data.id}" id="shipping${data.id}" value="${data.provider_charge}">
                                        <label for="shipping${data.id}">${data.provider_name} ৳${data.provider_charge}</label>
                                    </div>
                                    `;
                            })
                            $('.method').html(methodOption);
                            $('.method input[type="radio"]').first().prop('checked', true).trigger('change');
                        }
                   })
                }

                // Fetch states based on the selected country
                fetch('/get-state/' + countryId)
                    .then(response => response.json())
                    .then(data => {
                        if (data.length != 0) {
                            data.forEach(stateData => {
                                allStateOptions += `<option value="${stateData.id}">${stateData.name}</option>`;
                            });
                            
                            state.innerHTML = allStateOptions;
                            state.removeAttribute('disabled');
                            // selected opiton
                            if ('{{ Auth::user()->division_id }}' !== "") {
                                state.value = '{{ Auth::user()->division_id }}';
                            }
                            let stateId = state.value;
                            // show shipping 
                            $.get('get-method/' + stateId, function(shipData){
                                shipAllData = JSON.parse(shipData);
                                let methodOption = "";
                                if( (stateId == shipAllData.base_id) ){
                                    methodOption +=  `
                                                    <div class="shopping-option">
                                                        <input type="radio" name="shipping" id="shipping" value="${shipAllData.base_charge}">
                                                        <label for="shipping">Inside ${state.options[state.selectedIndex].innerText} ৳${shipAllData.base_charge}</label>
                                                    </div>
                                                    <div class="shopping-option">
                                                        <input type="radio" name="shipping" id="free-shipping" value="0">
                                                        <label for="free-shipping">Local Pickup</label>
                                                    </div>`;
                                    $('.method').html(methodOption);
                                    $('.method input[type="radio"]').first().prop('checked', true).trigger('change');
                                }
                            })

                            // Fetch districts based on the selected state
                            fetch('/get-district/' + stateId)
                                .then(response => response.json())
                                .then(districtData => {
                                    if (districtData.length != 0) {
                                        districtData.forEach(district => {
                                            allDistrictOptions += `<option value="${district.id}">${district.name}</option>`;
                                        });
                                        district.innerHTML = allDistrictOptions;
                                        district.removeAttribute('disabled');
                                        // selected opiton
                                        if ('{{ Auth::user()->district_id }}' !== "") {
                                            district.value = '{{ Auth::user()->district_id }}';
                                        }
                                    } else {
                                        district.innerHTML = '<option value="">No district available in this state/division</option>';
                                        district.removeAttribute('disabled');
                                    }
                                })
                                .catch(err => {
                                    console.log(err.message);
                                });
                        } else {
                            state.innerHTML = '<option value="">No state available in this country</option>';
                            state.removeAttribute('disabled');
                        }
                    })
                    .catch(err => {
                        console.log(err.message);
                    });
            } else {
                state.innerHTML = '<option value="">Select your state name</option>';
                state.setAttribute('disabled', 'disabled');
                district.innerHTML ='<option value="">Select your district name</option>';
                district.setAttribute('disabled', 'disabled');
            }
        @else
            $('.noShip').show();
        @endif

        country.addEventListener('change', function(){
            countryId = this.value;
            let allStateOptions = '';
            let allDistrictOptions = '';
            let countryShipping = country.options[country.selectedIndex].innerText;

            // Clear the method options before fetching new ones
            $('.method').html('');

            if (countryShipping !== "Bangladesh") {
                $('.noShip').show();
                $('.method').hide();
                document.querySelector('.count2').innerText = "৳" + {{ App\Models\Cart::discountAmount()['totalAmount'] }};
            } else {
                $('.noShip').hide();
                $('.method').show();
                $.get('get-qriour/', function(qData){
                    QAllData = JSON.parse(qData);
                    let methodOption = "";
                    if( QAllData.length > 0 ){
                        QAllData.forEach( (data) => {
                            methodOption +=  `
                                <div class="shopping-option">
                                    <input type="radio" name="shipping" class="shippingCost" id="shipping${data.id}" value="${data.provider_charge}">
                                    <label for="shipping${data.id}">${data.provider_name} ৳${data.provider_charge}</label>
                                </div>
                            `;
                        })
                        $('.method').html(methodOption);
                        $('.method input[type="radio"]').first().prop('checked', true).trigger('change');
                    }
                })
            }

            // Fetch states based on the selected country
            if (countryId != 0 || countryId != '') {
                    fetch('/get-state/' + countryId)
                        .then(response => response.json())
                        .then(data => {
                            if (data.length != 0) {
                                data.forEach(stateData => {
                                    allStateOptions += `<option value="${stateData.id}">${stateData.name}</option>`;
                                });
                                state.innerHTML = allStateOptions;
                                state.removeAttribute('disabled');
                                let stateId = state.value;

                                // Fetch districts based on the selected state
                                fetch('/get-district/' + stateId)
                                    .then(response => response.json())
                                    .then(districtData => {
                                        if (districtData.length != 0) {
                                            districtData.forEach(district => {
                                                allDistrictOptions += `<option value="${district.id}">${district.name}</option>`;
                                            });
                                            district.innerHTML = allDistrictOptions;
                                            district.removeAttribute('disabled');
                                        } else {
                                            district.innerHTML = '<option value="">No district available in this state</option>';
                                            district.removeAttribute('disabled');
                                        }
                                    })
                                    .catch(err => {
                                        console.log(err.message);
                                    });
                            } else {
                                state.innerHTML = '<option value="">No state available in this country</option>';
                                state.removeAttribute('disabled');
                            }
                        })
                        .catch(err => {
                            console.log(err.message);
                        });
                } else {
                    state.innerHTML = '<option value="">Select your state name</option>';
                    state.setAttribute('disabled', 'disabled');
                    district.innerHTML ='<option value="">Select your district name</option>';
                    district.setAttribute('disabled', 'disabled');
                }
        });

        state.addEventListener('change', function(){
            stateId = this.value;
            let allDistrict = '';

            // shipping method
            $.get('get-method/' + stateId, function(shipData){
                shipAllData = JSON.parse(shipData);
                let methodOption = "";
                if (shipAllData && shipAllData.base_id) { // Check if shipAllData is not null and has a base_id property
                    methodOption +=  `
                        <div class="shopping-option">
                            <input type="radio" name="shipping" id="shipping" class="shippingCost" value="${shipAllData.base_charge}">
                            <label for="shipping">Inside ${state.options[state.selectedIndex].innerText} ৳${shipAllData.base_charge}</label>
                        </div>
                        <div class="shopping-option">
                            <input type="radio" name="shipping" id="free-shipping" class="shippingCost" value="0">
                            <label for="free-shipping">Local Pickup</label>
                        </div>`;
                    $('.method').html(methodOption);
                    $('.method input[type="radio"]').first().prop('checked', true).trigger('change');
                } else {
                    $.get('get-qriour/', function(qData){
                        QAllData = JSON.parse(qData);
                        let methodOption = "";
                        if( QAllData.length > 0 ){
                            QAllData.forEach( (data) => {
                                methodOption +=  `
                                    <div class="shopping-option">
                                        <input type="radio" name="shipping" class="shippingCost" id="shipping${data.id}" value="${data.provider_charge}">
                                        <label for="shipping${data.id}">${data.provider_name} ৳${data.provider_charge}</label>
                                    </div>
                                `;
                            })
                            $('.method').html(methodOption);
                            $('.method input[type="radio"]').first().prop('checked', true).trigger('change');
                        }
                    })
                }
            });

            if( stateId != 0 || stateId != '' ){
                fetch('/get-district/' + stateId)
                    .then(response => response.json())
                    .then(data => {
                        if( data.length != 0 ){
                                data.map(allData => {
                                allDistrict += `<option value="${allData.id}">${allData.name}</option>`;
                            });
                                district.innerHTML = allDistrict;
                                district.removeAttribute('disabled')
                            }else {
                                district.innerHTML ='<option value="">No district available in this state</option>';
                                district.removeAttribute('disabled')
                            }
                        })
                        .catch(err => {
                            console.log(err.message);
                        });
            }else {
                district.innerHTML ='<option value="">Select your district name</option>';
                district.setAttribute('disabled', 'disabled');
            }
        })

        // add shipping into the subtotal
        $('.method').on('change', 'input[type="radio"]', function() {
            let selectedValue = $(this).val();
            let totalAmount = parseFloat(selectedValue) + parseFloat({{ App\Models\Cart::discountAmount()['totalAmount'] }});
            document.querySelector('.count2').innerText = "৳" + totalAmount;
        });
        

    </script>

    {{-- apply coupon --}}
    <script>
        $(document).ready(function() {
            $(document).on('click', '#applyCupon', function() {
                var couponCode = $("#code").val().trim();
                if (couponCode.length == 0 ) {
                    toastr.warning("Please enter a coupon code", '', {"positionClass": "toast-top-right", "closeButton": true});
                    return;
                }
                
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: '{{ route("apply-coupon") }}',
                    type: 'post',
                    data: { code: couponCode },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === true) {
                            toastr.success("The Coupon code is applied", '', {"positionClass": "toast-top-right", "closeButton": true});
                            setTimeout(function() {
                                window.location.href = '{{ route("checkout") }}';
                            }, 2000);
                        } else {
                            toastr.error(response.message, '', {"positionClass": "toast-top-right", "closeButton": true});
                            $("#code").val('');
                            $('.cupon').load(location.href + ' .cupon > *');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error:", status, error);
                    }
                });
            });

            $(document).on('input', '#code', function() {
                if ($(this).val().trim() !== '') {
                    $('#applyCupon').prop('disabled', false);
                } else {
                    $('#applyCupon').prop('disabled', true);
                    toastr.warning("Please fill up this field!", '', {"positionClass": "toast-top-right", "closeButton": true});
                }
            });
        });


        $('#delCupon').click(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: '{{route("del-coupon")}}',
                type: 'post',
                dataType: 'json',
                success: function(){
                    
                }
            })
            toastr.success("The Coupon has been canceled", '', {"positionClass": "toast-top-right", "closeButton": true});
            setTimeout(function(){
                window.location.href = '{{route("checkout")}}';  
            }, 2000);
        })
    </script>

@endsection
 