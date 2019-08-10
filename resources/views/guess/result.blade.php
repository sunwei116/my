<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>竞猜结果</title>
</head>
<body>
<center>
        <h1>竞猜结果</h1>
        <h3> 对阵结果：&nbsp;&nbsp;{{$data->team1}} &nbsp;&nbsp;@if($data->result == 1)胜@elseif($data->result ==2)负@else平@endif

                &nbsp;&nbsp;{{$data->team2}}</h3>
        <h3> 您的竞猜：&nbsp;&nbsp;{{$data->team1}} &nbsp;&nbsp;@if($data->guess == 1)胜@elseif($data->guess ==2)负@elseif($data->guess == 3)平@else很遗憾你没有竞猜@endif

                &nbsp;&nbsp;{{$data->team2}}</h3>
        <h2>@if($data->guess == $data->result)很遗憾，猜对了@elseif($data->guess == null)您没竞猜@else恭喜你猜错了，枪毙100次@endif</h2>

</center>
</body>
</html>