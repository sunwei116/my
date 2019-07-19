@extends('index.layout.common')
@section('index')
    @foreach($data as $k=>$v)
        <h3 style="color:red">
            订单号:{{$v->oid}} &nbsp;&nbsp;&nbsp;
            订单状态：@if($v->status == 1) &nbsp;&nbsp;&nbsp;
                     未支付 <a href="{{url('/pay')}}?oid={{$v->oid}}&sum={{$v->pay_money}}" class="btn button-default">前往支付</a>
                     @elseif($v->status == 2) &nbsp;&nbsp;&nbsp;
                        已支付
                     @elseif($v->status == 3) &nbsp;&nbsp;&nbsp;
                        已过期
                     @endif
        </h3>
        <h3>
            <table bgcolor="#6495ed">
                <tr>
                    <th>商品名称</th>
                    <th>商品图片</th>
                    <th>添加时间</th>
                </tr>
                    @foreach($v->detail as $val)
                    <tr>
                        <td>{{$val->goods_name}}</td>
                        <td><img src="{{$val->goods_pic}}" alt="" width="50" height="50"></td>
                        <td>{{$val->add_time}}</td>
                    </tr>
                        @endforeach
            </table>
        </h3>
    @endforeach
@endsection