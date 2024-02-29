@extends('backend.layout.template')

@section('page-title')
    <title>Product Variation || {{ !is_null($siteTitle = App\Models\Settings::site_title()) ? $siteTitle->site_title : 'Shop' }}</title>
@endsection

@section('page-css')
    <link rel="stylesheet" href="{{ asset('backend/css/custom.css') }}"/>
    {{-- <link rel="stylesheet" href="{{ asset('backend/css/table.css') }}"/> --}}
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
@endsection

@section('body-content')
    <div class="page-content shipping currency"> 
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
                        <li class="breadcrumb-item active" aria-current="page">Product Variation</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->
        {{-- products color --}}
        <div class="row">
            <div class="col-12 d-flex">
                <div class="card radius-10 w-100">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <h5 class="heading">Add Variation</h5>
                            </div>
                            <div class="col-6">
                                <button type="button" class="btn add btn-sm btn-primary pull-left" data-bs-toggle="modal" data-bs-target="#addVariation">
                                    <i class="fa fa-plus-circle"></i> 
                                    Add Variation
                                </button>
                            </div>
                        </div>

                        <hr>

                        @if( $variations->count() > 0 )
                            <table class="table mb-0 table-striped">
                                <thead>
                                    <tr>
                                        <th>Sl.</th>
                                        <th>Variation Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $sl = 0; @endphp
                                    @foreach ($variations as $variation)
                                        <tr>
                                            <th>{{ ++$sl }}</th>
                                            <td>{{ $variation->var_name }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <form class="btn btn-primary">
                                                        <button type="button" data-bs-toggle="modal" data-bs-target="#editVariation{{$variation->id}}">Edit</button>
                                                    </form>
                                                    <form action="{{route('delete-variation-product', $variation->id)}}" class="btn btn-danger" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit">Delete</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>

                                        {{-- edit modal --}}
                                        <div class="modal fade" id="editVariation{{$variation->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">
                                                            Edit Variation
                                                        </h5>
                                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ route('update-variation-product', $variation->id) }}" method="post">
                                                            @csrf
                                                            <div class="row">
                                                                <div class="mb-2">
                                                                    <label for="VariationName">Variation Name</label>
                                                                    <input type="text" name="VariationName" id="VariationName" placeholder="Variation Name" value="{{ $variation->var_name }}">
                                                                    <span class="text-danger"></span>
                                                                </div>
                                                                <div class="mb-0">
                                                                    <label for="">Active Status</label>
                                                                    <select name="status">
                                                                        <option value="0">Select active status</option>
                                                                        <option value="1" {{ ($variation->status == 1) ? 'selected' : '' }}>Active</option>
                                                                        <option value="2" {{ ($variation->status == 2) ? 'selected' : '' }}>Inactive</option>
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
                        
                        <!-- add variation Modal -->
                        <div class="modal fade" id="addVariation" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">
                                            Add Variation
                                        </h5>
                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('store-variation-product') }}" method="post">
                                            @csrf
                                            <div class="row">
                                                <div class="mb-0">
                                                    <label for="VariationName">Variation Name</label>
                                                    <input type="text" name="VariationName" id="VariationName" placeholder="Variation Name">
                                                    <span class="text-danger"></span>
                                                </div>

                                                <input type="submit" value="Add Variation">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- varitaion value add --}}
                        <div class="row" style="margin-top: 40px">
                            @foreach ($variationOption as $variationItem)
                                <div class="col-md-4">
                                    <div class="col d-flex">
                                        <div class="card radius-10 w-100">
                                            <div class="card-header">
                                                <div class="d-flex align-items-center">
                                                    <div>
                                                        <h5 class="mb-1">{{$variationItem->var_name}}</h5>
                                                    </div>
                                                    <div class="dropdown options ms-auto">
                                                        <button type="button" class="btn add btn-sm btn-primary pull-left" data-bs-toggle="modal" data-bs-target="#addVariationValue{{ $variationItem->id }}">
                                                            <i class="fa fa-plus-circle"></i> 
                                                            Add Option
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="customers-list p-3 mb-3 ps">
                                                {{-- show all option --}}
                                                @if($variationItem->VariationValue->isEmpty())
                                                    <h6 class="noData">No Option Found!</h6>
                                                @else
                                                    @foreach ($variationItem->VariationValue as $variationOption)
                                                        <div class="customers-list-item d-flex align-items-center border-bottom p-2 cursor-pointer">
                                                            <div class="ms-2">
                                                                <h6 class="mb-1 font-14">{{$variationOption->option}}</h6>
                                                            </div>
                                                            <div class="list-inline d-flex customers-contacts ms-auto">
                                                                <button class="list-inline-item" data-bs-toggle="modal" data-bs-target="#editVariationValue{{ $variationOption->id }}">
                                                                    <i class="bi bi-pencil-fill"></i>
                                                                </button>
                                                                <form action="{{route('delete-option', $variationOption->id)}}" method="post">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button href="javascript:;" class="list-inline-item"><i class="bi bi-trash-fill"></i></button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                        
                                                        <!-- edit option Modal -->
                                                        <div class="modal fade" id="editVariationValue{{ $variationOption->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLabel">
                                                                            Edit Option
                                                                        </h5>
                                                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <form action="{{ route('update-option', $variationOption->id) }}" method="post">
                                                                            @csrf
                                                                            <div class="row">
                                                                                <input type="hidden" name="var_id" value="{{ $variationItem->id }}">
                                                                                <div class="mb-2">
                                                                                    <label for="optionName">Option Name</label>
                                                                                    <input type="text" name="optionName" id="optionName" placeholder="Option Name" value="{{ $variationOption->option }}">
                                                                                    <span class="text-danger"></span>
                                                                                </div>

                                                                                <div class="mb-0">
                                                                                    <label for="extra">Option Value (optional)</label>
                                                                                    <input type="text" name="extra" id="extra" placeholder="Option Value" value="{{ $variationOption->option_value }}">
                                                                                    <span class="text-danger"></span>
                                                                                </div>

                                                                                <input type="submit" value="Save Changes">
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- add option Modal -->
                                <div class="modal fade" id="addVariationValue{{ $variationItem->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">
                                                    Add {{ $variationItem->var_name }} Option
                                                </h5>
                                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('variation-option') }}" method="post">
                                                    @csrf
                                                    <div class="row">
                                                        <input type="hidden" name="var_id" value="{{ $variationItem->id }}">
                                                        <div class="mb-2">
                                                            <label for="optionName">Option Name</label>
                                                            <input type="text" name="optionName" id="optionName" placeholder="Option Name">
                                                            <span class="text-danger"></span>
                                                        </div>

                                                        <div class="mb-0">
                                                            <label for="extra">Option Value (optional)</label>
                                                            <input type="text" name="extra" id="extra" placeholder="Option Value">
                                                            <span class="text-danger"></span>
                                                        </div>

                                                        <input type="submit" value="Add Option">
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>  
                    </div>
                </div>
            </div>
        </div>
    </div>   
@endsection

@section('page-script')
    {{-- validation --}}
    
@endsection
