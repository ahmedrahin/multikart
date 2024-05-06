
@extends('backend.layout.template')

@section('page-title')
    <title>Selling Reports || {{ !is_null($siteTitle = App\Models\Settings::site_title()) ? $siteTitle->site_title : 'Shop' }}</title>
@endsection

@section('page-css')
    <style type="text/css">
    	.img {
		    width: 43px;
		    height: 43px;
		    object-fit: cover;
		    border-radius: 50%;
		}
		.user-box {
		    padding-left: 13px;
		}
		.card {
			margin-bottom: 10px;
		}
		.card-body {
			padding: 22px;
		}
		.text-primary {
		    color: #9ea4aa !important;
		}
		button:focus {
			box-shadow: none !important;
		}
		select,.select2-container--default .select2-selection--single{
		    display: block;
		    width: 100%;
		    padding: 15px 20px;
		    border-radius: 4px;
		    border: 1px solid #00000026;
		    background-color: #fff !important;
		}
		form .form-row input, form .form-row  textarea, form .form-row  select, form .form-row .select2-container--default .select2-selection--single{
		    width: 98%;
		}
		.select2-container--default .select2-selection--single {
		    width: 100% !important;
		    height: 44px !important;
		    padding: 7px 10px !important;
		}
		.select2-container--default .select2-selection--single .select2-selection__arrow{
		    height: 50px !important;
		}
		.select2-container--default .select2-search--dropdown .select2-search__field{
		    border: 1px solid #00000042 !important;
		    padding: 10px !important;
		}
		.select2-container--default .select2-results__option--highlighted[aria-selected]{
		    background: #5e72e4 !important;
		    padding: 12px !important;
		    color: white !important;
		}
		.select2-results__option{
		    padding: 12px !important;
		}
		.select2-results__option[aria-selected] {
		    color: black !important;
		    font-weight: 500;
		}
		.select2-container--default .select2-selection--single .select2-selection__arrow {
			top: -3px !important;
		}
		.select2-container--default .select2-search--dropdown .select2-search__field {
		    border: 1px solid #00000042 !important;
		    padding: 10px !important;
		}
		input:focus {
			outline: none !important;
		}
		.is-invalid{
            border: 1px solid #dc3545 !important;
        }
        .form-control.is-invalid:focus {
            box-shadow: none !important;
        }
        .text-danger {
        	 margin-top: 10px;
		    display: block;
        }
        .loader .spinner-border-sm {
		    width: 2rem;
		    height: 2rem;
		    border-width: .3em;
		    color: #FF4C3B;
		    opacity: 0;
		}
		.loader{
		    position: absolute;
		    top: 0;
		    width: 98%;
		    height: 100%;
		    left: 0;
		    display: flex;
		    align-items: center;
		    justify-content: center;
		    background: #ffffff9c;
		}
    </style>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <!-- date picker -->
    <link href="{{ asset('backend/plugins/datetimepicker/css/classic.css') }}" rel="stylesheet" />
	<link href="{{ asset('backend/plugins/datetimepicker/css/classic.time.css') }}" rel="stylesheet" />
	<link href="{{ asset('backend/plugins/datetimepicker/css/classic.date.css') }}" rel="stylesheet" />
	<link href="{{ asset('backend/plugins/datetimepicker/css/classic.date.css') }}" rel="stylesheet" />
	<link rel="stylesheet" href="{{ asset('backend/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.min.css') }}">
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
@endsection

