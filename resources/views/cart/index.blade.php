<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>车库系统</title>
</head>
<body>
    小区车位：400&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="{{url('cart/create')}}">车辆入库</a>
    <p>
    剩余车位：{{$chewei}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="{{url('cart/edit')}}">车辆出库</a>
    <p>
</body>
</html>