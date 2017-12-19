<header id="mainHeader" class="main-header">

    <!-- Top Bar -->
    <div class="top-bar bg-gray">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-4 is-hidden-sm-down">
                    <ul class="nav-top nav-top-left list-inline t-left">
                    <?php /*
                        <li><a href="https://baidu.com"><i class="fa fa-question-circle"></i>指南</a>
                        </li>
                        <li><a href="https://baidu.com"><i class="fa fa-support"></i>帮助</a>
                        </li>
                    */ ?>
                    </ul>
                </div>
                <div class="col-sm-12 col-md-8">
                    <ul class="nav-top nav-top-right list-inline t-xs-center t-md-right">
                        @auth
                            <li>
                                <a href="{{ url('/user') }}"><i class="fa fa-user"></i>{{ Auth::user()->name }}</a>
                            </li>
                            <li>
                                <a href="{{ route('logout') }}"><i class="fa fa-lock"></i>Logout</a>
                            </li>
                        @endauth
                        @guest
                            <li><a href="#"><i class="fa fa-user"></i>Guest</a></li>
                            <li><a href="{{ url('login') }}?redirect_url={{ url()->current() }}"><i class="fa fa-lock"></i>Login</a>
                            </li>
                            <li><a href="{{ url('register') }}"><i class="fa fa-user"></i>Register</a>
                            </li>
                        @endguest

                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End Top Bar -->



</header>