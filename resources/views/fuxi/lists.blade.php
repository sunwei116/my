<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>列表</title>
</head>
<body>
<form action="{{url('lists')}}" method="get">
    姓名 <input type="text" name="search" id="" value="{{$search}}">
    <input type="submit" name="" id="" value="搜索">
</form>
    <table border="`">
        <tr>
            <th>姓名</th>
            <th>年龄</th>
            <th>性别</th>
            <th>班级</th>
            <th>操作</th>
        </tr>
       <tbody id="lists">

       </tbody>
    </table>
</body>
</html>