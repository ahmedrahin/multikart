<!-- Success Message -->
@if( $message = Session::get( 'successMsg' ) )
    <div class="alert bg-success">
        {{ $message }}
    </div>
@endif

<!-- Warning Message -->
@if( $message = Session::get( 'warningMsg' ) )
    <div class="alert bg-warning">
        {{ $message }}
    </div>
@endif


<!-- Error Message -->
@if( $message = Session::get( 'errorMsg' ) )
    <div class="alert bg-danger">
        {{ $message }}
    </div>
@endif


<!-- Info Message -->
@if( $message = Session::get( 'infoMsg' ) )
    <div class="alert bg-info">
        {{ $message }}
    </div>
@endif

<!-- Flust validation error message -->
@if ($errors->any())
    <div class="form-message">
    @foreach ($errors->all() as $error)
        <div class="alert alert-danger border-0 bg-danger alert-dismissible fade show py-2">
            <div class="d-flex align-items-center">
                <div class="font-35 text-white">
                </div>
                <div class="ms-3">
                    <div class="text-white">{{ $error }}</div>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"><i class="fa fa-times" aria-hidden="true"></i></button>
        </div>
    @endforeach
    </div>
@endif

