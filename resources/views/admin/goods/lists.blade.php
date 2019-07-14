@extends('admin.layout.common');
@section('goodsList')
    <table class="layui-table">
        <colgroup>
            <col width="150">
            <col width="200">
            <col>
        </colgroup>
        <thead>
        <tr>
            <th>商品名称</th>
            <th>商品价格</th>
            <th>商品图片</th>
            <th>添加时间</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach($goods as $goods)
        <tr>
            <td>{{$goods->goods_name}}</td>
            <td>{{$goods->goods_price}}</td>
            <td>{{$goods->goods_pic}}</td>
            <td>{{$goods->add_time}}</td>
            <td><a href="{{url('admin/goods/delete')}}?id={{$goods->id}}">删除</a> &ensp;
                <a href="{{url('admin/goods/edit')}}?id={{$goods->id}}">修改</a></td>
        </tr>
        @endforeach()
        </tbody>
    </table>
    {{ $goods->links() }}
@endsection()
