<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="/static/layui/jquery-3.3.1.js"></script>
    <title>列表</title>
</head>
<body>
    <center>
        <h1>竞猜列表</h1>
        @foreach ($data as $val)
           <h3>{{$val->team1}}&nbsp;&nbsp;&nbsp;&nbsp;VS&nbsp;&nbsp;&nbsp;&nbsp;{{$val->team2}}
                   @if($val->add_time < time())
                   &nbsp;&nbsp;&nbsp;&nbsp; <a href="{{url('guess/result')}}?id={{$val->id}}">查看详情</a>
               @else
                   &nbsp;&nbsp;&nbsp;&nbsp;<a href="{{url('guess/guess')}}?id={{$val->id}}">竞猜</a>
               @endif
               </h3>
        @endforeach
    </center>
</body>
</html>