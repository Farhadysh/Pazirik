<!doctype html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>پازیریک</title>

    <link rel="stylesheet" href="{{asset('/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('/css/bootstrap-rtl.css')}}">
    <link rel="stylesheet" href="{{asset('/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('/css/sweetalert.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('/css/vazir.css')}}">
    <link rel="stylesheet" href="{{asset('/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('/css/Chart.css')}}">
    <link rel="stylesheet" href="{{asset('/css/fakeLoader.css')}}">
    <link rel="stylesheet" href="{{asset('/css/clean-switch.css')}}">
    <link rel="stylesheet" href="{{asset('/css/checkBox.css')}}">
    <link rel="stylesheet" href="{{asset('/css/check.css')}}">
    <link rel="stylesheet" href="{{asset('/css/radioBtn.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link href="{{asset('/css/kamadatepicker.min.css')}}" rel="stylesheet">
    <script src="{{asset('/js/kamadatepicker.min.js')}}" type="text/javascript"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAEU50MGV9u1Bq-Co8Y7r2IhucXgMC6dwU"></script>
    @yield('css')
</head>
<body class="bg-light">

@include('admin.section.nav')

<div class="container-fluid">
    <div class="row">
        @include('admin.section.sidebar')
        <div class="col-12 col-md-10 mr-md-auto p-4" id="main">
            @yield('content')
        </div>
    </div>
</div>
<script src="{{asset('/js/jquery.js')}}"></script>
<script src="{{asset('/js/simple.money.format.js')}}"></script>
<script src="{{asset('/js/popper.js')}}"></script>
<script src="{{asset('/js/bootstrap.min.js')}}"></script>
<script src="{{asset('/js/sweetalert.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/js/custom.js')}}"></script>
<script src="{{asset('/js/chart.js')}}"></script>
<script src="{{asset('/js/fakeLoader.js')}}"></script>
@yield('scripts')
@include('sweet::alert')
</body>
</html>