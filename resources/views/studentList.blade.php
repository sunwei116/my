<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<center>
    <form action="{{url('/student/index')}}" method="get">
        姓名 <input type="text" name="search" id="" value="{{$search}}">
        <input type="submit" name="" id="" value="搜索">
    </form>
    <h1>学生信息</h1>
    <table border="`">
    <tr>
        <th>ID</th>
        <th>姓名</th>
        <th>年龄</th>
        <th>性别</th>
        <th>介绍</th>
        <th>操作</th>
    </tr>
    @foreach($student as $item)
        <tr>
            <td>{{ $item->id }}</td>
            <td>{{ $item->name }}</td>
            <td>{{ $item->age }}</td>
            <td>{{ $item->sex }}</td>
            <td>{{ $item->content }}</td>
            <td>
                <a href="{{url('/student/delete')}}?id={{$item->id}}">删除</a>||
                <a href="{{url('/student/edit')}}?id={{$item->id}}">修改</a>
            </td>
        </tr>
    @endforeach
    </table>
    {{ $student->appends(['search' => $search])->links() }}
</center>

</body>
</html>