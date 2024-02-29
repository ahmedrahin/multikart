<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="multikart">
<meta name="keywords" content="multikart">
<meta name="author" content="multikart">
@php
    $favIcon = \App\Models\Settings::shop_fav();
@endphp
@if(!is_null($favIcon))
    <link rel="icon" href="{{ asset('uploads/fav_logo/' . $favIcon->fav_icon) }}" type="image/png" />
@endif
<!-- Page Title -->
@yield('page-title')