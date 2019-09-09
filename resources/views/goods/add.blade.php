@extends('layouts.admin')
@section('content')
    <div class="form-group">
        <label for="exampleInputEmail1">商品名称</label>
        <input type="text" class="form-control" name="name">
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">商品价格</label>
        <input type="text" class="form-control" name="price">
    </div>
    <input type="button" value="添加" class="button">

    <script>

        $('.button').on('click',function () {
           var goods_name = $("[name='name']").val();
           var goods_price = $("[name='price']").val();
           $.ajax({
               url:'http://www.wei678.top/api/goods/add',
               data:{goods_name:goods_name,goods_price:goods_price},
               type:'POST',
               dataType:'json',
               success:function (res) {
                    alert(res);
               }
           });
        });

    </script>
@endsection
