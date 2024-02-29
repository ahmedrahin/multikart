
<!doctype html>
<html lang="en" class="semi-dark">

<head>
	
    @include('backend.includes.header')
    @include('backend.includes.css')

</head>

<body>
	<!--wrapper-->
	<div class="wrapper">
        <!-- Sidebar -->
        @include('backend.includes.sidebar')

		<!--start header -->
		@include('backend.includes.topbar')
		<!--end header -->

        <!-- Body Content -->
        <div class="page-wrapper">
           @yield('body-content')
        </div>  
		
		<!-- Footer File -->
        @include('backend.includes.footer')
	</div>
	<!--end wrapper-->

	<!-- Script File -->
    @include('backend.includes.script')
    
</body>
</html>