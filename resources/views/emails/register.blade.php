<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>User Activation</title>
    <meta charset="utf-8" />
    <style type="text/css">
        .qmbox body {
            margin: 0;
            padding: 0;
            background: #fff;
            font-family: "Verdana, Arial, Helvetica, sans-serif";
            font-size: 14px;
            line-height: 24px;
        }

        .qmbox div, .qmbox p, .qmbox span, .qmbox img {
            margin: 0;
            padding: 0;
        }

        .qmbox img {
            border: none;
        }

        .qmbox .contaner {
            margin: 0 auto;
        }

        .qmbox .title {
            margin: 0 auto;
            background: url() #CCC repeat-x;
            height: 30px;
            text-align: center;
            font-weight: bold;
            padding-top: 12px;
            font-size: 16px;
        }

        .qmbox .content {
            margin: 4px;
        }

        .qmbox .biaoti {
            padding: 6px;
            color: #000;
        }

        .qmbox .xtop, .qmbox .xbottom {
            display: block;
            font-size: 1px;
        }

        .qmbox .xb1, .qmbox .xb2, .qmbox .xb3, .qmbox .xb4 {
            display: block;
            overflow: hidden;
        }

        .qmbox .xb1, .qmbox .xb2, .qmbox .xb3 {
            height: 1px;
        }

        .qmbox .xb2, .qmbox .xb3, .qmbox .xb4 {
            border-left: 1px solid #BCBCBC;
            border-right: 1px solid #BCBCBC;
        }

        .qmbox .xb1 {
            margin: 0 5px;
            background: #BCBCBC;
        }

        .qmbox .xb2 {
            margin: 0 3px;
            border-width: 0 2px;
        }

        .qmbox .xb3 {
            margin: 0 2px;
        }

        .qmbox .xb4 {
            height: 2px;
            margin: 0 1px;
        }

        .qmbox .xboxcontent {
            display: block;
            border: 0 solid #BCBCBC;
            border-width: 0 1px;
        }

        .qmbox .line {
            margin-top: 6px;
            border-top: 1px dashed #B9B9B9;
            padding: 4px;
        }

        .qmbox .neirong {
            padding: 6px;
            color: #666666;
        }

        .qmbox .foot {
            padding: 6px;
            color: #777;
        }

        .qmbox .font_darkblue {
            color: #006699;
            font-weight: bold;
        }

        .qmbox .font_lightblue {
            color: #008BD1;
            font-weight: bold;
        }

        .qmbox .font_gray {
            color: #888;
            font-size: 12px;
        }
    </style>
</head>
<body>
<div class="qmbox qm_con_body_content qqmail_webmail_only" id="mailContentContainer" style="">

    <div class="contaner">
        <div class="title">User Activation</div>
        <div class="content">
            <p class="biaoti"><b>Welcome to register this website user!</b></p>
            <b class="xtop"><b class="xb1"></b><b class="xb2"></b><b class="xb3"></b><b class="xb4"></b></b>
            <div class="xboxcontent">
                <div class="neirong">
                    <p><b>Welcome</b><span id="userName" class="font_darkblue">
                            {{ $user->name }}
                        </span></p>
                    <p>
                        <span class="font_lightblue">
                            <a href="{{ url('register/active') }}/{{ $user->active_token }}">Please click this link to activate the user</a>
                        </span><br>
                        <span class="font_gray"></span></p>
                    <div class="line">If your link can not work, please copy
                        <span id="yzm" style="border-bottom: 1px dashed rgb(204, 204, 204); z-index: 1; position: static;"><pre>{{ url('register/active') }}/{{ $user->active_token }}</pre></span> into the browser
                    </div>
                </div>
            </div>
            <b class="xbottom"><b class="xb4"></b><b class="xb3"></b><b class="xb2"></b><b class="xb1"></b></b>
            <p class="foot">If you still have questions, contact the administrator:
                <span  style="border-bottom: 1px dashed rgb(204, 204, 204);">
                    <a href="mailto: {{ env('MAIL_FROM_ADDRESS') }}">{{ env('MAIL_FROM_ADDRESS') }}</a>
                </span>
            </p>
        </div>
    </div>
    <style type="text/css">
        .qmbox style, .qmbox script, .qmbox head, .qmbox link, .qmbox meta {
            display: none !important;
        }
    </style>
</div>
</body>
</html>