<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>调研项目</title>
</head>
<body>
<form action="{{url('survey/issue')}}" method="post">
    @csrf
    <center>
        <h3>调研项目：<input type="text" name="name"></h3>
        <input type="submit" value="添加">
    </center>
</form>
</body>
</html>