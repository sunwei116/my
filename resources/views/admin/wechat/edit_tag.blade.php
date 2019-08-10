@extends('admin.layout.common')
@section('goodsCreate')
    <center>
        <form action="{{url('wechat/update_tag')}}" method="post">
        <h1>修改标签</h1>
            <input type="hidden" name="id" value="{{$data['id']}}">
            @csrf
       <h3>【{{$data['name']}}】 :修改为：<input type="text" name="name"></h3>
            <input type="submit" value="修改">
        </form>
    </center>
@endsection