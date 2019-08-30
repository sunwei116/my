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
<form action="{{url('save')}}" method="post">
    @csrf
    <h2>添加同学</h2>
    <p>
        姓名：<input type="text" name="name">
    </p>
    <p>
        年龄：<input type="text" name="age">
    </p>
    <p>
        性别：<input type="radio" name="sex" value="1">男
        <input type="radio" name="sex" value="2">女
    </p>
    <p>
        班级：<input type="radio" name="class" value="1901" id="">1901班
             <input type="radio" name="class" value="1902" id="">1902班
    </p>
    <p>
        <input type="submit">
    </p>
</form>
</body>
</html>