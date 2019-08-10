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
<form action="{{url('fare/lists')}}" method="get" align="center">
    搜索: <input type="text" name="ss" value="{{$ss}}">
    <p><input type="submit" value="搜索"></p>
</form>
<table border="1" align="center">
    <tr>
        <td>车次</td>
        <td>出发站</td>
        <td>到达站</td>
        <td>价格</td>
        <td>张数</td>
        <td>操作</td>
    </tr>
    @foreach($data as $v)
        <tr>
            <td>{{$v['checi']}}</td>
            <td>{{$v['depart']}}</td>
            <td>{{$v['arrive']}}</td>
            <td>{{$v['price']}}</td>
            <td>@if( $v['num'] > 100)
                   有
                    @elseif($v['num'] == 0)
                    无
                    @else
                    {{$v['num']}}
                    @endif
            </td>
            <td>
                @if($v['num'] < 1)
                <a>预定</a>
            @else
                <a href="#">预定</a>
            @endif
            </td>
        </tr>
        @endforeach
</table>
</body>
</html>