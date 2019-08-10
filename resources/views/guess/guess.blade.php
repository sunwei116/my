<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>竞猜</title>
</head>
<body>
<form action="{{url('guess/do_guess')}}" method="post">
    @csrf
    <input type="hidden" name="id" value="{{$data->id}}">
<center>
    <h1>我要竞猜</h1>
   <h3>{{$data->team1}}&nbsp;&nbsp;&nbsp;&nbsp; VS &nbsp;&nbsp;&nbsp;&nbsp;{{$data->team2}}</h3>
    <input type="radio" name="guess" value="1">胜&nbsp;&nbsp;&nbsp;&nbsp;
    <input type="radio" name="guess" value="2">负&nbsp;&nbsp;&nbsp;&nbsp;
    <input type="radio" name="guess" value="3">平
    <p><input type="submit"></p>
</center>
</form>
</body>
</html>