@extends('admin.layout.common')
@section('goodsCreate')
    <center>
        <table>
            <tr>
                <th>地址</th>
                <th>操作</th>
            </tr>
            @foreach($data as $v)
             @foreach($v as $val)
                    <tr>
                        <td>{{$val->url}}</td>
                        <td><a href="{{url('')}}">删除</a></td>
                    </tr>
             @endforeach
            @endforeach
        </table>
    </center>
@endsection