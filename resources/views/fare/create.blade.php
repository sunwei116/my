<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>添加车票</title>
</head>
<body>
<form action="{{url('fare/save')}}" method="post">
    @csrf
    <table border="1" align="center">
        <tr>
            <th>车次</th>
            <td><input type="text" name="checi"></td>
        </tr>
        <tr>
            <th>出发站</th>
            <td><input type="text" name="depart"></td>
        </tr>
        <tr>
            <th>到达站</th>
            <td><input type="text" name="arrive"></td>
        </tr>
        <tr>
            <th>价钱</th>
            <td><input type="text" name="price"></td>
        </tr>
        <tr>
            <th>张数</th>
            <td><input type="text" name="num"></td>
        </tr>
        <tr>
            <th>出发时间</th>
            <td><input type="text" name="dtime"></td>
        </tr>
        <tr>
            <th>到达时间</th>
            <td><input type="text" name="atime"></td>
        </tr>
        <tr>
            <td colspan="2">
                <button align="riget">添加</button>
            </td>
        </tr>
    </table>
</form>
</body>
</html>