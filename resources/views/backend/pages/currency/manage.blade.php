@extends('backend.layout.template')

@section('page-title')
    <title>Currency Setting || {{ !is_null($siteTitle = App\Models\Settings::site_title()) ? $siteTitle->site_title : 'Shop' }}</title>
@endsection

@section('page-css')
    <link rel="stylesheet" href="{{ asset('backend/css/custom.css') }}"/>
    {{-- <link rel="stylesheet" href="{{ asset('backend/css/table.css') }}"/> --}}
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
@endsection

@section('body-content')
    <div class="page-content shipping currency"> 
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
                        <li class="breadcrumb-item active" aria-current="page">Currency List</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->

        {{-- base shipping method --}}
        <div class="row">
            <div class="col-12 d-flex">
                <div class="card radius-10 w-100">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <h5 class="heading">Currency List</h5>
                            </div>
                            <div class="col-6">
                                <button type="button" class="btn add btn-sm btn-primary pull-left" data-bs-toggle="modal" data-bs-target="#addCurrency">
                                    <i class="fa fa-plus-circle"></i> 
                                    Add New
                                </button>
                            </div>
                        </div>

                        <hr>
                        
                        @if( $currencyList->count() > 0 )
                            <table class="table mb-0 table-striped">
                                <thead>
                                    <tr>
                                        <th>Sl.</th>
                                        <th>Currency Name</th>
                                        <th>Sign</th>
                                        <th>Exchange Rate</th>
                                        <th>Active Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $sl = 0; @endphp
                                    @foreach ($currencyList as $currency)
                                        <tr>
                                            
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="alert alert-danger mt-8">
                                Opps!! No Data Found.
                            </div>
                        @endif
                        <!-- Modal -->
                        <div class="modal fade" id="addCurrency" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">
                                            Add New Currency
                                        </h5>
                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('currency-add.edit') }}" method="post" name="">
                                            @csrf
                                            <div class="row">
                                                <div class="mb-2">
                                                    <label for="currencyName">Currency Name</label>
                                                    <input type="text" name="currencyName" id="currencyName" placeholder="Currency Name">
                                                    <span class="text-danger"></span>
                                                </div>
                                                <div class="mb-2">
                                                    <label for="exchangeRate">Exchange Rate</label>
                                                    <input type="text" name="exchangeRate" id="exchangeRate" placeholder="Exchange Rate">
                                                    <span class="text-danger"></span>
                                                </div>
                                                <div class="">
                                                    <label>Currency Sign</label>
                                                    <select name="sign">
                                                        <option value="">Select the Currency Sign</option>
                                                        <option value="$">$(Dollar)</option>
                                                        <option value="৳">৳(Taka)</option>
                                                        <option value="₤">₤(Pound)</option>
                                                        <option value="₠">₠(Euro)</option>
                                                        <option value="ر">ر(SAR)</option>
                                                    </select>
                                                    <span class="text-danger"></span>
                                                </div>
                                                <input type="submit" name="submit" value="Add Currency">
                                            </div>
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
    {{-- validation --}}
    
@endsection
