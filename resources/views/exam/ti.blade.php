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
<form action="{{url('exam/doti')}}" method="post">
    @csrf
    @if($data['a'] ==1)
        <h5><input type="text" value="laravel框架定义中间件的关键词是" style="width: 230px" name="title"></h5>
        <input type="radio" name="A" value="middleware" id="">A: <input type="text"  value="middleware" disabled="disabled">
        <input type="radio" name="B" value="controller"  id="">B: <input type="text"  value="controller" disabled="disabled">
        <input type="radio" name="C" value="model"  id="">C: <input type="text"  value="model" disabled="disabled">
        <input type="radio" name="D" value="migration"  id="">D: <input type="text" value="migration" disabled="disabled">
        <input type="hidden" value="1" name="type">
        @elseif($data['a'] == 2)
        <h5><input type="text" value="面向对象的特征" name="title"></h5>
        <input type="checkbox" name="A"   value="封装">:<input type="text" value="封装" disabled="disabled">
        <input type="checkbox" name="B"  value="继承"><input type="text" value="继承" disabled="disabled">
        <input type="checkbox" name="C"  value="多态"><input type="text" value="多态" disabled="disabled">
        <input type="checkbox" name="D"  value="抽象"><input type="text" value="抽象" disabled="disabled">
        <input type="hidden" value="2" name="type">
    @else
        <p><input type="text" value="laravel框架用composer安装只能" style="width: 200px" name="title"></p>
        <input type="radio" name="panduan" value="正确">A: <input type="text" value="正确" disabled="disabled">
        <input type="radio" name="panduan" value="错误">B: <input type="text" value="错误" disabled="disabled">
        <input type="hidden" value="3" name="type">
    @endif
    <input type="submit" value="添加">
</form>
</body>
</html>