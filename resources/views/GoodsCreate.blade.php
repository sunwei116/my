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
<form action="{{url('/goods/save')}}" method="post" enctype="multipart/form-data">
    @csrf
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <p>商品名称：<input type="text" name="name"></p>
    <p>添加图片：<input type="file" name="pic"></p>
    <P>库存：<input type="text" name="store"></P>
    <P><input type="submit"></P>
</form>

</body>
</html>