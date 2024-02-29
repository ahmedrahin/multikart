@extends('backend.layout.template')

@section('page-title')
    <title>User Information || {{ !is_null($siteTitle = App\Models\Settings::site_title()) ? $siteTitle->site_title : 'Shop' }}</title>
@endsection

@section('page-css')
    <link rel="stylesheet" href="{{ asset('backend/css/custom.css') }}" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <style>
        .UpdateUser {
            display: block;
            width: 170px;
            height: 170px;
            border-radius: 50%;
            object-fit: cover;
            margin: auto;
            margin-bottom: 30px;
            margin-top: 15px;
        }
    </style>
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
                        <li class="breadcrumb-item active" aria-current="page">Edit User</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->
        <div class="row">
            <div class="col-12 d-flex">
                <div class="card radius-10 w-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                    <h5 class="heading">User Information</h5>
                    </div>

                    <div class="border p-3 radius-10">
                        <!-- Message -->
                        @include( 'backend.includes.message' )

                        <div class="container updateUser">
                            <div class="main-body">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="d-flex flex-column align-items-center text-center">
                                                    @if( !is_null($editData->image) )
                                                        <img src="{{ asset('uploads/user/' . $editData->image) }}" class="rounded-circle p-1 bg-primary" width="110">
                                                    @else
                                                        <img src="{{ asset('backend/images/user.jpg') }}" class="rounded-circle p-1 bg-primary" width="110">
                                                    @endif
                                                    <div class="mt-3">
                                                        <h4>{{ $editData->name }}</h4>
                                                        <p class="text-secondary mb-1">
                                                            @if( !is_null( $editData->country_id ) )
                                                                Country: {{ $editData->country->name }}
                                                            @else
                                                                Role:
                                                                @if( $editData->role == 1 )
                                                                    Admin
                                                                @elseif( $editData->role == 2 )
                                                                    User 
                                                                @else
                                                                    Sub Admin
                                                                @endif
                                                            @endif
                                                        </p>
                                                        <p class="text-muted font-size-sm">
                                                            Join Date: {{ date('M-d-Y', strtotime($editData->created_at)) }}
                                                        </p>
                                                        <button class="btn btn-primary">Follow</button>
                                                        <button class="btn btn-outline-primary">Message</button>
                                                    </div>
                                                </div>
                                                
                                                <hr class="my-4">
                                                <ul class="list-group list-group-flush">
                                                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                                        <h6 class="mb-0">
                                                            <i class="fadeIn animated bx bx-shopping-bag"></i>
                                                            Total Order: 
                                                        </h6>
                                                        <span class="text-secondary">
                                                            {{ App\Models\Order::where('user_id', $editData->id)->count() }}
                                                        </span>
                                                    </li>
                                                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                                        <h6 class="mb-0">
                                                            <i class="lni lni-cart-full"></i>
                                                            Cart Item: 
                                                        </h6>
                                                        <span class="text-secondary">
                                                            @php
                                                                $cartItem = App\Models\Cart::where('order_id', NULL)->where('user_id', $editData->id)->get();
                                                                echo $cartItem->count();
                                                            @endphp
                                                        </span>
                                                    </li>
                                                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                                        <h6 class="mb-0">
                                                            <i class="lni lni-heart"></i>
                                                            Wishlist Item: 
                                                        </h6>
                                                        <span class="text-secondary">
                                                            {{ App\Models\Wishlist::where('user_id', $editData->id)->count() }}
                                                        </span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-8">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row mb-3">
                                                    <div class="col-sm-3">
                                                        <h6 class="mb-0">Full Name</h6>
                                                    </div>
                                                    <div class="col-sm-9 text-secondary">
                                                        <input type="text" class="form-control" value="{{ $editData->name }}">
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-sm-3">
                                                        <h6 class="mb-0">Email</h6>
                                                    </div>
                                                    <div class="col-sm-9 text-secondary">
                                                        <input type="text" class="form-control" value="{{ $editData->email }}">
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-sm-3">
                                                        <h6 class="mb-0">Phone</h6>
                                                    </div>
                                                    <div class="col-sm-9 text-secondary">
                                                        <input type="text" class="form-control" value="{{ $editData->phone }}">
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-sm-3">
                                                        <h6 class="mb-0">Address</h6>
                                                    </div>
                                                    <div class="col-sm-9 text-secondary">
                                                        <input type="text" class="form-control" value="@if( !is_null($editData->address_line1) ){{ $editData->address_line1 }}, @if( !is_null($editData->address_line2) ) {{ $editData->address_line2 }}@endif @if( isset( $editData->district->id ) )@if( !is_null($editData->district_id) && $editData->district->status == 1){{ $editData->district->name }}, @if( isset( $editData->division_id ) )@if( !is_null($editData->division_id) && $editData->state->status == 1){{ $editData->state->name }}@endif @endif @endif @endif @else  @endif">
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-sm-3">
                                                        <h6 class="mb-0">Zip_code</h6>
                                                    </div>
                                                    <div class="col-sm-9 text-secondary">
                                                        <input type="text" class="form-control" value="@if(!is_null($editData->zipCode)) {{$editData->zipCode}} @endif">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h5 class="d-flex align-items-center mb-3">
                                                            Update Role/Status
                                                        </h5>
                                                        <form action="{{ route('update-user', $editData->id) }}" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label for="role">Select User Role</label>
                                                                        <select name="role" id="role" class="selectRole">
                                                                            <option value="">Select the User Role</option>
                                                                            <option value="1" {{ ($editData->role == 1) ? "selected" : "" }}>Admin</option>
                                                                            <option value="3" {{ ($editData->role == 3) ? "selected" : "" }}>Sub Admin</option>
                                                                            <option value="2" {{ ($editData->role == 2) ? "selected" : "" }}>User</option>
                                                                        </select>
                                                                        @error('role')
                                                                            <span class="text-danger"> {{ $message }} </span>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label for="status">Select User Status</label>
                                                                        <select name="status" id="status" class="selectStatus">
                                                                            <option value="">Select the User Role</option>
                                                                            <option value="1" {{ ($editData->status == 1) ? "selected" : "" }}>Active</option>
                                                                            <option value="2" {{ ($editData->status == 2) ? "selected" : "" }}>Inactive</option>
                                                                            <option value="3" {{ ($editData->status == 0) ? "selected" : "" }}>Disabled</option>
                                                                        </select>
                                                                        @error('status')
                                                                            <span class="text-danger"> {{ $message }} </span>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <input type="submit" name="submit" value="save changes" style="margin-top: 0">
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
                $(".selectRole").select2();
            });
            $(document).ready(function () {
                $(".selectStatus").select2();
            });
        </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var countryNameInput = document.querySelectorAll('.disbledField');

            // Prevent changes using JavaScript
            countryNameInput.addEventListener('input', function(event) {
                event.preventDefault();
                return false;
            });
        });
    </script>
@endsection
