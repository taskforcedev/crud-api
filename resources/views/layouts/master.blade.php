<!DOCTYPE html>
<html>
<head>
    <title>{{ config('crudapi.sitename') }}</title>
    <link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/bootswatch/3.3.4/yeti/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" />
    <script src="//code.jquery.com/jquery-2.1.3.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <style>
        .table>tbody>tr>td { vertical-align:middle; }
    </style>
</head>
<body>
@include('crudapi::layouts._nav')
    <div class="container">
        @yield('content')
    </div>
</body>
</html>