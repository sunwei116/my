<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>添加</title>
</head>
<body>
<form action="{{url('student/save')}}" method="post">
    @csrf
    <center>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <h1>学生添加</h1>
        <p>学生姓名： <input type="text" name="name"> </p>
        <p> 学生年龄： <input type="text" name="age"></p>
        <p>学生性别： <input type="text" name="sex"></p>
        <p>学生介绍： <input type="text" name="content"></p>
        <p><input type="submit" value="添加"></p>
    </center>
</form>
</body>
</html>