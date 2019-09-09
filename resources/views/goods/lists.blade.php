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
    <nav aria-label="Page navigation">
        <ul class="pagination">
        </ul>
    </nav>
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
                var page = '';
                for (var i=1;i<=res.data.last_page;i++){
                    if (i == res.data.current_page) {
                        page += "<li class='active'><a href='javascript:;' page='"+i+"'>第"+i+"页</a></li>";
                    }else{
                       page += "<li class='active'><a href='javascript:;' page='"+i+"'>第"+i+"页</a></li>"
                    }
                }
                $('.pagination').html(page);
            },
        });
        $(document).on('click','.pagination a',function () {
            var page = $(this).attr('page');
            $.ajax({
                url:"http://www.wei678.top/api/goods/lists",
                data:{page:page},
                type:'POST',
                dataType: 'json',
                success:function (res) {
                    $('#tbody').empty();
                    $.each(res.data.data,function (i,v) {
                        var tr = $("<tr></tr>");
                        tr.append("<td>"+v.goods_name+"</td>");
                        tr.append("<td>"+v.goods_price+"</td>");
                        $('#tbody').append(tr);
                    });
                    for (var i=1;i<=res.data.last_page;i++){
                        if (i == res.data.current_page) {
                            page += "<li class='active'><a href='javascript:;' page='+i+'>第"+i+"页</a></li>";
                        }else{
                            page += "<li class='active'><a href='javascript:;' page='+i+'>第"+i+"页</a></li>"
                        }
                    }
                    $('.pagination').html(page);
                }
            })
        });
    </script>
@endsection
