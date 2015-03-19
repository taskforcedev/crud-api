<!DOCTYPE html>
<html>
<head>
    <title>{{ config('crudapi.sitename') }}</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
</head>
<body>
@include('crudapi::layouts._nav')
<div class="container">
@yield('content')
</div>
</body>
</html>