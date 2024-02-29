@extends('backend.layout.template')

@section('page-title')
    <title>All Brand Trash List || {{ !is_null($siteTitle = App\Models\Settings::site_title()) ? $siteTitle->site_title : 'Shop' }}</title>
@endsection

@section('page-css')
    <link rel="stylesheet" href="{{ asset('backend/css/custom.css') }}" />
    <link rel="stylesheet" href="{{ asset('backend/css/table.css') }}"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('backend/css/datatables.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('backend/css/datatables.css') }}" rel="stylesheet" />
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
                        <li class="breadcrumb-item active" aria-current="page">Brand Trash List</li>
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
                        <h5 class="heading">All Trash Brand List</h5>
                        </div>

                        <div class=" mb-3 border p-3 radius-10">
                            @if( $trashList->count() != 0 )
                            <div class="container">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="panel">
                                            <div class="panel-heading">
                                                <div class="row">
                                                    <div class="col-sm-12 col-xs-12">
                                                        <a href="{{ route('manage-brand') }}" class="btn btn-sm btn-primary pull-left"  style="margin-right:10px;"> Go Back <i class="bx bx-right-arrow-alt"></i></a>
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
                                                        <th>Brand Name</th>
                                                        <th class="description">Description</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                      
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
                                                <a href="{{ route('manage-brand') }}" class="btn btn-sm btn-primary pull-left"  style="margin-right:10px;"> Go Back <i class="bx bx-right-arrow-alt"></i></a>
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
    {!! Toastr::message() !!}
    <script src="{{ asset('backend/js/datatable.min.js') }}" defer></script>
    <script src="{{ asset('backend/js/datatables.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {   
            $(function () {
                var table = $('#data_table').DataTable({
                processing: false,
                serverSide: true,
                ajax: "{{ route('trash-manage-brand') }}",
                language: {
                    paginate: {
                        previous: '<i class="bi bi-chevron-double-left"></i>', 
                        next: '<i class="bi bi-chevron-double-right"></i>'
                    }   
                },
                columns: [
                    {data: 'sl', name: 'sl'},
                    {data: 'image', name: 'image', orderable: false, searchable: false},
                    {data: 'brand_name', name: 'brand_name'},
                    {data: 'description', name: 'description', orderable: false, searchable: false},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });
          });
        })
    </script>
@endsection
