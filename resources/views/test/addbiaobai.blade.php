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
    <h1>微信表白</h1>
    <form action="{{url('dobiaobai')}}" method="post">
    <h2>请输入表白信息</h2>
    <textarea name="content" id="" cols="30" rows="10"></textarea>
        <input type="hidden" name="userOpenid" value="{{$user['openid']}}">
        <input type="hidden" name="userName" value="{{$user['nickname']}}">
        <p><input type="checkbox" name="status" value="2">是否匿名表白</p>
        <table>
            <tr>
                <td></td>
                <td></td>
                <td>用户昵称</td>
            </tr>
            @foreach($res as $v)
            <tr>
                <td><input type="radio" name="openid" id="" value="{{$v['openid']}}"></td>
                <td><img src="{{$v['headimgurl']}}" style="width:50px;height:50px;" alt=""></td>
                <td>{{$v['nickname']}}</td>
            </tr>
            @endforeach
        </table>
        <input type="submit" value="点击这里表白">
    </form>
</body>
</html>