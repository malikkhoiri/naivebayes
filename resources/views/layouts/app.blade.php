<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ __('SMP N 4 SAPE') }}</title>

    <!-- VENDOR CSS -->
    <link rel="stylesheet" href="{{asset('assets/vendor/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/font-awesome/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/linearicons/style.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/chartist/css/chartist-custom.css')}}">
    <!-- MAIN CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/main.css')}}">
    <!-- GOOGLE FONTS -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
    <!-- ICONS -->
    <link rel="icon" type="image/png" sizes="96x96" href="{{asset('assets/img/logo.png')}}">
    <style type="text/css">
        .my-icon {
            background: url('{{asset('assets/img/logo.png')}}');
            height: 21px;
            width: 21px;
            display: inline-block;
            /* Other styles here */
        }

        .vertical-center {
            vertical-align: 5px;
        }
    </style>
</head>
<body>
<!-- WRAPPER -->
<div id="wrapper">
    <!-- NAVBAR -->
@include('layouts._navbar')
<!-- END NAVBAR -->

    <!-- SIEDEBAR -->
@include('layouts._sidebar')
<!-- END SIDEBAR -->

    <!-- MAIN -->
@yield('content')
<!-- END MAIN -->
    <div class="clearfix"></div>

    <!-- FOOTER -->
@include('layouts._footer')
<!-- END FOOTER -->
</div>
<!-- END WRAPPER -->
<!-- Javascript -->
<script src="{{asset('assets/vendor/jquery/jquery.min.js')}}"></script>
<script src="{{asset('assets/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
<script src="{{asset('assets/vendor/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
<script src="{{asset('assets/vendor/jquery.easy-pie-chart/jquery.easypiechart.min.js')}}"></script>
<script src="{{asset('assets/vendor/chartist/js/chartist.min.js')}}"></script>
<script src="{{asset('assets/scripts/klorofil-common.js')}}"></script>
<script type="text/javascript">
    $('body').on('click', 'nav ul li a' , function () {
        $(this).closest('nav ul').find('a.active').removeClass('active');
        localStorage.setItem('lastActiveId', $(this).attr('id'));
    });

    $(function () {
        //check if defined
        if(!!localStorage.getItem('lastActiveId'))
        {
            $('#'.concat(localStorage.getItem('lastActiveId'))).addClass('active');
            localStorage.removeItem('lastActiveId');
        }
    });
</script>
@yield('script')
</body>
</html>
