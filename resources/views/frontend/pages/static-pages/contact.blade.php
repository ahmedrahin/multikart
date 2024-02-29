@extends('frontend.layout.template')

@section('page-title')
    <title>Contact Us || Multikart</title>
@endsection

@section('page-css')
    
@endsection

@section('body-content')
    <!-- breadcrumb start -->
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="page-title">
                        <h2>contact</h2>
                    </div>
                </div>
                <div class="col-sm-6">
                    <nav aria-label="breadcrumb" class="theme-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                            <li class="breadcrumb-item active">contact</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb End -->

    <!--section start-->
    <section class="contact-page section-b-space">
        <div class="container">
            <div class="row section-b-space">
                <div class="col-lg-7 map">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d1605.811957341231!2d25.45976406005396!3d36.3940974010114!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sin!4v1550912388321"
                        allowfullscreen></iframe>
                </div>
                <div class="col-lg-5">
                    <div class="contact-right">
                        <ul>
                            <li>
                                <div class="contact-icon"><img src="{{ asset('frontend/images/icon/phone.png') }}"
                                        alt="Generic placeholder image">
                                    <h6>Contact Us</h6>
                                </div>
                                <div class="media-body">
                                    @php
                                        $call_1 = \App\Models\Settings::call_1();
                                    @endphp
                                    @if($call_1 && !empty($call_1->number1))
                                        <p>{{$call_1->number1}}</p>
                                    @else
                                        <p>+91 123 - 456 - 7890</p>
                                    @endif

                                    @php
                                        $call_2 = \App\Models\Settings::call_2();
                                    @endphp
                                    @if($call_2 && !empty($call_1->number2))
                                        <p>{{$call_2->number2}}</p>
                                    @else
                                        <p>+91 123 - 456 - 7890</p>
                                    @endif
                                </div>
                            </li>
                            <li>
                                <div class="contact-icon"><i class="fa fa-map-marker" aria-hidden="true"></i>
                                    <h6>Address</h6>
                                </div>
                                <div class="media-body">
                                    <p>Garder City Complex, Feni</p>
                                    <p>Feni, Bangladesh</p>
                                </div>
                            </li>
                            <li>
                                <div class="contact-icon"><img src="{{ asset('frontend/images/icon/email.png') }}"
                                        alt="Generic placeholder image">
                                    <h6>Address</h6>
                                </div>
                                <div class="media-body">
                                    <p>support@shopcart.com</p>
                                    <p>multikart@.com</p>
                                </div>
                            </li>
                            <li>
                                <div class="contact-icon"><i class="fa fa-fax" aria-hidden="true"></i>
                                    <h6>Fax</h6>
                                </div>
                                <div class="media-body">
                                    <p>092303923</p>
                                    <p>multikart@.com</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <form class="theme-form" action="{{ route('store-message') }}" method="post">
                        @csrf
                        <div class="form-row row">
                            <div class="col-md-6">
                                <label for="name">First Name</label>
                                <input type="text" class="form-control" id="name" name="first_name" placeholder="First Name" value="{{old('first_name')}}">
                                @error('first_name')
                                    <div class="text-danger"> {{ $message }} </div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="last-name">Last Name</label>
                                <input type="text" class="form-control" id="last-name" name="last_name" placeholder="Last Name" value="{{old('last_name')}}" >
                                @error('last_name')
                                    <div class="text-danger"> {{ $message }} </div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="email">Email</label>
                                <input type="text" class="form-control" id="email" name="user_email" placeholder="Email Adrress" value="{{old('user_email')}}" >
                                @error('user_email')
                                    <div class="text-danger"> {{ $message }} </div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="review">Phone number</label>
                                <input type="text" class="form-control" name="phone" id="review" placeholder="Your Number" value="{{old('phone')}}" >
                                @error('phone')
                                    <div class="text-danger"> {{ $message }} </div>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <label for="message">Write Your Message</label>
                                <textarea class="form-control" name="message" placeholder="Write Your Message" id="message" rows="6" value="{{old('message')}}" >{{old('message')}}</textarea>
                                @error('message')
                                    <div class="text-danger"> {{ $message }} </div>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <button class="btn btn-solid" type="submit">Send Your Message</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!--Section ends-->
@endsection

@section('page-script')

@endsection
    
