@extends('backend.layout.template')

@section('page-title')
    <title>Order Details || {{ !is_null($siteTitle = App\Models\Settings::site_title()) ? $siteTitle->site_title : 'Shop' }}</title> 
@endsection

@section('page-css')
    <link rel="stylesheet" href="{{ asset('backend/css/custom.css') }}"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
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
                        <li class="breadcrumb-item active" aria-current="page">Order Details</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->

        <div class="col-12 d-flex">
            <div class="card radius-10 w-100">
                <div class="card-body">
                    <!-- Message -->
                    @include( 'backend.includes.message' )
                    <div class="d-flex align-items-center mb-3">
                        <h5 class="heading">Order Details</h5>
                    </div>

                    <div class=" mb-3 border p-3 radius-10">
                       <div class="row order">
                        {{-- customer details --}}
                            <div class="col-md-5 col-lg-5">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="information-box mb-3">
                                            <div class="table-responsive order-details">
                                                <h5 class="h5">Customer Details</h5>
                                                <table class="table table-bordered">
                                                    <thead class="">
                                                        <tr>
                                                            <th>Customer Name</th>
                                                            <td>{{ $editData->user->name }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Email</th>
                                                            <td>{{ $editData->email }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Phone</th>
                                                            <td>{{ $editData->phone }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Address</th>
                                                            <td>
                                                                {{ $editData->addressLine1 }}
                                                                @if( !is_null($editData->addressLine2))
                                                                    ,{{$editData->addressLine2}}
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>State / Divsion</th>
                                                            <td>{{ $editData->state->name }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>District</th>
                                                            <td>{{ $editData->district->name }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Country</th>
                                                            <td>{{ $editData->country->name }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Zip Code</th>
                                                            <td>{{ $editData->zip_code }}</td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
        
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            {{-- product details --}}
                            <div class="col-md-7 col-lg-7">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="information-box mb-3">
                                            <div class="table-responsive order-details">
                                                <h5 class="h5">Product Details</h5>
                                                @if( !is_null($editData->cupon_code) )
                                                    <table class="table table-bordered">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th>Sl.</th>
                                                                <th>Product Title</th>
                                                                <th>Unit Price</th>
                                                                <th>Quantity</th>
                                                                <th>Total</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @php $sl = 0; @endphp
                                                            @foreach( $items as $item )
                                                                <tr>
                                                                    <td>{{++$sl}}</td>
                                                                    <td>
                                                                        <a href="{{route('product-detail', $item->product->id)}}" style="color:#172b4d;" target="_blank">
                                                                            {{ $item->product->title }}
                                                                        </a>
                                                                    </td>
                                                                    <td>৳{{ $item->prdtc_unt_pri }}</td>
                                                                    <td>{{ $item->product_quantity }}</td>
                                                                    <td>৳{{ $item->prdtc_unt_pri * $item->product_quantity }}</td>
                                                                </tr>
                                                            @endforeach
                                                            <tr>
                                                                <td colspan="3"></td>
                                                                <th>Total Amount</th>
                                                                <th>৳{{ $editData->amount }}</th>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="3"></td>
                                                                <th>Paid Amount</th>
                                                                <th>৳{{ $editData->paid_amount }}</th>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="3"></td>
                                                                <th>Discount Amount</th>
                                                                <th style="color: #ff0000c7">- ৳{{ $editData->discount_amount }}</th>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="3"></td>
                                                                <th>Due Amount</th>
                                                                <th>৳{{ ($editData->paid_amount == 0) ? $editData->amount - $editData->discount_amount  : "0"  }}</th>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                @else
                                                    <table class="table table-bordered">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th>Sl.</th>
                                                                <th>Product Title</th>
                                                                <th>Unit Price</th>
                                                                <th>Quantity</th>
                                                                <th>Total</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @php $sl = 0; @endphp
                                                            @foreach( $items as $item )
                                                                <tr>
                                                                    <td>{{++$sl}}</td>
                                                                    <td>{{ $item->product->title }}</td>
                                                                    <td>৳{{ $item->prdtc_unt_pri }}</td>
                                                                    <td>{{ $item->product_quantity }}</td>
                                                                    <td>৳{{ $item->prdtc_unt_pri * $item->product_quantity }}</td>
                                                                </tr>
                                                            @endforeach
                                                            <tr>
                                                                <td colspan="3"></td>
                                                                <th>Total Amount</th>
                                                                <th>৳{{ $editData->amount }}</th>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="3"></td>
                                                                <th>Paid Amount</th>
                                                                <th>৳{{ $editData->paid_amount }}</th>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="3"></td>
                                                                <th>Due Amount</th>
                                                                <th>৳{{ $editData->amount - $editData->paid_amount }}</th>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            {{-- order details --}}
                            <div class="col-12 mb-3">
                                <div class="information-box">
                                    <div class="table-responsive order-details">
                                        <h5 class="h5">Order Details</h5>
                                        <table class="table table-bordered">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Order Id</th>
                                                    <th>Transaction_id</th>
                                                    <th>Coupon Code</th>
                                                    <th>Payment Method</th>
                                                    <th>Shipping Cost</th>
                                                    <th>Order Time</th>
                                                    <th>Order Date</th>
                                                    <th>Issue Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>#{{ $editData->id }}</td>
                                                    <td>{{ $editData->transaction_id }}</td>
                                                    <td>
                                                        @if( !is_null($editData->cupon_code) )
                                                            {{ $editData->cupon_code }}
                                                        @else
                                                            <span style="text-align: center;display:block;">-</span>
                                                        @endif
                                                    </td>
                                                    <td style="text-align: center;">
                                                        @if( $editData->paid_amount == 0 )
                                                            <div class="badge rounded-pill text-info bg-light-info p-2 text-uppercase px-3"><i class="bx bxs-circle me-1"></i>Cash on delivery</div>
                                                        @else
                                                        <div class="badge rounded-pill text-success bg-light-success p-2 text-uppercase px-3"><i class="bx bxs-circle me-1"></i>Pay with SSL</div>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if( $editData->shipping_method == 0 )
                                                            Local Pickup
                                                        @else
                                                            {{$editData->shipping_method}}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @php
                                                            $messageTime = Carbon\Carbon::parse($editData->order_time);
                                                            $timeDiff = $messageTime->diffInSeconds();
                                                            
                                                            if ($timeDiff < 60) {
                                                                echo $timeDiff . ' sec ago';
                                                            } elseif ($timeDiff < 3600) {
                                                                echo $messageTime->diffInMinutes() . ' min ago';
                                                            } elseif ($timeDiff < 86400) {
                                                                echo $messageTime->diffInHours() . ' hr ago';
                                                            } elseif ($timeDiff < 31536000) {
                                                                echo $messageTime->diffInDays() . ' days ago';
                                                            } else {
                                                                echo $messageTime->diffInYears() . ' years ago';
                                                            }
                                                        @endphp
                                                    </td>
                                                    <td>{{ $editData->order_date }}</td>
                                                    <td>{{ $expected_date }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            {{-- update status --}}
                            <div class="col-md-4">
                                <div class="information-box">
                                   <div class="table-responsive order-details">
                                       <h5 class="h5">Update Order Status</h5>
                                       <table class="table table-bordered">
                                           <thead class="table-light">
                                               <tr>
                                                   <th>Current Status</th>
                                                   <th style="text-align: center">
                                                       @if($editData->status == "Pending")
                                                           <div class="badge rounded-pill text-secondary bg-light-secondary p-2 text-uppercase px-3 pending">
                                                               <i class="bx bxs-circle me-1"></i>Pending
                                                           </div>
                                                       @elseif($editData->status == "Processing")
                                                           <div class="badge rounded-pill text-info bg-light-info p-2 text-uppercase px-3">
                                                               <i class="bx bxs-circle me-1"></i>Processing
                                                           </div>
                                                       @elseif($editData->status == "Completed")
                                                           <div class="badge rounded-pill text-success bg-light-success p-2 text-uppercase px-3">
                                                               <i class="bx bxs-circle me-1"></i>Completed
                                                           </div>
                                                       @elseif($editData->status == "Canceled")
                                                           <div class="badge rounded-pill text-warning bg-light-warning p-2 text-uppercase px-3">
                                                               <i class="bx bxs-circle me-1"></i>Canceled
                                                           </div>
                                                       @endif
                                                   </th>
                                               </tr>
                                           </thead>
                                       </table>

                                       <form action="{{ route('order-update', $editData->id) }}" method="post" style="padding: 0">
                                           @csrf
                                           @method('PATCH')
                                           <select name="status" id="status" class="select2 mb-1">
                                               <option value="">Select Order Status</option>
                                               <option value="Pending" {{ ( $editData->status == 'Pending' ) ? "selected" : "" }} >Pending</option>
                                               <option value="Processing" {{ ( $editData->status == 'Processing' ) ? "selected" : "" }}>Processing</option>
                                               <option value="Completed" {{ ( $editData->status == 'Completed' ) ? "selected" : "" }}>Completed</option>
                                               <option value="Canceled" {{ ( $editData->status == 'Canceled' ) ? "selected" : "" }}>Canceled</option>
                                           </select>
                                           @error('status')
                                               <span class="text-danger">{{ $message }}</span>
                                           @enderror
                                           <input type="submit" name="submit" value="Change Status">
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

@endsection

@section('page-script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            $(".select2").select2();
        });
    </script>
@endsection		