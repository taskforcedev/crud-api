<!DOCTYPE html>
<html>
<head>
    <title>{{ config('crudapi.sitename') }}</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
</head>
<body>
@include('crudapi::layouts._nav')
    <div class="container">
        @yield('content')
    </div>
</body>
</html>