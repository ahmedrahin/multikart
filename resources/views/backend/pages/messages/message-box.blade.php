@extends('backend.layout.template')

@section('page-title')
    <title>Message Details || {{ !is_null($siteTitle = App\Models\Settings::site_title()) ? $siteTitle->site_title : 'Shop' }}</title>
@endsection

@section('page-css')
    <link rel="stylesheet" href="{{ asset('backend/css/custom.css') }}"/>
    <link rel="stylesheet" href="{{ asset('backend/css/table.css') }}"/>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
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
                        <li class="breadcrumb-item active" aria-current="page">Message</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->

        
        <div class="col-12 d-flex">
            <div class="card radius-10 w-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                    <h5 class="heading">Message Details</h5>
                    </div>

                    <div class=" mb-3 border p-3 radius-10">
                        <!-- Message -->
                        @include( 'backend.includes.message' )
                        <div class="container">
                            <div class="main-body">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="d-flex flex-column align-items-center text-center">
                                                    @if( isset( $message->user_id ) && isset( $message->user->id ) )
                                                        @if( !is_null($message->user->image) )
                                                            <img src="{{ asset('uploads/user/' .  $message->user->image ) }}" class="rounded-circle p-1 bg-primary message-img">		
                                                        @else
                                                            <img src="{{ asset('backend/images/user.jpg') }}" class="rounded-circle p-1 bg-primary message-img" >
                                                        @endif
                                                    @else
                                                        <img src="{{ asset('backend/images/user.jpg') }}" class="rounded-circle p-1 bg-primary message-img">
                                                    @endif
                                                    <div class="mt-3">
                                                        <h4>{{ $message->first_name . " " . $message->last_name }}</h4>
                                                        <p class="text-secondary mb-1">
                                                            isUser: 
                                                            @if( !is_null($message->user_id) )
                                                                Register 
                                                            @else
                                                                Non Register
                                                            @endif
                                                        </p>
                                                        <p class="text-secondary mb-1">Email: {{ $message->user_email }}</p>
                                                        <p class="text-secondary mb-1">Phone: {{ (!is_null($message->phone)) ? $message->phone : 'N/A' }}
                                                        </p>
                                                        <p class="text-muted font-size-sm">
                                                            Time:
                                                            @php
                                                                $messageTime = Carbon\Carbon::parse($message->message_time);
                                                                $timeDiff = $messageTime->diffInSeconds();
                                                                
                                                                if ($timeDiff < 60) {
                                                                    echo $timeDiff . ' sec ago';
                                                                } elseif ($timeDiff < 3600) {
                                                                    echo $messageTime->diffInMinutes() . ' min ago';
                                                                } elseif ($timeDiff < 86400) {
                                                                    echo $messageTime->diffInHours() . ' hr ago';
                                                                } elseif ($timeDiff < 31536000) {
                                                                    echo $messageTime->diffInDays() . ' days ago';
                                                                } else {
                                                                    echo $messageTime->diffInYears() . ' years ago';
                                                                }
                                                            @endphp
                                                        </p>
                                                        <button class="btn btn-primary">Follow</button>
                                                        <button class="btn btn-outline-primary">Message</button>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="card">
                                            <div class="card-body">
                                                <h4 class="user-message">User Message</h4>
                                                <p class="messagebox">
                                                    {{ $message->message }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-body">
                                                @if( is_null($message->rep_message) )
                                                    <form action="{{ route('replay-message', $message->id) }}" method="post" style="padding: 0">
                                                        @csrf 
                                                        @method('PUT')
                                                        <h4 class="user-message mb-3">Reply Message</h4>
                                                        <div>
                                                            <textarea id="description" name="rep_message" placeholder="Reply Message..">{{ old('message')}}</textarea>
                                                            <input type="hidden" name="email" value="{{ $message->user_email }}">
                                                            <input type="hidden" name="message" value="{{ $message->message }}">
                                                        </div>
                                                        @error('rep-message')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                        <input type="submit" id="submit" class="btn btn-primary" value="Reply Message">
                                                    </form>
                                                @else
                                                    <h4 class="user-message mb-3">Reply Message</h4>
                                                    <span class="messagebox">
                                                        @php echo $message->rep_message; @endphp
                                                    </span>
                                                @endif
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

    </div>

@endsection

@section('page-script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace( 'description' );
    </script> 
@endsection		