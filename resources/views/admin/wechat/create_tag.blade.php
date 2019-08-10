@extends('admin.layout.common')
@section('goodsCreate')
<center>
    <form action="{{url('wechat/save_tag')}}" method="post">
        @csrf
       标签名： <input type="text" name="name" id=""><p>
        <input type="submit">
    </form>
</center>
@endsection