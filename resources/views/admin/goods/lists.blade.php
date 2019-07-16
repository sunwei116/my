@extends('admin.layout.common');
@section('goodsList')
    <form action="{{url('/admin/goods/lists')}}">
        <input type="text" name="search" placeholder="请输入商品名称搜索" value="{{$ss}}">
        <input type="submit" value="搜索">
    </form>
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
        @foreach($goods as $v)
        <tr>
            <td>{{$v->goods_name}}</td>
            <td>{{$v->goods_price}}</td>
            <td><img src="{{$v->goods_pic}}" alt=""></td>
            <td><?php echo date('Y-m-d H:i:s',$v->add_time)?></td>
            <td><a href="{{url('admin/goods/delete')}}?id={{$v->id}}">删除</a> &ensp;
                <a href="{{url('admin/goods/edit')}}?id={{$v->id}}">修改</a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
    {{ $goods->appends(['ss'=> $ss])->links() }}
@endsection()

