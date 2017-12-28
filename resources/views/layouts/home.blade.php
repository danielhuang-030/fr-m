<!DOCTYPE html>
<!--[if lt IE 9 ]> <html lang="en" dir="ltr" class="no-js ie-old"> <![endif]-->
<!--[if IE 9 ]> <html lang="en" dir="ltr" class="no-js ie9"> <![endif]-->
<!--[if IE 10 ]> <html lang="en" dir="ltr" class="no-js ie10"> <![endif]-->
<!--[if (gt IE 10)|!(IE)]><!-->
<html lang="en" dir="ltr" class="no-js">
<!--<![endif]-->
<head>

    <!-- ––––––––––––––––––––––––––––––––––––––––– -->
    <!-- META TAGS                                 -->
    <!-- ––––––––––––––––––––––––––––––––––––––––– -->
    <meta charset="utf-8">
    <!-- Always force latest IE rendering engine -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Mobile specific meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <!-- ––––––––––––––––––––––––––––––––––––––––– -->
    <!-- PAGE TITLE                                -->
    <!-- ––––––––––––––––––––––––––––––––––––––––– -->
    <title>@yield('title', $title ?? env('APP_NAME'))</title>

    <!-- ––––––––––––––––––––––––––––––––––––––––– -->
    <!-- SEO METAS                                 -->
    <!-- ––––––––––––––––––––––––––––––––––––––––– -->
    <meta name="description" content="">
    <meta name="black friday, coupon, coupon codes, coupon theme, coupons, deal news, deals, discounts, ecommerce, friday deals, groupon, promo codes, responsive, shop, store coupons">
    <meta name="Keywords" content="" />

    <!-- ––––––––––––––––––––––––––––––––––––––––– -->
    <!-- PAGE FAVICON                              -->
    <!-- ––––––––––––––––––––––––––––––––––––––––– -->
    <link rel="apple-touch-icon" href="{{ asset('assets/shop/images/favicon/apple-touch-icon.png') }}">
    <link rel="icon" href="{{ asset('assets/shop/images/favicon/favicon.ico') }}'">

    <!-- ––––––––––––––––––––––––––––––––––––––––– -->
    <!-- GOOGLE FONTS                              -->
    <!-- ––––––––––––––––––––––––––––––––––––––––– -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,600" rel="stylesheet">

    <!-- ––––––––––––––––––––––––––––––––––––––––– -->
    <!-- Include CSS Filess                        -->
    <!-- ––––––––––––––––––––––––––––––––––––––––– -->

    <!-- Bootstrap -->
    <link href="{{ asset('assets/shop/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="{{ asset('assets/shop/vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">

    <!-- Linearicons -->
    <link href="{{ asset('assets/shop/vendors/linearicons/css/linearicons.css') }}" rel="stylesheet">

    <!-- Owl Carousel -->
    <link href="{{ asset('assets/shop/vendors/owl-carousel/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/shop/vendors/owl-carousel/owl.theme.min.css') }}" rel="stylesheet">

    <!-- Flex Slider -->
    <link href="{{ asset('assets/shop/vendors/flexslider/flexslider.css') }}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{ asset('assets/shop/css/base.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/shop/css/style.css') }}" rel="stylesheet">

    <!-- ––––––––––––––––––––––––––––––––––––––––– -->
    <!-- Initialize jQuery library                 -->
    <!-- ––––––––––––––––––––––––––––––––––––––––– -->
    <script src="{{ asset('assets/shop/js/jquery-1.12.3.min.js') }}"></script>

    @yield('style')
</head>

<body id="body" class="wide-layout preloader-active">
<!--[if lt IE 9]>
<p class="browserupgrade alert-error">
    You are using a <strong> obsolete </ strong> browser. Please <a href="http://browsehappy.com/"> upgrade your browser </a> to enhance your experience.
</p>
<![endif]-->

<noscript>
    <div class="noscript alert-error">
        It is necessary for this site to enable full functionality of JavaScript. this is
         <a href="http://www.enable-javascript.com/" target="_blank">
             Explains how to enable JavaScript in your web browser </a>.
    </div>
</noscript>

<!-- ––––––––––––––––––––––––––––––––––––––––– -->
<!-- 加载动画                                 -->
<!-- ––––––––––––––––––––––––––––––––––––––––– -->
<!-- Preloader -->
<div id="preloader" class="preloader">
    <div class="loader-cube">
        <div class="loader-cube__item1 loader-cube__item"></div>
        <div class="loader-cube__item2 loader-cube__item"></div>
        <div class="loader-cube__item4 loader-cube__item"></div>
        <div class="loader-cube__item3 loader-cube__item"></div>
    </div>
</div>
<!-- End Preloader -->
<!-- ––––––––––––––––––––––––––––––––––––––––– -->
<!-- WRAPPER                                   -->
<!-- ––––––––––––––––––––––––––––––––––––––––– -->
<div id="pageWrapper" class="page-wrapper">
    <!-- –––––––––––––––[ HEADER ]––––––––––––––– -->
    @include('common.home.header')
    @include('common.home.search')
    <!-- –––––––––––––––[ HEADER ]––––––––––––––– -->

        <!-- –––––––––––––––[ PAGE CONTENT ]––––––––––––––– -->
    @yield('main')
    <!-- –––––––––––––––[ END PAGE CONTENT ]––––––––––––––– -->

    @include('common.home.area')
    <!-- –––––––––––––––[ FOOTER ]––––––––––––––– -->
    @include('common.home.footer')
    <!-- –––––––––––––––[ END FOOTER ]––––––––––––––– -->

</div>
<!-- ––––––––––––––––––––––––––––––––––––––––– -->
<!-- END WRAPPER                               -->
<!-- ––––––––––––––––––––––––––––––––––––––––– -->


<!-- ––––––––––––––––––––––––––––––––––––––––– -->
<!-- 回到顶部                                   -->
<!-- ––––––––––––––––––––––––––––––––––––––––– -->
<div id="backTop" class="back-top is-hidden-sm-down">
    <i class="fa fa-angle-up" aria-hidden="true"></i>
</div>

<!-- ––––––––––––––––––––––––––––––––––––––––– -->
<!-- SCRIPTS                                   -->
<!-- ––––––––––––––––––––––––––––––––––––––––– -->

<!-- (!) Placed at the end of the document so the pages load faster -->

<!-- ––––––––––––––––––––––––––––––––––––––––– -->
<!-- Latest compiled and minified Bootstrap    -->
<!-- ––––––––––––––––––––––––––––––––––––––––– -->
<script type="text/javascript" src="{{ asset('assets/shop/js/bootstrap.min.js') }}"></script>

<!-- ––––––––––––––––––––––––––––––––––––––––– -->
<!-- JavaScript Plugins                        -->
<!-- ––––––––––––––––––––––––––––––––––––––––– -->
<!-- (!) Include all compiled plugins (below), or include individual files as needed -->

<!-- Modernizer JS -->
<script src="{{ asset('assets/shop/vendors/modernizr/modernizr-2.6.2.min.js') }}"></script>

<!-- Owl Carousel -->
<script type="text/javascript" src="{{ asset('assets/shop/vendors/owl-carousel/owl.carousel.min.js') }}"></script>

<!-- FlexSlider -->
<script type="text/javascript" src="{{ asset('assets/shop/vendors/flexslider/jquery.flexslider-min.js') }}"></script>

<!-- Coutdown -->
<script type="text/javascript" src="{{ asset('assets/shop/vendors/countdown/jquery.countdown.js') }}"></script>

<!-- ––––––––––––––––––––––––––––––––––––––––– -->
<!-- Custom Template JavaScript                   -->
<!-- ––––––––––––––––––––––––––––––––––––––––– -->
<script type="text/javascript" src="{{ asset('assets/shop/js/main.js') }}"></script>

@yield('script')
</body>

</html>

