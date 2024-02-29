@extends('frontend.layout.withoutHeaderFooter')

@section('page-title')
    <title>Order Invoice || Multikart</title>
@endsection

@section('page-css')
    
@endsection

@section('body-content')

  <!-- invoice start -->
  <section class="theme-invoice-5 section-b-space">
    <div class="container">
      <div class="row">
        <div class="col-xl-9 m-auto">
          <div class="invoice-wrapper">
            <div class="invoice-header">
              <img src="{{ asset('frontend/images/invoice/bg4.jpg') }}" class="img-fluid background-img" alt="">
              <div class="row">
                <div class="col-md-2 order-md-3 mb-md-0 mb-2">
                  <h2>invoice</h2>
                </div>
                <div class="col-lg-5 col-md-4 col-sm-6">
                  <div class="address-detail">
                    <div>
                      <h4 class="mb-2" style="line-height: 26px;">
                          {{ $orders->addressLine1 }}
                          <br>
                          @if( !is_null($orders->addressLine2) )
                             {{ $orders->addressLine2 }} - 
                          @endif
                          {{$orders->zip_code}}
                      </h4>
                      <h4>Call: {{ $orders->phone }}</h4>
                    </div>
                  </div>
                </div>
                <div class="col-md-5 col-sm-6">
                  <ul class="date-detail">
                    <li><span>Order date :</span>
                      <h4> {{ $orders->order_date }} </h4>
                    </li>
                    <li><span>issue date :</span>
                      <h4> 
                        @php
                          $order_date = \Carbon\Carbon::parse($orders->order_date);
                          $expct_date = $order_date->copy()->addDays(3)->format('M-d-y');
                          echo $expct_date;
                        @endphp
                      </h4>
                    </li>
                    <li><span>Invoice No.</span>
                      <h4 style="text-transform: lowercase">#{{ $orders->id }}</h4>
                    </li>
                    <li><span>email :</span>
                      <h4 style="text-transform: lowercase">{{ $orders->email }}</h4>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="invoice-body">
              <div class="header-panel">
                <ul>
                  <li>
                    <img src="{{ asset('frontend/images/icon/logo.png') }}" class="img-fluid" alt="">
                  </li>
                  <li>
                    <i class="fa fa-map" aria-hidden="true"></i>
                    <div>
                      <h4>multikart store</h4>
                      <h4 class="mb-0">Feni, Bangladesh</h4>
                    </div>
                  </li>
                  <li>
                    <i class="fa fa-phone" aria-hidden="true"></i>
                    <div>
                      @php
                          $call_1 = \App\Models\Settings::call_1();
                      @endphp
                      @if($call_1 && !empty($call_1->number1))
                          <h4>{{$call_1->number1}}</h4>
                      @else
                        <h4>+1-202-555-0144</h4>
                      @endif

                      @php
                          $call_2 = \App\Models\Settings::call_2();
                      @endphp
                      @if($call_2 && !empty($call_1->number2))
                          <h4 class="mb-0">{{$call_2->number2}}</h4>
                      @else
                        <h4 class="mb-0">+1-202-555-0117</h4>
                      @endif
                    </div>
                  </li>
                </ul>
              </div>
              <div class="table-responsive-md">
                <table class="table table-borderless mb-0">
                  <thead>
                    <tr>
                      <th scope="col">Sl.</th>
                      <th scope="col">Image</th>
                      <th scope="col">Product Title</th>
                      <th scope="col">price</th>
                      <th scope="col">Quantity</th>
                      <th scope="col">total</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php $sl = 0; @endphp
                    @foreach( $items as $item )
                      <tr>
                          <th>{{ ++$sl }}</th>
                          <td>
                            @if( !is_null( $item->product->thumb_image ) )
                                <div>
                                    <a href="{{ route('product-details', $item->product->slug) }}">
                                        <img src="{{asset('uploads/product/thumb_image/' . $item->product->thumb_image )}}" alt="" class="in_img">
                                    </a>
                                </div>
                            @else
                                <div>
                                    <a href="{{ route('product-details', $item->product->slug) }}">
                                        <img src="{{asset('frontend/images/null.jpg')}}" alt="" class="in_img">
                                    </a>
                                </div>
                            @endif
                          </td>
                          <td>{{ $item->product->title }}</td>
                          <td>
                            ৳ {{ $item->prdtc_unt_pri }}
                          </td>
                          <td>{{ $item->product_quantity }}</td>
                          <td>
                            ৳ {{ $item->prdtc_unt_pri }}
                          </td>
                      </tr>
                    @endforeach
                  </tbody>

                  <tfoot>
                    <tr>
                      <td colspan="3"></td>
                      <td class="font-bold text-dark" colspan="2">GRAND TOTAL</td>
                      <td class="font-bold text-theme">৳{{ $orders->amount }}</td>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
            <div class="invoice-footer text-end">
              <div class="authorise-sign">
                <img src="{{ asset('frontend/images/invoice/sign.png') }}" class="img-fluid" alt="sing">
                <span class="line"></span>
                <h6>Authorised Sign</h6>
              </div>
              <div class="buttons">
                <a href="#" class="btn black-btn btn-solid rounded-2 me-2" onclick="window.print();">export as PDF</a>
                <a href="#" class="btn btn-solid rounded-2" onclick="window.print();">print</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- invoice end -->

@endsection

@section('page-script')

@endsection
         