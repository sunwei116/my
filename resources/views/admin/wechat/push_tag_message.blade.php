@extends('admin.layout.common')
@section('goodsCreate')
    <form action="{{url('wechat/do_push_tag_message')}}" method="post">
        @csrf
        消息类型：<select name="push_type" id="">
            <option value="1">文本消息</option>
            <option value="2">图文消息</option>
        </select>
        <br><br>
        <input type="hidden" name="openid" value="{{$openid}}">
        <input type="hidden" name="tag_id" value="{{$tag_id}}">
        <textarea name="message" id="" cols="30" rows="10"></textarea><p>
            素材id：<input type="text" name="media_id" value="">
            <br>
        <input type="submit">
    </form>
@endsection