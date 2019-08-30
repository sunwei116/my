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
    <table border="`">
        <tr>
            <th>姓名</th>
            <th>年龄</th>
            <th>性别</th>
            <th>班级</th>
            <th>操作</th>
        </tr>
        @foreach($data as $key => $value)
            <tr>
                <td>{{$value->name}}</td>
                <td>{{$value->age}}</td>
                <td>{{$value->sex}}</td>
                <td>{{$value->class}}</td>
                <td>
                    <a href="{{url('delete')}}?id={{$value->id}}">删除</a>
                    <a href="{{url('edit')}}?id={{$value->id}}">修改</a>
                </td>
            </tr>
        @endforeach
    </table>
</body>
</html>