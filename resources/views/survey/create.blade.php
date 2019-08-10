<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="/static/layui/jquery-3.3.1.js"></script>
    <title>添加问题</title>
</head>
<body>
<form action="{{url('survey/wenti')}}" method="post">
    @csrf
    <center>
        调研问题：<input type="text" name="issue">
        <p>问题选项：<input type="radio" name="type" value="1">单选 <input type="checkbox" name="type" value="2">多选
            <input type="hidden" name="sid" value="{{$id}}">
        <p><input type="submit" value="添加问题"></p>
    </center>
</form>
</body>
</html>