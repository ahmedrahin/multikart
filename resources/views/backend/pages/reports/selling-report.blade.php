
@extends('backend.layout.template')

@section('page-title')
    <title>Selling Reports || {{ !is_null($siteTitle = App\Models\Settings::site_title()) ? $siteTitle->site_title : 'Shop' }}</title>
@endsection

@section('page-css')
	<!-- custom -->
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
		h6 .text-danger {
			display: inline !important;
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
		    color: #322cdc;
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
		.nofound {
		    text-align: center;
		    font-size: 16px;
		    font-weight: 700;
		    margin: 12px 0;
		    color: #ff0000a6;
		}
		table th {
			text-align: center;
		}
		table td {
			text-align: center;
		}
		.order-actions {
			justify-content: center;
		}
		.downloadPdf {
			font-size: 18px;
			width: 34px;
			height: 34px;
			display: flex;
			align-items: center;
			justify-content: center;
			background: #f1f1f1;
			border: 1px solid #eeecec;
			text-align: center;
			border-radius: 20%;
			color: #2b2a2a;
		}
		h6 {
			font-size: 13px;
    		font-weight: 600;
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
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.css">
	<link href="{{asset('backend/plugins/datatable/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet" />
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
										<form action="{{route('filter-by-product')}}" method="post">
											@csrf
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
												<select id="product" name="product">
													<option selected disabled>Select an product</option>
													@foreach( $allProduct as $product )
														<option value="{{$product->id}}">{{$product->title}}</option>
													@endforeach
												</select>
											</div>
											<div class="">
												<button class="btn btn-primary" type="submit">Search</button>
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

        <!-- report table -->
         <div class="card radius-10">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                        <h5 class="mb-0">Orders Summary</h5>
                    </div>
                    <div class="ms-auto" style="display: none;">
						<h6 class="totalOrder">Total Order: <span class="text-danger"></span></h6>
						<h6 class="totalAmn">Total Amount: <span class="text-danger"></span></h6>
                    </div>
                </div>
                <hr/>
                <div class="table-responsive">
                    <table id="example2" class="table align-middle mb-0">
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
                        	
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="loader">
            	<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            </div>
        </div>
    </div>   

	{{-- <form id="pdfForm" action="/admin/reports/generate-pdf" method="POST">
		<!-- Add any form fields or data needed for PDF generation -->
		<button id="downloadPdf" type="submit">Download PDF</button>
	</form> --}}
	

@endsection

@section('page-script')

	<script src="{{ asset('backend/plugins/datetimepicker/js/legacy.js') }}"></script>
	<script src="{{ asset('backend/plugins/datetimepicker/js/picker.js') }}"></script>
	<script src="{{ asset('backend/plugins/datetimepicker/js/picker.date.js') }}"></script>
	<script src="{{ asset('backend/plugins/bootstrap-material-datetimepicker/js/moment.min.js') }}"></script>
	<script src="{{ asset('backend/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.min.js') }}"></script>

	<!-- datatable -->
	<script src="{{asset('backend/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
	<script src="{{asset('backend/plugins/datatable/js/dataTables.bootstrap5.min.js')}}"></script>
	<script>
		$(document).ready(function() {
			var table = $('#example2').DataTable( {
				lengthChange: false,
				buttons: [ 'copy', 'excel', 'pdf', 'print']
			} );
		 
			table.buttons().container()
				.appendTo( '#example2_wrapper .col-md-6:eq(0)' );
		} );
	</script>

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
	<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <script>
        $(document).ready(function () {
            $("#product").select2();
        });   
    </script>

    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <!-- filter by date -->
    <script type="text/javascript">
    	$(document).ready(function(){

    		//delete order
    		function delOrder() {
			    // Add a click event listener to a parent element of .delete-order elements
			    $(document).on('click', '.delete-order', function() {
			    		let delOrder = $(this);
			    		let orderId  = $(this).data('order-id');
				         swal({
				            title: "Are you sure?",
				            text: "Once deleted, you will not be able to recover this order!",
				            icon: "warning",
				            buttons: {
					            cancel: "Cancel",
					            confirm: "Confirm"
					        },
				            dangerMode: true,
				        })
				        .then((willDelete) => {
				            if (willDelete) {
		                        // Send an AJAX request to delete the employee
		                        $.ajax({
		                            type: 'DELETE',
		                            url: '/admin/reports/delete-order/' + orderId,
		                            headers: {
		                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		                            },
		                            success: function(response) {    
		                                
		                                delOrder.closest('tr').fadeOut('slow', function() {
		                                    $(this).remove();
		                                });

		                                setTimeout(() => {
		                                    toastr.warning('Orders has been deleted!', '', {"positionClass": "toast-top-right", "closeButton": true});
		                                }, 200);

		                                filterbyDate();

		                                // Check if there are any orders left
									    if ($('tbody').find('tr').length === 1) {
										    $('tbody').html(`
										        <tr>
										            <td colspan="7">
										                <div class="nofound">No Order Found!</div>
										            </td>
										        </tr>
										    `);
										}
										console.log($('tbody').html())

		                            },
		                            error: function(xhr, textStatus, errorThrown) {
		                                // Handle deletion error
		                                toastr.error('Something is wrong! Please try again.', '', {"positionClass": "toast-top-right", "closeButton": true});
		                                console.error('Error deleting order:', errorThrown);
		                            }
		                        });
		                    }
				        });
				    });
				}

		
			//filter by date
			function filterbyDate() {
			    $('#btnDate').off().click(function(e) {
			        e.preventDefault();
			        var form = $(this).closest('form');
			        var formData = form.serialize();

			        // Send Ajax request
			        $.ajax({
			            url: form.attr('action'),
			            type: form.attr('method'),
			            data: formData,
			            beforeSend: function() {
			                $("#btnDate").prop('disabled', true).html(`
			                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
			                `);
			                $('#btnDate').css('width', '78px');
			                $('.loader .spinner-border-sm').css('opacity', 1);

			            },
			            success: function(response) {
			                $("#btnDate").prop('disabled', false).html('Search');
			                $('#filter-date').find('.text-danger').html('');
			                $('#filter-date').find('.is-invalid').removeClass('is-invalid');
			                $('.loader').css('visibility', 'hidden');
			                $('.loader .spinner-border-sm').css('opacity', 0);
			                $('tbody').empty();

			                if (response.orders.length > 0) {
			                    // Append new orders to the existing table rows
			                    toastr.info(response.orders.length + ' Orders Found', '', {"positionClass": "toast-top-right", "closeButton": true});
			                    $.each(response.orders, function(index, order) {
			                        var row = `<tr>
			                            <td>${index + 1}</td>
			                            <td>#${order.id}</td>
			                            <td>${order.name}</td>
			                            <td>৳${order.amount}</td>
			                            <td>${order.order_date}</td>
			                            <td>${order.quantity}</td>
			                            <td>
			                                <div class="d-flex order-actions gap-2">
			                                    <a href="/admin/order/order-details/${order.id}" target="_blank"><i class='lni lni-eye'></i></a>
			                                    <a href="javascript:;" class="delete-order" data-order-id="${order.id}" ><i class='bx bx-trash'></i></a>
			                                     <button class="downloadPdf" data-order-id="${order.id}"><i class='bx bx-cloud-download'></i></button>
			                                </div>
			                            </td>
			                        </tr>`;
			                        $('tbody').append(row);
			                    });
			                    downPdf();
								$('.ms-auto').css('display', 'block');
								$('.totalOrder span').html(response.orders.length);
								$('.totalAmn span').html(response.totel_amn + "৳");
			                } else {
			                    toastr.warning('0 Orders Found', '', {"positionClass": "toast-top-right", "closeButton": true});
								$('.ms-auto').css('display', 'none');
			                    $('tbody').html(`
			                        <tr>
			                            <td colspan="7">
			                                <div class="nofound">No Order Found in ${response.date}</div>
			                            </td>
			                        </tr>
			                    `);
			                }
			            },
			            error: function(xhr, status, error) {
			                $("#btnDate").prop('disabled', false).html('Search');
			                $('.loader .spinner-border-sm').css('opacity', 0);
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
			}

			// download pdg
			function downPdf(){
				$('.downloadPdf').click(function(e) {
					e.preventDefault();

					// Send Ajax request to generate PDF
					$.ajax({
						url: '/admin/reports/generate-pdf',
						method: 'GET',
						success: function(response) {
							// Convert response to Blob
							var blob = new Blob([response]);

							// Create download link
							var link = document.createElement('a');
							link.href = window.URL.createObjectURL(blob);
							link.download = "Details.pdf";
							link.click();

							// Display success message (you may use toastr here)
							toastr.success('The Order Details Pdf Downloaded', '', {"positionClass": "toast-top-right", "closeButton": true});
						},
						error: function(xhr, status, error) {
							toastr.error('Something is wrong! Please try again.', '', {"positionClass": "toast-top-right", "closeButton": true});
						}
					});
				});
			}


			filterbyDate();
			delOrder();
			downPdf();
    		 
    	})
    </script>
    
@endsection
