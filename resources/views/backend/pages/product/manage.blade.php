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
                        <li class="breadcrumb-item active" aria-current="page">Product List</li>
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
                            @if( $productList->count() != 0 )
                            <div class="container">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="panel">
                                            <div class="panel-heading">
                                                <div class="row">
                                                    <div class="col-sm-12 col-xs-12">
                                                        <a href="{{ route('create-product') }}" class="btn btn-sm btn-primary pull-left"  style="margin-right:10px;"><i class="fa fa-plus-circle"></i> Add New</a>
                                                        <a href="{{ route('trash-manage-product') }}" class="btn btn-sm btn-primary pull-left"><i class="bi bi-trash-fill"></i>View Trash</a>
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
                                                        <th>Sku_code</th>
                                                        <th>Price</th>
                                                        <th>Category</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach( $productList as $product )
                                                        <!-- Modal -->
                                                        <div class="modal fade" id="product{{ $product->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLabel">
                                                                            Are you sure?
                                                                        </h5>
                                                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <form action="{{ route('trash-product', $product->id) }}" method="POST">
                                                                            @csrf
                                                                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">No</button>
                                                                            <button type="submit" class="btn btn-danger">Yes</button>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>       
                                                    @endforeach 
                                                </tbody>      
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="panel mb-4">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-sm-12 col-xs-12">
                                            <a href="{{ route('create-product') }}" class="btn btn-sm btn-primary pull-left"  style="margin-right:10px;"><i class="fa fa-plus-circle"></i> Add New</a>
                                            <a href="{{ route('trash-manage-product') }}" class="btn btn-sm btn-primary pull-left"><i class="bi bi-trash-fill"></i>View Trash</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="alert alert-danger mt-8">
                                Opps!! No Data Found.
                            </div>
                        @endif
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
                ajax: "{{ route('manage-product') }}",
                language: {
                    paginate: {
                        previous: '<i class="bi bi-chevron-double-left"></i>', 
                        next: '<i class="bi bi-chevron-double-right"></i>'
                    }   
                },
                columns: [
                    {data: 'sl', name: 'sl'},
                    {data: 'thumb_image', name: 'thumb_image', orderable: false, searchable: false},
                    {data: 'product_title', name: 'product_title'},
                    {data: 'sku_code', name: 'sku_code'},
                    {data: 'price', name: 'price', orderable: false, searchable: false},
                    {data: 'category_name', name: 'category_name'},
                    {data: 'status', name: 'status', orderable: false},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });
        });
        })
    </script>
@endsection
