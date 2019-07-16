<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>商品添加</title>
</head>
<body>
<form action="{{url('/goods/update')}}" method="post" enctype="multipart/form-data">
    @csrf
    <p>商品名称：<input type="text" name="name" value="{{$goods->name}}"></p>
    <p>图片：<img src="{{$goods->pic}}" alt="" width="100" height="100"></p>
    <p>修改图片：<input type="file" name="pic"></p>
    <P>库存：<input type="text" name="store" value="{{$goods->store}}"></P>
    <P><input type="submit" value="修改"></P>
</form>

</body>
</html>