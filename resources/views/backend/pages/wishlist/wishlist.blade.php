@extends('backend.layout.template')

@section('page-title')
    <title>All Product List || {{ !is_null($siteTitle = App\Models\Settings::site_title()) ? $siteTitle->site_title : 'Shop' }}</title>
@endsection

@section('page-css')
    <link rel="stylesheet" href="{{ asset('backend/css/custom.css') }}"/>
    <link rel="stylesheet" href="{{ asset('backend/css/table.css') }}"/>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('backend/css/datatables.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('backend/css/datatables.css') }}" rel="stylesheet" />
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
                        <li class="breadcrumb-item active" aria-current="page">Wishlist List</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->
        <div class="row">
            <div class="col-12 d-flex">
                <div class="card radius-10 w-100">
                    <div class="card-body">
                        <!-- Message -->
                        @include( 'backend.includes.message' )
                        <div class="d-flex align-items-center mb-3">
                        <h5 class="heading">All Product List</h5>
                        </div>

                        <div class=" mb-3 border p-3 radius-10">
                            <div class="container">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="panel">
                                            <div class="panel-heading">
                                                <div class="row">
                                                    <div class="col-sm-12 col-xs-12">
                                                        <a href="{{ route('adminDashboard') }}" class="btn btn-sm btn-primary pull-left"  style="margin-right:10px;"> Go Dashboard <i class="bx bx-right-arrow-alt"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel-body table-responsive">
                                            <table id="data_table" class="table table-striped data-table">
                                                <thead>
                                                    <tr>
                                                        <th>Sl.</th>
                                                        <th>Image</th>
                                                        <th>Product Title</th>
                                                        <th>Quantity</th>
                                                        <th>Product Status</th>
                                                        <th>Total Wishlist</th>
                                                        <th>Details</th>
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
                        
                    </div>
                </div>
            </div>
        </div>
    </div>   
@endsection

@section('page-script')
    <script src="{{ asset('backend/js/datatable.min.js') }}" defer></script>
    <script src="{{ asset('backend/js/datatables.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {   
            $(function () {
                var table = $('#data_table').DataTable({
                processing: false,
                serverSide: true,
                ajax: "{{ route('wishlistList') }}",
                language: {
                    paginate: {
                        previous: '<i class="bi bi-chevron-double-left"></i>', 
                        next: '<i class="bi bi-chevron-double-right"></i>'
                    }   
                },
                columns: [
                    {data: 'sl', name: 'sl'},
                    {data: 'image', name: 'image', orderable: false, searchable: false},
                    {data: 'product_title', name: 'product_title'},
                    {data: 'quantity', name: 'quantity'},
                    {data: 'status', name: 'status', orderable: false, searchable: false},
                    {data: 'total', name: 'total', orderable: false},
                    {data: 'details', name: 'details', orderable: false, searchable: false},
                ]
            });
        });
        })
    </script>
@endsection
