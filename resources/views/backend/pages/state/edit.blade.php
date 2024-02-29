@extends('backend.layout.template')

@section('page-title')
    <title>Update State Information || {{ !is_null($siteTitle = App\Models\Settings::site_title()) ? $siteTitle->site_title : 'Shop' }}</title>
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
                        <li class="breadcrumb-item active" aria-current="page">Edit State</li>
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
                    <h5 class="heading">Update State Information</h5>
                    </div>

                    <div class=" mb-3 border p-3 radius-10">
                        <!-- Message -->
                        @include('backend.includes.message')
                        <form action="{{ route('update-state', $editData->id) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="name">State Name</label>
                                <input type="text" name="name" id="name" value="{{ $editData->name }}" placeholder="Enter State Name" class="@error('name') is-invalid @enderror">
                                @error('name')
                                    <span class="text-danger"> {{ $message }} </span>
                                @enderror
                            </div>

							<div class="mb-3">
								<label for="">Select Country</label>
								<select class="select2 w-50 @error('country_id') is-invalid @enderror" name="country_id">
									<option value="">Please Select the Country</option>
										@foreach( $countries as $country )
											<option value="{{ $country->id }}" @if ( $country->id == $editData->country_id ) selected @endif > {{ $country->name }} </option>
										@endforeach
								</select>
                                @error('country_id')
                                    <span class="text-danger"> {{ $message }} </span>
                                @enderror
							</div>
						
                            <div class="mb-3">
                                <label for="prioritynumber">Priority Number</label>
                                <input type="number" name="priority_number" id="prioritynumber" value="{{ $editData->priority_number }}" placeholder="Enter Priority Number">
                            </div>
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
	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
	<script>
		$(document).ready(function () {
			$(".select2").select2();
		});
	</script>
@endsection
