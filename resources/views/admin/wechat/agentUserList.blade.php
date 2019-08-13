@extends('admin.layout.common')
@section('goodsCreate')
    <table border="1" align="center">
        <tr>
            <th>编号</th>
            <th>推广码</th>
            <th>专属二维码</th>
            <th>操作</th>
        </tr>
        @foreach($user as $val)
            <tr>
                <td>{{$val->id}}</td>
                <td>{{$val->id}}</td>
                <td><img src="{{$val->qrcode_url}}" alt="" width="100px" height="100px"></td>
                <td><a href="{{url('wechat/getTimeQrCode')}}?uid={{$val->id}}">生成二维码</a></td>
            </tr>
        @endforeach()

    </table>
@endsection