@section('body-content')
    <div class="page-content full"> 
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
                        <li class="breadcrumb-item active" aria-current="page">Selling Reports</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->

        <!-- filer option -->
        <div class="row mb-4">
            <div class="col-12 d-flex">
                <div class="card radius-10 w-100">
                    <div class="card-body">
                        
                    	<div class="row">
                    		<div class="col-md-6">
                    		<h6 class="mb-0 text-uppercase">Filter By Date</h6>
							<hr/>
							<div class="card">
								<div class="card-body">
									<form action="{{route('filter-by-date')}}" method="post" id="filter-date">
										@csrf
										<div class="mb-3">
											<label class="form-label">First Date</label>
											<input class="result form-control" type="text" id="firstDate" name="firstDate" placeholder="Select the first date" value="">
											<span class="text-danger">  </span>
										</div>
										<div class="mb-3">
											<label class="form-label">Last Date</label>
											<input class="result form-control" type="text" id="lastDate" name="lastDate" placeholder="Select the last date">
											<span class="text-danger">  </span>
										</div>
										<div style="margin-bottom: 7px;">
											<button class="btn btn-primary" type="submit" id="btnDate">Search</button>
										</div>
									</form>
								</div>
							</div>
                    	</div>

                    	<div class="col-md-6">
                    		<h6 class="mb-0 text-uppercase">Filter By Product</h6>
							<hr/>
							<div class="card">
								<div class="card-body">
									<div class="row">
										<div class="col-md-6">
											<div class="mb-3">
												<label class="form-label">First Date (optional) </label>
												<input class="result form-control" type="text" id="firstDate1" placeholder="Select the first date">
											</div>
										</div>
										<div class="col-md-6">
											<div class="mb-3">
												<label class="form-label">Last Date (optional) </label>
												<input class="result form-control time" type="text" id="lastDate2" placeholder="Select the last date">
											</div>
										</div>
									</div>
									
									<div class="mb-3">
										<label class="form-label">Select an product</label>
										<select id="product">
											<option selected disabled>Select an product</option>
											@foreach( $allProduct as $product )
												<option value="{{$product->id}}">{{$product->title}}</option>
											@endforeach
										</select>
									</div>
									<div class="">
										<button class="btn btn-primary">Search</button>
									</div>
								</div>
							</div>
                    	</div>
                    	</div>
                        
                    </div>
                </div>
            </div>
        </div>

        <!-- report table -->
         <div class="card radius-10">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                        <h5 class="mb-0">Orders Summary</h5>
                    </div>
                    <div class="font-22 ms-auto"><i class='bx bx-dots-horizontal-rounded'></i>
                    </div>
                </div>
                <hr/>
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                            	<th>Sl.</th>
                                <th>Order id</th>
                                <th>Customer Name</th>
                                <th>Total Price</th>
                                <th>Order Date</th>
                                <th>Total Qty</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        	

		                            <tr>
		                                <td>#987549</td>
		                                <td>
		                                    <div class="d-flex align-items-center">
		                                        <div class="ms-2">
		                                            <h6 class="mb-1 font-14">Green Sport Shoes</h6>
		                                        </div>
		                                    </div>
		                                </td>
		                                <td>Martin Hughes</td>
		                                <td>14 Jul 2020</td>
		                                <td>$45.00</td>
		                                <td>
		                                    <div class="d-grid">
		                                        <a href="javascript:;" class="btn btn-sm btn-outline-primary radius-30">Dispatched</a>
		                                    </div>
		                                </td>
		                                <td>
		                                    <div class="d-flex order-actions gap-2">
		                                        <a href="javascript:;"><i class='bx bx-trash'></i></a>
		                                        <a href="javascript:;"><i class='bx bx-cloud-download'></i></a>
		                                    </div>
		                                </td>
		                            </tr>

                           
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="loader">
            	<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            </div>
        </div>
    </div>   
@endsection

@section('page-script')

	<script src="{{ asset('backend/plugins/datetimepicker/js/legacy.js') }}"></script>
	<script src="{{ asset('backend/plugins/datetimepicker/js/picker.js') }}"></script>
	<script src="{{ asset('backend/plugins/datetimepicker/js/picker.date.js') }}"></script>
	<script src="{{ asset('backend/plugins/bootstrap-material-datetimepicker/js/moment.min.js') }}"></script>
	<script src="{{ asset('backend/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.min.js') }}"></script>

	<script>
		$('.datepicker').pickadate({
			selectMonths: true,
	        selectYears: true
		}),
		$('.timepicker').pickatime()
	</script>
	<script>
		$(function () {
			$('#firstDate').bootstrapMaterialDatePicker({
				time: false
			});
			$('#lastDate').bootstrapMaterialDatePicker({
				time: false
			});
			$('#firstDate1').bootstrapMaterialDatePicker({
				time: false
			});
			$('#lastDate2').bootstrapMaterialDatePicker({
				time: false
			});
		});
	</script>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            $("#product").select2();
        });   
    </script>

    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <!-- filter by date -->
    <script type="text/javascript">
    	// $(document).ready(function(){
    		 $('#filter-date').on('submit', function(e) {
                e.preventDefault();
                var formData = $(this).serialize();

                // Send Ajax request
                $.ajax({
                    url: $(this).attr('action'),
                    type: $(this).attr('method'),
                    data: formData,
                    beforeSend: function(){
                        $("#btnDate").prop('disabled', true).html(`
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        `);
                        $('#btnDate').css('width', '78px');
                    },
                    success: function(response) {
                        $("#btnDate").prop('disabled', false).html('Search');
                        toastr.success('Your Information is Updated', '', {"positionClass": "toast-top-right", "closeButton": true});
                        $('#filter-date').find('.text-danger').html('');
                        $('#filter-date').find('.is-invalid').removeClass('is-invalid');
                    },
                    error: function(xhr, status, error) {
                        $("#btnDate").prop('disabled', false).html('Search');
                        // Handle error response
                        var errors = xhr.responseJSON.errors;
                        $.each(errors, function(key, value) {
                            var inputField = $('#filter-date').find('[name="' + key + '"]');
                            // Display the error message within the input field
                            inputField.next('.text-danger').html(value[0]);
                            // Add is-invalid class to highlight the field
                            inputField.addClass('is-invalid');
                            toastr.error(value[0]);
                        });
                    }
                });
            });
    	// })
    </script>
    
@endsection
