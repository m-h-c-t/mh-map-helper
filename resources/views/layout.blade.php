<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <!-- <link rel="stylesheet" href="css/bootstrap-theme.min.css"> -->
    <link rel="stylesheet" href="{{ elixir('css/custom.css') }}">
    {{--<script defer src="//ajax.googleapis.com/ajax/libs/angularjs/1.3.15/angular.min.js"></script>--}}
    {{--<script defer src="{{ elixir('js/main-controller.js') }}"></script>--}}
</head>
<body class="text-center" ng-controller="MainController">

@include('custom-header')

@if (session('message'))
    <div class="alert alert-dismissible @if(session('message_type') == 'error') alert-danger @else alert-success @endif"
         role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        {{ session('message') }}
    </div>
@endif

<div class="content">
    @yield('content')
</div>

@include('custom-footer')

<!-- JS Includes -->
<script defer src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<script defer src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>

</body>
</html>
