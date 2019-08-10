<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="/static/layui/jquery-3.3.1.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>生成试卷</title>
</head>
<body>
    <center>
        <h3><input type="text" name="ming" id="ming" value="{{$ming}}" disabled="disabled"></h3>
        @foreach($ti as $k => $v)
            <p><input type="checkbox" name="test" id="tid" value="{{$v->id}}"> {{$v->title}}</p>
        @endforeach
        <input type="button" id="ss" value="生成">
        <span><a>访问</a></span>
    </center>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#ss').click(function () {
                var ming = $('#ming').val();
                obj = document.getElementsByName("test");
                check_val = new Array();
                for(k in obj){
                    if(obj[k].checked)
                        check_val.push(obj[k].value);
                }
                var ll = $(':checked').length;
                if (ll == 0){
                    alert('请选择题目');return;
                }
                $.post(
                   "{{url('exam/save')}}",
                    {id:check_val,ming:ming},
                    function (data) {
                        $('a').prop("href","{{url('exam/lists')}}"+'?id='+data);
                    },
                    'json'
                );


        });
    </script>

</body>
</html>