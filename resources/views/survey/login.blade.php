<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>登录</title>
</head>
<body>
<form action="{{url('survey/dologin')}}" method="post">
    @csrf
    <p> 账号：<input type="text" name="account"> </p>
    <p> 密码：<input type="password" name="pwd"> </p>
    <input type="submit" value="登录">
</form>
</body>
</html>