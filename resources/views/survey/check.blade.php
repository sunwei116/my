<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>查看</title>
</head>
<body>
    <h2>调研项目:{{$survey->survey}}</h2>
    <h5>调研问题：{{$issue->issue}}</h5>
    @if($issue->type == 1)
       <p>单选：</p>
    <input type="radio" name="a" disabled> A: <input type="text" value="{{$issue->A}}" disabled>
       <input type="radio" name="a" disabled> B :<input type="text" value="{{$issue->B}}" disabled>
       <input type="radio" name="a" disabled>  C: <input type="text" value="{{$issue->C}}" disabled>
       <input type="radio" name="a" disabled>D :<input type="text" value="{{$issue->D}}" disabled>
        <h4>调研结果：<input type="text" value="{{$issue->result}}" disabled></h4>
        @else
        <input type="checkbox" name="a" disabled> A: <input type="text" value="{{$issue->A}}" disabled>
        <input type="checkbox" name="a" disabled> B :<input type="text" value="{{$issue->B}}" disabled>
        <input type="checkbox" name="a" disabled>  C: <input type="text" value="{{$issue->C}}" disabled>
        <input type="checkbox" name="a" disabled>D :<input type="text" value="{{$issue->D}}" disabled>
        <h4>调研结果：<input type="text" value="{{$issue->result}}" disabled></h4>
    @endif
</body>
</html>