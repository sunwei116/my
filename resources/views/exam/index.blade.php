<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>题库</title>
    <script src="/static/layui/jquery-3.3.1.js"></script>

</head>
<body>
<form action="{{url('exam/ti')}}" method="post">
    @csrf
    选择题型：<select name="a">
                <option>请选择</option>
                <option value="1" name="a">单选</option>
                <option value="2" name="a">多选</option>
                <option value="3" name="a">判断</option>
            </select>
    <input type="submit" value="确定">
</form>
</body>
</html>