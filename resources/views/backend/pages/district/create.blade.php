@extends('backend.layout.template')

@section('page-title')
    <title>Create District || {{ !is_null($siteTitle = App\Models\Settings::site_title()) ? $siteTitle->site_title : 'Shop' }}</title>
@endsection

@section('page-css')
    <link rel="stylesheet" href="{{ asset('backend/css/custom.css') }}" />
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
                        <li class="breadcrumb-item active" aria-current="page">Create District</li>
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
                    <h5 class="heading">Add New District</h5>
                    </div>

                    <div class=" mb-3 border p-3 radius-10">
                        <!-- Message -->
                        @include( 'backend.includes.message' )
                        <form action="{{ route('store-district') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="name">District Name</label>
                                <input type="text" name="name" id="name" placeholder="Enter District Name" class="@error('name') is-invalid @enderror" value="{{ old('name') }}">
                                @error('name')
                                    <span class="text-danger"> {{ $message }} </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label>State Name</label>
                                <select name="state_id" class="select2 w-50 @error('state_id') is-invalid @enderror" id="">
                                    <option value="">Please Select the State Name</option>
                                    @foreach( $state as $states )
                                        <option value="{{ $states->id }}"> {{ $states->name }} </option>
                                    @endforeach
                                </select>
                                 @error('state_id')
                                    <span class="text-danger"> {{ $message }} </span>
                                @enderror
                            </div>
                            <div>
                                <input type="submit" name="submit" value="Add District">
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
	<script>
		$(document).ready(function () {
			$(".select2").select2();
		});
	</script>
@endsection
