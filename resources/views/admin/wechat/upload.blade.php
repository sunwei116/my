@extends('admin.layout.common')
@section('goodsCreate')
    <center>
        <form action="{{url('wechat/do_upload')}}" method="post" enctype="multipart/form-data">
@csrf
           选择：<select name="up_type" id="">
                <option value="1">临时</option>
                <option value="2">永久</option>
            </select>
            <p>上传图片：<input type="file" name="image" id=""></p>
            <p>上传视频：<input type="file" name="video" id=""></p>
            <p>上传音频：<input type="file" name="voice" id=""></p>
            <p>上传缩略图：<input type="file" name="thumb" id=""></p>
            <input type="submit">
        </form>
    </center>
@endsection