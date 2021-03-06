<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1.0, user-scalable=0">

    <title>Member</title>

    <link href="{{ asset('assets/user/AmazeUI-2.4.2/assets/css/admin.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/user/AmazeUI-2.4.2/assets/css/amazeui.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset("assets/user/css/systyle.css") }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/user/css/personal.css') }}" rel="stylesheet" type="text/css">
    @yield('style')
</head>

<body>
<!--头 -->
@include('common.user.header')

<b class="line"></b>
<div class="center">
    <div class="col-main">

        @yield('main')

        <!--底部-->
        @include('common.user.footer')


    </div>


    @include('common.user.menu')
</div>

<!-- 手机端样式 -->
<!--引导 -->
<div class="navCir">
    <li><a href="{{ url('/') }}"><i class="am-icon-home "></i>Home</a></li>
    <li><a href="{{ url('/categories') }}"><i class="am-icon-list"></i>Category</a></li>
    <li><a href="{{ url('/carts') }}"><i class="am-icon-shopping-basket"></i>Cart</a></li>
    <li class="active"><a href="{{ url('/user') }}"><i class="am-icon-user"></i>Member</a></li>
</div>


    @yield('script')
</body>

</html>