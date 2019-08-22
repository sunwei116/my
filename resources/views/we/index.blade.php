<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <p>账号：<input type="text" name="name"></p>
    <p>密码：<input type="password" name="pwd"></p>
    <a href="{{url('we/login')}}">微信登录</a>
    <input type="submit" value="登录">
</body>
</html>