@extends('layouts.admin')
@section('content')
    <div class="form-group">
        <label for="exampleInputEmail1">商品名称</label>
        <input type="text" class="form-control" name="name">
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">商品价格</label>
        <input type="text" class="form-control" name="peice">
    </div>
    <input type="button" value="添加" class="button">

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('.button').on('click',function () {
           var goods_name = $("[name='name']").val();
           var goods_price = $("[name='price']").val();
           $.ajax({
               url:'http://www.wei678.top/goods/add',
               data:{goods_name:goods_name,goods_price:goods_price},
               type:'POST',
               dataType:'json',
               success:function (res) {
                    alert(res);
               }
           });
        });
        // $('.button').on('click',function () {
        //     var name = $("[name='name']").val();
        //     var age = $("[name='age']").val();
        //     var url = "http://w3.wei678.top/api/member";
        //     $.ajax({
        //         url:url,
        //         data:{name:name,age:age},
        //         dataType:'json',
        //         method: 'POST',
        //         success:function (res) {
        //             if(res.code == 200){
        //                 alert(res.msg);
        //                 window.location.href='http://w3.wei678.top/member/lists';
        //             }else{
        //                 alert(res.msg);
        //             }
        //         }
        //     });
        // });
    </script>
@endsection
