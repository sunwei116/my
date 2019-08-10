@extends('admin.layout.common')
@section('goodsCreate')
    <center>
        <h3><a href="{{url('wechat/upload_source')}}?type=image">获取图片素材</a></h3>
        <h3><a href="{{url('wechat/upload_source')}}?type=video">获取视频素材</a></h3>
        <h3><a href="{{url('wechat/upload_source')}}?type=voice">获取音频素材</a></h3>
        <table border="`">
            <tr>
                <th>类型</th>
                <th>素材id</th>
                <th>添加时间</th>
                <th>详情</th>
            </tr>
            @foreach($data as $v)
                <tr>
                    <td>@if($v->up_type == 1)临时@elseif($v->up_type ==2)永久@endif</td>
                    <td>{{$v->media_id}}</td>
                    <td>{{$v->add_time}}</td>
                    <td>@if($v->type == 'image' || $v->type == 'thumb')
                            <a href="{{url('wechat/get_source')}}?id={{$v->media_id}}">查看</a>
                         @elseif($v->type == 'video')
                            <a href="{{url('wechat/get_video_source')}}?id={{$v->media_id}}">查看</a>
                        @elseif($v->type == 'voice')
                            <a href="{{url('wechat/get_voice_source')}}?id={{$v->media_id}}">查看</a>
                        @endif
                    </td>
                </tr>
            @endforeach
        </table>
    </center>
@endsection