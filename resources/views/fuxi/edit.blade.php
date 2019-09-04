<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="/static/jquery.js"></script>
    <title>修改</title>
</head>
<body>
<input type="text" name="name">
<input type="text" name="age">
<input type="hidden" name="id">
<input type="button" value="修改" class="button">

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url:"http://www.wei678.top/api/member/find",
        data:{id:getQueryVariable('id')},
        dataType:'json',
        method: 'GET',
        success:function (res){
            $("[name='name']").val(res.name);
            $("[name='age']").val(res.age);
            $("[name='hidden']").val(res.id);
        }
    });
    function getQueryVariable(id)
    {
        var query = window.location.search.substring(1);
        var vars = query.split("&");
        for (var i=0;i<vars.length;i++) {
            var pair = vars[i].split("=");
            if(pair[0] == id){return pair[1];}
        }
        return(false);
    }
    $('.button').on('click',function () {
        var name = $("[name='name']").val();
        var age = $("[name='age']").val();
        var id = $("[name='hidden']").val();
        $.ajax({
            url:"http://www.wei678.top/api/member/save",
            data:{name:name,age:age,id:id},
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