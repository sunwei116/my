<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>列表</title>
</head>
<body>
<form action="{{url('/goods/index')}}" method="get">
    <input type="text" name="ss" value="{{$ss}}">
    <input type="submit" value="搜索">
</form>
    <table border="1" align="center">
        <tr>
            <th>名字</th>
            <th>图片</th>
            <th>库存</th>
            <th>时间</th>
            <th>操作</th>
        </tr>
        @foreach($goods as $v)
        <tr>
            <td>{{$v->name}}</td>
            <td><img src="{{$v->pic}}" alt="" width="50" height="50"></td>
            <td>{{$v->store}}</td>
            <td>{{$v->add_time}}</td>
            <td>
                <a href="{{url('/goods/delete')}}?id={{$v->id}}">删除</a>
                <a href="{{url('/goods/edit')}}?id={{$v->id}}">修改</a>
            </td>
        </tr>
            @endforeach
    </table>
{{ $goods->appends(['ss' => $ss])->links() }}
</body>
</html>