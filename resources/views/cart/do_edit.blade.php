<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>缴费</title>
</head>
<body>
<form action="{{url('cart/update')}}" method="post">
    @csrf
        <center>
            <h3>尊敬的{{$cart}}车主</h3>
            <input type="hidden" name="time" value="{{$time}}">
            <input type="hidden" name="price" value="{{$price}}">
            <input type="hidden" name="id" value="{{$id}}">
            <h3>停车{{$h}}小时{{$m}}分钟</h3>
            <h3>需缴费{{$price}}元</h3>
            <input type="submit" value="确定缴费">
        </center>
</form>
</body>
</html>