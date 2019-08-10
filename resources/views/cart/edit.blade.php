<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>出库</title>
</head>
<body>
<form action="{{url('cart/do_edit')}}" method="post">
    @csrf
    <center>
        <h1>车辆出库</h1>
        <p>车牌号：<input type="text" name="cart_num"></p>
        <input type="submit" value="车辆离开">
    </center>
</form>
</body>
</html>