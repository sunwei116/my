@extends('admin.layout.common')
@section('goodsCreate')
    <center>

        <table border="`">
            <tr>
                <th>模板id</th>
                <th>标题</th>
                <th>内容</th>
                <th>操作</th>
            </tr>
            @foreach($data as $v)
                @foreach($v as $val)
                    <tr>
                        <td>{{$val['template_id']}}</td>
                        <td>{{$val['title']}}</td>
                        <td>{{$val['content']}}</td>
                        <td>
                            <a href="{{url('wechat/del_template')}}?id={{$val['template_id']}}">删除</a>
                            <a href="{{url('wechat/send_template')}}?id={{$val['template_id']}}">发送消息</a>
                        </td>
                    </tr>
                @endforeach
            @endforeach
        </table>

    </center>
@endsection