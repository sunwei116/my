@extends('admin.layout.common')
@section('goodsCreate')
<center>
    <table border="1">
        <tr>
            <th>id</th>
            <th>标签名</th>
            <th>粉丝数</th>
            <th>操作</th>
        </tr>
        @foreach($data as $val)
            <tr>
                <td>{{$val['id']}}</td>
                <td>{{$val['name']}}</td>
                <td>{{$val['count']}}</td>
                <td><a href="{{url('wechat/del_tag')}}?id={{$val['id']}}">删除</a> |
                <a href="{{url('wechat/user_list')}}?id={{$val['id']}}">用户打标签</a> |
                <a href="{{url('wechat/tag_fans')}}?id={{$val['id']}}">粉丝列表</a> |
                <a href="{{url('wechat/edit_tag')}}?id={{$val['id']}}&name={{$val['name']}}">修改标签</a> |
                <a href="{{url('wechat/push_tag_message')}}?id={{$val['id']}}&name={{$val['name']}}">推送消息</a> |
                </td>
            </tr>
        @endforeach
    </table>
</center>
@endsection