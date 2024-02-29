@extends('backend.layout.template')

@section('page-title')
    <title>Edit Country || {{ !is_null($siteTitle = App\Models\Settings::site_title()) ? $siteTitle->site_title : 'Shop' }}</title>
@endsection

@section('page-css')
    <link rel="stylesheet" href="{{ asset('backend/css/custom.css') }}" />
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
                        <li class="breadcrumb-item active" aria-current="page">Edit Country</li>
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
                    <h5 class="heading">Update Country Information</h5>
                    </div>

                    <div class=" mb-3 border p-3 radius-10">
                        <!-- Message -->
                        @include( 'backend.includes.message' )
                        <form action="{{ route('update-country', $editData->id) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="name">Country Name</label>
                                <input type="text" name="name" id="name" value="{{ $editData->name }}" placeholder="Enter Country Name" value="{{ old('name') }}" class="@error('name') is-invalid @enderror">
                                @error('name')
                                    <span class="text-danger"> {{ $message }} </span>
                                @enderror
                            </div>
                            <div>
                                <input type="submit" name="submit" value="save changes">
                            </div>
                        </form>
                    </div>
    
                </div>
                </div>
            </div>
        </div>
    </div>        
@endsection

@section('page-script')
  
@endsection
