<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>添加试卷</title>
</head>
<body>
<form action="{{url('exam/shengcheng')}}" method="post">
    @csrf
<center>
    <h5>试卷名称</h5><input type="text" name="ming" value="laravel框架的第一次考试">
    <input type="submit" value="添加">
</center>
</form>
</body>
</html>