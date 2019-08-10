<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="/static/layui/jquery-3.3.1.js"></script>
    <title>添加竞猜球队</title>
</head>
<body>
<form action="{{url('guess/save')}}" method="post">
    @csrf
    <div style="background: #10DDE8;width: 500px;height: 500px" align="center">
        <input type="text" id="team1" name="team1">&nbsp;&nbsp;&nbsp;&nbsp;VS&nbsp;&nbsp;&nbsp;&nbsp; <input type="text" id="team2" name="team2">
        <p>结束竞猜时间：<input type="text" name="add_time">
        <p><button>添加</button></p>
    </div>
</form>
<script>
    $('button').click(function () {

    });
</script>
</body>
</html>