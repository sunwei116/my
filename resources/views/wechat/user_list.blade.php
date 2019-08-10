<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>用户列表</title>
</head>
<body>
    <center>
        <table border="`">
            <tr>
                <th>openid</th>
                <th>添加时间</th>
                <th>是否关注</th>
                <th>操作</th>
            </tr>

            @foreach($user as $val)
                <tr>
                    <td>{{$val->openid}}</td>
                    <td>{{$val->add_time}}</td>
                    <td>{{$val->subscribe}}</td>
                    <td><a href="{{url('wechat/user_details')}}?openid={{$val->openid}}">查看详情</a></td>
                </tr>
            @endforeach
        </table>
    </center>
</body>
</html>