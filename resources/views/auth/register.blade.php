@extends('common.home.auth')

@section('style')

@endsection

@section('main')
    <main id="mainContent" class="main-content">
        <div class="page-container ptb-60">
            <div class="container">

                @if (session()->has('status'))
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        {{ session('status') }}
                    </div>
                @endif

                <section class="sign-area panel p-40">
                    <h3 class="sign-title">Register <small>Or <a href="{{ route('login') }}" class="color-green">Login</a></small></h3>
                    <div class="row row-rl-0">
                        <div class="col-sm-6 col-md-7 col-left">
                            <form class="p-40" id="register_form" method="post" action="{{ route('register') }}">

                                {{ csrf_field() }}

                                <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                                    <label class="sr-only">Username</label>
                                    <input type="text" class="form-control input-lg" placeholder="Username" name="name" value="{{ old('name') }}" required autofocus>
                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label class="sr-only">Email</label>
                                    <input type="email" class="form-control input-lg" placeholder="Email" name="email" value="{{ old('email') }}" required>

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif

                                </div>

                                <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                                    <label class="sr-only">Password</label>
                                    <input type="password" class="form-control input-lg" placeholder="Password" name="password" required>
                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label class="sr-only">Password Confirm</label>
                                    <input type="password" class="form-control input-lg" placeholder="Password Confirm" name="password_confirmation" required>
                                </div>

                                <div class="form-group{{ $errors->has('captcha') ? ' has-error' : '' }}">
                                        <label class="sr-only">Verification Code</label>

                                        <div style="position: relative;">
                                            <input width="50px" id="text" maxlength="4" type="text" class="form-control input-lg" name="captcha" placeholder="Verification Code" required>
                                            <img style="position: absolute;top: 0; right: 0; cursor: pointer;" src="{{captcha_src()}}" onclick="this.src='{{ url("captcha/default") }}?'+Math.random()" alt="Verification Code" id="captcha">
                                        </div>

                                        @if ($errors->has('captcha'))
                                            <div class="has-error">
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('captcha') }}</strong>
                                                </span>
                                            </div>
                                        @endif
                                </div>


                                <div class="custom-checkbox mb-20">
                                    <input type="checkbox" id="agree_terms">
                                    <label class="color-mid" for="agree_terms">
                                        I agree
                                        <a href="#" class="color-green" target="_blank">the privacy</a>
                                    </label>
                                    <span class="has-error">
                                        <strong id="checkbox_text" class="help-block"></strong>
                                    </span>
                                </div>
                                <button type="submit" class="btn btn-block btn-lg">Register</button>
                            </form>
                            <span class="or">Or</span>
                        </div>
                        <?php /*
                        <div class="col-sm-6 col-md-5 col-right">
                            <div class="social-login p-40">
                                <div class="mb-20">
                                    <a href="{{ url('/auth/github') }}" class="btn btn-lg btn-block btn-social btn-facebook"><i class="fa  fa-github"></i>Login Github</a>
                                </div>
                                <div class="mb-20">
                                    <a href="{{ url('/auth/qq') }}" class="btn btn-lg btn-block btn-social btn-twitter"><i class="fa fa-qq"></i>Login  QQ</a>
                                </div>
                                <div class="mb-20">
                                    <a href="{{ url('/auth/weibo') }}" class="btn btn-lg btn-block btn-social btn-google-plus"><i class="fa fa-weibo"></i>Login  微博</a>
                                </div>
                                <div class="text-center color-mid">
                                    已经有账号 ? <a href="{{ route('login') }}" class="color-green">Login</a>
                                </div>
                            </div>
                        </div>
                        */ ?>
                    </div>
                </section>
            </div>
        </div>


    </main>
@endsection

@section('script')
    <script>
    $('#register_form').submit(function() {

        if(!$('#agree_terms').is(':checked')) {
            $('#checkbox_text').text('Please agree the privacy');

            setTimeout(function(){
                $('#checkbox_text').text('');
            }, 3000);

            return false;
        }

        return true;
    });
    </script>
@endsection