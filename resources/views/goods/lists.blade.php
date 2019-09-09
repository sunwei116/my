@extends('layouts.admin')
@section('content')
    <table class="table table-bordered table-hover">
        <tr>
            <td>商品名称</td>
            <td>商品价格</td>
        </tr>
    </table>
    <script>
        $.ajax({
            url:"http://www.wei678.top/api/goods/lists",
            dataType:'json',
            type:'POST',
            success:function (res) {
                alert(res.msg);
            },
        });
    </script>
@endsection
