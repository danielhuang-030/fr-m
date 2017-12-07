@extends('layouts.user')

@section('style')
    <link rel="stylesheet" href="{{ asset('assets/admin/lib/layui/css/layui.css') }}">
    <link href="{{ asset('assets/user/css/infstyle.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('main')
    <div class="main-wrap">

        <div class="user-info">
            <!--标题 -->
            <div class="am-cf am-padding">
                <div class="am-fl am-cf"><strong class="am-text-danger am-text-lg">Personal&nbsp;information</strong></div>
            </div>
            <hr/>

            <!--头像 -->
            <div class="user-infoPic">
                @inject('userPresenter', 'App\Presenters\UserPresenter')
                <div class="filePic">
                    <img style="cursor: pointer;width: 60px;height: 60px;" id="avatar_img" class="am-circle am-img-thumbnail" src="{{ $userPresenter->getAvatarLink($user->avatar) }}" alt="{{ $user->name }}" />
                </div>

                <p class="am-form-help">Avatar</p>

                <div class="info-m">
                    <div><b>Username: <i>{{ $user->name }}</i></b></div>
                </div>
            </div>

            <!--个人信息 -->
            <div class="info-main">
                @if (session()->has('status') > 0)
                    <div class="am-alert am-alert-success" data-am-alert>
                        <button type="button" class="am-close">&times;</button>
                        <p>{{ session('status') }}</p>
                    </div>
                @endif
                @if ($errors->count() > 0)
                    <div class="am-alert am-alert-danger" data-am-alert>
                        <button type="button" class="am-close">&times;</button>
                        <p>{{ $errors->first() }}</p>
                    </div>
                @endif
                <form class="am-form am-form-horizontal" method="post" action="{{ url('/user/update') }}">

                    {{ csrf_field() }}
                    {{ method_field('PUT') }}

                    <input type="hidden" name="avatar" value="{{ $user->avatar }}">

                    <div class="am-form-group">
                        <label for="user-name2" class="am-form-label">Username</label>
                        <div class="am-form-content">
                            <input type="text" id="user-name2" placeholder="Username" name="name" value="{{ $user->name }}">

                        </div>
                    </div>

                    <div class="am-form-group">
                        <label for="user-email" class="am-form-label">Email</label>
                        <div class="am-form-content">
                            <input id="user-email" placeholder="Email" type="email" value="{{ $user->email }}" disabled="disabled">

                        </div>
                    </div>

                    <div class="info-btn">
                        <button type="submit" class="am-btn am-btn-danger">Save</button>
                    </div>

                </form>
            </div>

        </div>

    </div>
@endsection


@section('script')
    <script src="{{ asset('assets/admin/lib/layui/layui.js') }}"></script>
    <script>
        layui.use('upload', function() {
            var $ = layui.jquery
                ,upload = layui.upload;


            upload.render({
                elem: '#avatar_img'
                ,method: 'post'
                ,url: '{{ url('user/upload/avatar') }}'
                ,done: function(res){

                    if (res.code == 0) {
                        console.log(res.data.src);
                        $('input[name=avatar]').val(res.data.avatar);
                        $('#avatar_img').attr('src', res.data.src);;
                    }

                    layer.msg(res.msg);
                    console.log(res);
                }
            });
        });
    </script>
@endsection
