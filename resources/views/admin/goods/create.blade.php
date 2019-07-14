@extends('admin.layout.common')
@section('goodsCreate')
<form class="layui-form">
    @csrf
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
@endif
    <!-- 提示：如果你不想用form，你可以换成div等任何一个普通元素 -->
    <div class="layui-form-item">
        <label class="layui-form-label">商品名称</label>
        <div class="layui-input-block">
            <input type="text" name="goods_name" placeholder="请输入商品名称" autocomplete="off" class="layui-input">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">商品价格</label>
        <div class="layui-input-block">
            <input type="text" name="goods_price" placeholder="请输入商品价格" autocomplete="off" class="layui-input">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">商品图片</label>
        <input type="hidden" name="goods_pic" id="img" value="">
        <button type="button" class="layui-btn" id="test1">
            <i class="layui-icon">&#xe67c;</i>上传图片
        </button>
        <div id="preview"></div>
    </div>

    <div class="layui-form-item">
        <div class="layui-input-block">
            <button class="layui-btn" lay-submit lay-filter="*">立即提交</button>
            <button type="reset" class="layui-btn layui-btn-primary">重置</button>
        </div>
    </div>
    <!-- 更多表单结构排版请移步文档左侧【页面元素-表单】一项阅览 -->
</form>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    layui.use(['form','upload'], function(){
        var form = layui.form, upload = layui.upload;


            upload.render({
                elem: '#test1',
                url: "{{url('admin/goods/upload')}}",
                choose:function(obj){
                    obj.preview(function(index, file, result){
                         $('#preview').append('<img src="'+result+'" alt="" width="100" heigth="100">');
                    })
                },
                done:function (res) {
                    if (res) {
                        layer.msg(res.msg,{icon:5,time:2000},function () {
                            if(res){
                                $('#img').val(res.path);
                            }
                        })
                    }
                }
            });
            form.on('submit(*)',function (data) {
                $.post(
                  "{{url('admin/goods/save')}}",
                    data.field,
                    function(data){
                        layer.msg(data.msg,{icon:data.icon,time:2000},function () {
                            if (data.code == 1) {
                                window.location.href="{{url('admin/goods/lists')}}";
                            }
                        }) ;
                    },
                    'json'
                );
                return false;
            });
        //各种基于事件的操作，下面会有进一步介绍
    });
</script>

    @endsection()