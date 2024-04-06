@extends('frontend.layout.template')

@section('page-title')
    <title> Cart || Multikart</title>
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
                        <h2>cart</h2>
                    </div>
                </div>
                <div class="col-sm-6">
                    <nav aria-label="breadcrumb" class="theme-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                            <li class="breadcrumb-item active">cart</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb End -->

    <!--section start-->
    <section class="cart-section section-b-space">
        <div class="container">
            <div class="row">
                @if( App\Models\Cart::totalQunt() != 0 )
                    <div class="col-sm-12">
                        <!-- <div class="cart_counter">
                            <div class="countdownholder">
                                Your cart will be expired in<span id="timer"></span> minutes!
                            </div>
                            <a href="checkout.html" class="cart_checkout btn btn-solid btn-xs">check out</a>
                        </div> -->
                    </div>
                    <div class="col-sm-12 table-responsive-xs cartLists">
                        <table class="table cart-table">
                            <thead>
                                <tr class="table-head">
                                    <th scope="col">action</th>
                                    <th scope="col">image</th>
                                    <th scope="col">product name</th>
                                    <th scope="col">price</th>
                                    <th scope="col">quantity</th>                                   
                                    <th scope="col">total</th>
                                </tr>
                            </thead>
                            <tbody id="cartItems">
                                {{-- cart items --}}
                                @include('frontend.pages.order.cartItem')
                                {{-- loader --}}
                                <div class="loader">
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                </div>
                            </tbody>
                        </table>
                        
                        <div class="table-responsive-md">
                            <table class="table cart-table ">
                                <tfoot>
                                    <tr>
                                        <td>total price :</td>
                                        <td>
                                            <h2 id="cartsAmn">
                                                ৳{{ App\Models\Cart::totalAmount() }}
                                            </h2>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                @else
                    <div class="bg bg-warning">Sorry!! No Item Added Into Cart!</div>
                @endif
            </div>
            <div class="row cart-buttons">
                <div class="col-6"><a href="{{ url('/all-products') }}" class="btn btn-solid">continue shopping</a></div>
                    <div class="col-6">
                        @if( App\Models\Cart::totalQunt() != 0 )
                            <a href="{{ url('/checkout') }}" class="btn btn-solid">check out</a>
                        @endif
                    </div>
            </div>
        </div>
    </section>
    <!--section end-->
@endsection

@section('page-script')
    <script src="{{ asset('frontend/js/timer1.js') }}"></script>

    {{-- counter --}}
    <script>
        $(document).ready(function() {
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
        });
    </script>
@endsection