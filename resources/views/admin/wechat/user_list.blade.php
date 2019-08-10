@extends('admin.layout.common')
@section('goodsCreate')
    <form action="{{url('wechat/add_user_tag')}}">
        @csrf
    <center>
        <h3><a href="{{url('wechat/get_user_list')}}">刷新</a></h3>
        <table border="`">
            <tr>
                <th>选择</th>
                <th>openid</th>
                <th>添加时间</th>
                <th>是否关注</th>
                <th>操作</th>
            </tr>
            <input type="hidden" name="tag_id" value="{{$tag_id}}">
            @foreach($user as $val)
                <tr>
                    <td><input type="checkbox" name="id_list[]" value="{{$val->id}}"></td>
                    <td>{{$val->openid}}</td>
                    <td>{{$val->add_time}}</td>
                    <td>{{$val->subscribe}}</td>
                    <td>
                        <a href="{{url('wechat/user_details')}}?openid={{$val->openid}}">查看详情</a>
                        <a href="{{url('wechat/get_user_tag')}}?openid={{$val->openid}}">获取标签</a>
                    </td>
                </tr>
            @endforeach
        </table>
        <input type="submit" value="添加标签">
    </center>
    </form>
@endsection