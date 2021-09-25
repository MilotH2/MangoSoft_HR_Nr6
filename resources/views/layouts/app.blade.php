<!doctype html>
<html lang="en">

<head>
    <title>Mangosoft HR </title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="description" content="Lucid Bootstrap 4x Admin Template">
    <meta name="author" content="WrapTheme, design by: ThemeMakker.com">

    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <!-- VENDOR CSS -->
    <link rel="stylesheet" href="/assets/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/vendor/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="/assets/vendor/chartist/css/chartist.min.css">
    <link rel="stylesheet" href="/assets/vendor/chartist-plugin-tooltip/chartist-plugin-tooltip.css">
    <link rel="stylesheet" href="/assets/vendor/toastr/toastr.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw==" crossorigin="anonymous" />
    <!-- MAIN CSS -->
    <link rel="stylesheet" href="/frontend_assets/css/main.css">
    <link rel="stylesheet" href="/frontend_assets/css/color_skins.css">
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body class="theme-blue">

<!-- Page Loader -->
{{--<div class="page-loader-wrapper">--}}
{{--    <div class="loader">--}}
{{--        <div class="m-t-30"><img src="/assets/images/logo.png" width="48" height="48" alt="Mangosoft"></div>--}}
{{--        <p>Please wait...</p>--}}
{{--    </div>--}}
{{--</div>--}}
<!-- Overlay For Sidebars -->

<div id="wrapper">
    @include("layouts.nav")
    @if(auth()->check())
        @include("layouts.menu")
    @endif
    @yield("content")
</div>


<!-- Javascript -->
<script src="/frontend_assets/bundles/libscripts.bundle.js"></script>
<script src="/frontend_assets/bundles/vendorscripts.bundle.js"></script>
<script src="/frontend_assets/bundles/datatablescripts.bundle.js"></script>
<script src="/assets/vendor/toastr/toastr.js"></script>
<script src="/frontend_assets/bundles/knob.bundle.js"></script> <!-- Jquery Knob-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous"></script>
<script src="/frontend_assets/bundles/mainscripts.bundle.js"></script>

@yield("footer")

</body>
</html>
