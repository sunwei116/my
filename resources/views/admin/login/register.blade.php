<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>注册</title>
</head>
<body>
<form action="{{url('admin/login/doRegister')}}" method="post">
    @csrf
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <p>账号：<input type="text" name="name" id=""></p>
    <p>密码：<input type="password" name="password" id=""></p>
    <p>邮箱：<input type="email" name="email" id=""></p>
    <p><input type="submit" value="注册"></p>
</form>

</body>
</html>