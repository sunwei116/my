<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="/static/jquery.js"></script>
    <title>添加</title>
</head>
<body>
<input type="text" name="name">
<input type="text" name="age">
<input type="button" value="添加" class="button">

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('.button').on('click',function () {
        var name = $("[name='name']").val();
        var age = $("[name='age']").val();
        $.ajax({
           url:"http://www.wei678.top/api/member/create",
           data:{name:name,age:age},
           dataType:'json',
           method: 'GET',
           success:function (res) {
               if(res.code == 200){
                   alert(res.msg);
                   window.location.href='http://www.wei678.top/api/lists';
               }else{
                   alert(res.msg);
               }
           }
        });
    });
</script>
</body>
</html>