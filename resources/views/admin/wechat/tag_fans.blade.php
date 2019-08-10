@extends('admin.layout.common')
@section('goodsCreate')
<center>
    @foreach($openid as $val)
        <p>{{$val}}</p>
        @endforeach
</center>
@endsection