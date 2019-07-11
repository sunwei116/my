<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>修改</title>
</head>
<body>
<center>
    <form action="{{url('/student/update')}}" method="post">
    <h1>修改学生信息</h1>
    @csrf
    <input type="hidden" name="id" value="{{ $data->id }}">
    <p> 姓名<input type="text" name="name" value="{{ $data->name }}"></p>
           <p> 年龄<input type="text" name="age" value="{{ $data->age }}"></p>
           <p>性别<input type="text" name="sex" value="{{ $data->sex }}"></p>
           <p>介绍<input type="text" name="content" value="{{ $data->content }}"></p>
           <p><input type="submit" value="修改"></p>
    </form>
</center>
</body>
</html>