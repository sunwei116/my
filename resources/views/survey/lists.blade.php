<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="/static/layui/jquery-3.3.1.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>列表</title>
</head>
<body>
@foreach($data as $v)
<p>{{$v->survey}} <button value="{{$v->id}}" class="qi">启用</button> <button value="{{$v->id}}" class="del">删除</button>
    @endforeach
{{ $data->links() }}
    <center>
        <a>访问</a>
    </center>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('.del').click(function () {
           var id = $(this).val();
           $.post(
               "{{url('survey/delete')}}",
               {id:id},
               function (data) {

               },
            'json'
           );
        });
        $('.qi').click(function () {
            var id = $(this).val();
            $('a').prop('href',"{{url('survey/check')}}"+'?id='+id);
        });
    </script>
</body>
</html>