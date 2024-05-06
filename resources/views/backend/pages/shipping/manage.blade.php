@extends('backend.layout.template')

@section('page-title')
    <title>All Shipping Method List || {{ !is_null($siteTitle = App\Models\Settings::site_title()) ? $siteTitle->site_title : 'Shop' }}</title>
@endsection

@section('page-css')
    <link rel="stylesheet" href="{{ asset('backend/css/custom.css') }}"/>
    {{-- <link rel="stylesheet" href="{{ asset('backend/css/table.css') }}"/> --}}
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
       input[type="checkbox"] {
            width: 40px !important;
            height: 16px;
            padding: 0;
        }
        .form-check-input:checked {
            background-color: #0d6efd !important;
            border-color: #0d6efd !important;
        }
        .form-check-input:focus {
            box-shadow: none;
        }
        .form-check {
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
@endsection

@section('body-content')
    <div class="page-content shipping"> 
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
                        <li class="breadcrumb-item active" aria-current="page">Shipping List</li>
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
                                <h5 class="heading">Base Shipping Method</h5>
                            </div>
                            <div class="col-6">
                                <button type="button" class="btn add btn-sm btn-primary pull-left" data-bs-toggle="modal" data-bs-target="#addBaseShipping">
                                    <i class="fa fa-plus-circle"></i> 
                                    Add New
                                </button>
                            </div>
                        </div>
                        
                        @if( $base_shipping->count() > 0 )
                            <table class="table mb-0 table-striped">
                                <thead>
                                    <tr>
                                        <th>Sl.</th>
                                        <th>Base Location</th>
                                        <th>Charge Ammount</th>
                                        <th>Active Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $sl = 0; @endphp
                                    @foreach ($base_shipping as $base_shipping_item)
                                        <tr>
                                            <th>{{ ++$sl }}</th>
                                            <td>{{ $base_shipping_item->state->name }}</td>
                                            <td>{{ $base_shipping_item->base_charge }}</td>
                                            <td>
                                                @if( $base_shipping_item->status == 1 )
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input status-toggle" type="checkbox" data-shipping-id="{{ $base_shipping_item->id }}" checked>
                                                    </div>
                                                @elseif( $base_shipping_item->status == 2 )
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input status-toggle" type="checkbox" data-shipping-id="{{ $base_shipping_item->id }}">
                                                    </div>
                                                @else 
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input status-toggle" type="checkbox" data-shipping-id="{{ $base_shipping_item->id }}" checked>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <form class="btn btn-primary">
                                                        <button type="button" data-bs-toggle="modal" data-bs-target="#editBaseShipping{{$base_shipping_item->id}}">Edit</button>
                                                    </form>
                                                    <form action="{{ route('destroy-shipping', $base_shipping_item->id) }}" class="btn btn-danger" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit">Delete</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        <!-- Modal -->
                                        <div class="modal fade" id="editBaseShipping{{$base_shipping_item->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">
                                                            Edit Base Shipping Method
                                                        </h5>
                                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ route('shipping-update', $base_shipping_item->id) }}" method="post">
                                                            @csrf
                                                            <div class="row">
                                                                <div class="mb-2">
                                                                    <label for="base_location">Base Location</label>
                                                                    @php
                                                                        $editBase_method = App\Models\Shipping::where('id', $base_shipping_item->id)->first();
                                                                    @endphp
                                                                    <select name="base_location" id="base_location">
                                                                        <option value="">Select the base locaiton</option>
                                                                        @foreach( $state as $allState )
                                                                            <option value="{{ $allState->id }}" {{ ($editBase_method->base_id == $allState->id ) ? 'selected' : '' }}>{{ $allState->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="mb-2">
                                                                    <label for="charge">Charge Amount</label>
                                                                    <input type="number" value="{{ $base_shipping_item->base_charge }}" name="charge" id="charge" placeholder="Shipping Charge">
                                                                </div>
                                                                <div class="mb-2">
                                                                    <label for="charge">Active Status</label>
                                                                    <select name="status" id="base_location">
                                                                        <option value="0">Select active status</option>
                                                                        <option value="1" {{ ($base_shipping_item->status == 1) ? 'selected' : '' }}>Active</option>
                                                                        <option value="2" {{ ($base_shipping_item->status == 2) ? 'selected' : '' }}>Inactive</option>
                                                                    </select>
                                                                </div>
                                                                <input type="submit" value="Save Changes">
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="alert alert-danger mt-8">
                                Opps!! No Data Found.
                            </div>
                        @endif
                        <!-- Modal -->
                        <div class="modal fade" id="addBaseShipping" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">
                                            Add Base Shipping Method
                                        </h5>
                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('shipping-store') }}" method="post" name="addBaseShipping">
                                            @csrf
                                            <div class="row">
                                                <div class="mb-3">
                                                    <label for="baseLocation">Base Location</label>
                                                    <select name="base_location" id="baseLocation">
                                                        <option value="">Select the base location</option>
                                                        
                                                        @php
                                                            $base_shippings = App\Models\Shipping::where('provider_name', NULL)->get();
                                                        @endphp
                                                    
                                                        @foreach($state as $allState)
                                                            @php
                                                                $isHidden = false;
                                                            @endphp
                                                            @foreach($base_shippings as $base_shipping)
                                                                @if($base_shipping->base_id == $allState->id)
                                                                    @php
                                                                        $isHidden = true;
                                                                        break;
                                                                    @endphp
                                                                @endif
                                                            @endforeach
                                                            <option value="{{ $allState->id }}" @if($isHidden) hidden @endif>{{ $allState->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <span class="text-danger"></span>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="chargeBase">Charge Amount</label>
                                                    <input type="number" name="charge" id="chargeBase" placeholder="Shipping Charge">
                                                    <span class="text-danger charge"></span>
                                                </div>
                                                <div class="mb-2">
                                                    <label for="">Active Status</label>
                                                    <select name="status">
                                                        <option value="0">Select active status</option>
                                                        <option value="1">Active</option>
                                                        <option value="2">Inactive</option>
                                                    </select>
                                                </div>
                                                <input type="submit" name="submit" value="Add Shipping">
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

        <br>
        {{-- shipping method --}}
        <div class="row">
            <div class="col-12 d-flex">
                <div class="card radius-10 w-100">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <h5 class="heading">Regular Shipping Method</h5>
                            </div>
                            <div class="col-6">
                                <button type="button" class="btn add btn-sm btn-primary pull-left" data-bs-toggle="modal" data-bs-target="#addShipping">
                                    <i class="fa fa-plus-circle"></i> 
                                    Add New
                                </button>
                            </div>
                        </div>
                        
                        @if( $shipping->count() > 0 )
                            <table class="table mb-0 table-striped">
                                <thead>
                                    <tr>
                                        <th>Sl.</th>
                                        <th>Base Location</th>
                                        <th>Charge Ammount</th>
                                        <th>Active Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $sl = 0; @endphp
                                    @foreach ($shipping as $shippings)
                                        <tr>
                                            <th>{{ ++$sl }}</th>
                                            <td>{{ $shippings->provider_name }}</td>
                                            <td>{{ $shippings->provider_charge }}</td>
                                            <td>
                                                @if( $shippings->status == 1 )
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input status-toggle" type="checkbox" data-shipping-id="{{ $shippings->id }}" checked>
                                                    </div>
                                                @elseif( $shippings->status == 2 )
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input status-toggle" type="checkbox" data-shipping-id="{{ $shippings->id }}">
                                                    </div>
                                                @else 
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input status-toggle" type="checkbox" data-shipping-id="{{ $shippings->id }}" checked>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <form class="btn btn-primary">
                                                        <button type="button" data-bs-toggle="modal" data-bs-target="#editShipping{{$shippings->id}}">Edit</button>
                                                    </form>
                                                    <form action="{{ route('destroy-shipping', $shippings->id) }}" class="btn btn-danger" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit">Delete</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        <!-- Modal -->
                                        <div class="modal fade" id="editShipping{{$shippings->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">
                                                            Edit Shipping Method
                                                        </h5>
                                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ route('curiour-update', $shippings->id) }}" method="post">
                                                            @csrf
                                                            <div class="row">
                                                                @php
                                                                    $edit_method = App\Models\Shipping::where('id', $shippings->id)->first();
                                                                @endphp
                                                                <div class="mb-2">
                                                                    <label for="base_location">Provider Name</label>
                                                                    <input type="text" name="providerName" id="charge" placeholder="Provider Name" value="{{ $edit_method->provider_name }}">
                                                                    <span class="text-danger"></span>
                                                                </div>

                                                                <div class="mb-2">
                                                                    <label for="charge">Charge Amount</label>
                                                                    <input type="number" name="shippingCharge" id="charge" placeholder="Shipping Charge" value="{{ $edit_method->provider_charge }}">
                                                                    <span class="text-danger charge"></span>
                                                                </div>

                                                                <div class="mb-2">
                                                                    <label for="charge">Active Status</label>
                                                                    <select name="status" id="base_location">
                                                                        <option value="0">Select active status</option>
                                                                        <option value="1" {{ ($edit_method->status == 1) ? 'selected' : '' }}>Active</option>
                                                                        <option value="2" {{ ($edit_method->status == 2) ? 'selected' : '' }}>Inactive</option>
                                                                    </select>
                                                                </div>
                                                                <input type="submit" value="Save Changes">
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="alert alert-danger mt-8">
                                Opps!! No Data Found.
                            </div>
                        @endif
                        <!-- Modal -->
                        <div class="modal fade" id="addShipping" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">
                                            Add Shipping Method
                                        </h5>
                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('curiour-store') }}" method="post" name="addShipping">
                                            @csrf
                                            <div class="row">
                                                <div class="mb-2">
                                                    <label for="providerName">Provider Name</label>
                                                    <input type="text" name="providerName" id="providerName" placeholder="Provider Name">
                                                    <span class="text-danger"></span>
                                                </div>
                                                <div class="mb-2">
                                                    <label for="shippingCharge">Charge Amount</label>
                                                    <input type="number" name="shippingCharge" id="shippingCharge" placeholder="Shipping Charge">
                                                    <span class="text-danger shippingCharge"></span>
                                                </div>
                                                <div class="mb-2">
                                                    <label for="charge">Active Status</label>
                                                    <select name="status" id="charge">
                                                        <option value="0">Select active status</option>
                                                        <option value="1">Active</option>
                                                        <option value="2">Inactive</option>
                                                    </select>
                                                </div>
                                                <input type="submit" name="submit" value="Add Shipping">
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
    <script>
        let addBaseShipping = document.forms['addBaseShipping'];
        function displayErrorMessage(field, message) {
            field.nextElementSibling.innerText = message;
            toastr.warning(message, '', {"positionClass": "toast-top-right", "closeButton": true});
        }

        addBaseShipping.addEventListener('submit', function(e){
            let baseLocation = document.querySelector('#baseLocation');
            let chargeBase = document.querySelector('#chargeBase');

            if (baseLocation.value == '' && chargeBase.value == '') {
                e.preventDefault();
                displayErrorMessage(baseLocation, 'Please select the base location');
                displayErrorMessage(chargeBase, 'Please select an amount');
            } else if (baseLocation.value == '') {
                e.preventDefault();
                displayErrorMessage(baseLocation, 'Please select the base location');
            } else if (chargeBase.value == '') {
                e.preventDefault();
                displayErrorMessage(chargeBase, 'Please select an amount');
            } else {
                toastr.clear();
            }
        });

        document.querySelector('#baseLocation').addEventListener('input', function() {
            toastr.clear();
            this.nextElementSibling.innerText = '';
        });

        document.querySelector('#chargeBase').addEventListener('input', function() {
            toastr.clear();
            document.querySelector('.charge').innerText = '';
        });

    </script>

    <script>
        let addShipping = document.forms['addShipping'];
        function displayErrorMessage(field, message) {
            field.nextElementSibling.innerText = message;
            toastr.warning(message, '', {"positionClass": "toast-top-right", "closeButton": true});
        }

        addShipping.addEventListener('submit', function(e){
            let providerName = document.querySelector('#providerName');
            let shippingCharge = document.querySelector('#shippingCharge');

            if (providerName.value == '' && shippingCharge.value == '') {
                e.preventDefault();
                displayErrorMessage(providerName, 'Please select the provider name');
                displayErrorMessage(shippingCharge, 'Please select an amount');
            } else if (providerName.value == '') {
                e.preventDefault();
                displayErrorMessage(providerName, 'Please select the base location');
            } else if (shippingCharge.value == '') {
                e.preventDefault();
                displayErrorMessage(shippingCharge, 'Please select an amount');
            } else {
                toastr.clear();
            }
        });

        document.querySelector('#providerName').addEventListener('input', function() {
            toastr.clear();
            this.nextElementSibling.innerText = '';
        });

        document.querySelector('#shippingCharge').addEventListener('input', function() {
            toastr.clear();
            document.querySelector('.shippingCharge').innerText = '';
        });

        let close = document.querySelectorAll('.close');
        close.forEach( (e) => {
            e.addEventListener('click', () => {
                toastr.clear();
                document.querySelector('.charge').innerText = '';
                document.querySelector('#baseLocation').nextElementSibling.innerText = '';
                document.querySelector('#providerName').nextElementSibling.innerText = '';
                document.querySelector('.shippingCharge').innerText = '';
            })
        } )

    </script>

    {{-- active status --}}
    {{-- change status --}}
    <script>
        $(document).ready(function() {
            $('.status-toggle').change(function() {
                var id = $(this).data('shipping-id');
                var status = $(this).prop('checked') ? 1 : 2;

                // Send AJAX request
                $.ajax({
                    type: 'PUT',
                    url: '/admin/shipping-methods/shipping-status/' + id, 
                    data: {
                        _token: '{{ csrf_token() }}',
                        status: status
                    },
                    success: function(response) {
                        if( response )
                        toastr[response.type](response.msg, '', {"positionClass": "toast-top-right", "closeButton": true});
                    },
                    error: function(xhr, status, error) {
                        // Handle error here
                        console.error(xhr.responseText);
                    }
                });
            });
        });

    </script>

@endsection
