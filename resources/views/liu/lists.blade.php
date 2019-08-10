<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>展示</title>
</head>
<body>
<form action="{{url('liu/create')}}" method="post">
    @csrf
    <h3>内容 <textarea name="content" id="" cols="30" rows="3"></textarea></h3>
    <p><input type="submit"></p></form>
<form action="{{url('liu/lists')}}" method="get">
    <input type="text" name="sou">
    <input type="submit" value="搜索">
</form>
<table border="`">
        <tr>
            <th>编号</th>
            <th>内容</th>
            <th>姓名</th>
            <th>时间</th>
            <th>操作</th>
        </tr>
        @foreach($data as $val)
            <tr>
                <td>{{$val->id}}</td>
                <td>{{$val->content}}</td>
                <td>{{$val->name}}</td>
                <td>{{$val->add_time}}</td>
                <td><a href="{{url('liu/delete')}}?id={{$val->id}}">删除</a></td>
            </tr>
            @endforeach
    </table>
</body>
</html>