<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>صفحه ورود</title>

    <link href="/css/login.css" rel="stylesheet">
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/bootstrap-rtl.css" rel="stylesheet">
    <link href="/css/font-awesome.min.css" rel="stylesheet">
    <script src="/js/jquery1-12-4/jquery-1.12.4.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/custom.js"></script>

</head>

<body onload="DrawCaptcha();" style="overflow-y: hidden">
<div class="container-fluid">
    <div class="login-page">
        <div class="form">
            <img src="/img/pazyryk.png">
            <h5 style="color: #1097a6;margin-bottom: 20px;text-shadow: 2px 2px 15px rgba(0,0,0,0.47) "> سیستم مدیریت یکپارچه قالیشویی </h5>

            {{--<h2>پازیریک</h2>--}}
            <form action="/login" method="post" class="login-form">
                {{csrf_field()}}
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div>
                        @if ($errors->has('username'))
                            <strong class="error">{{$errors->first('username')}}</strong>
                        @endif
                        <input type="text" name="username" placeholder="نام کاربری"
                               value="{{old('username')}}">
                    </div>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div>
                        @if ($errors->has('password'))
                            <strong class="error">{{$errors->first('password')}}</strong>
                        @endif
                        <input type="password" name="password"
                               placeholder= "کلمه عبور">
                    </div>
                </div>
                <button type="submit"> ورود <span
                            class="glyphicon glyphicon-log-in">  </span>
                </button>
            </form>

        </div>
    </div>
</div>

</body>
</html>