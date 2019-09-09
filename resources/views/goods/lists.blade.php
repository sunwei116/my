@extends('layouts.admin')
@section('content')
    <table class="table table-bordered table-hover">
        <tr>
            <td>商品名称</td>
            <td>商品价格</td>
        </tr>
        <tbody id="tbody">

        </tbody>
    </table>
    <script>
        $.ajax({
            url:"http://www.wei678.top/api/goods/lists",
            dataType:'json',
            type:'POST',
            success:function (res) {
                $.each(res.data.data,function (i,v) {
                    var tr = $("<tr></tr>");
                    tr.append("<td>"+v.goods_name+"</td>");
                    tr.append("<td>"+v.goods_price+"</td>");
                    $('#tbody').append(tr);
                });
                for (var i=1;i<=res.data.last_page;i++){

                }
            },
        });
    </script>
@endsection
