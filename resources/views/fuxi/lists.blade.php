<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="/static/jquery.js"></script>
    <title>列表</title>
</head>
<body>
    <table border="`">
        <tr>
            <th>姓名</th>
            <th>年龄</th>
        </tr>
       <tbody id="lists">

       </tbody>
    </table>
</body>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url:"http://www.wei678.top/api/member/lists",
        dataType:'json',
        success:function (res){
            console.log(res);
            // var tr = $("<tr></tr>");
            // tr.parent("<td>res.name</td>");
            // tr.parent("<td>res.age</td>");
            // $('#lists').append(tr);
        },
    })
</script>
</html>