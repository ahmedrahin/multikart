<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!--favicon-->
@php
    $favIcon = \App\Models\Settings::shop_fav();
@endphp
@if(!is_null($favIcon))
    <link rel="icon" href="{{ asset('uploads/fav_logo/' . $favIcon->fav_icon) }}" type="image/png" />
@endif
<!-- page's title -->
@yield('page-title')