@extends('admin.layout.common')
@section('goodsCreate')
    <form action="{{url('wechat/menuSave')}}">
        @csrf
        <center>
    菜单名称：<input type="text" name="m_name">
    级别选择：<select name="pid">
                <option value="0">一级菜单</option>
            @foreach($res as $val)
                    <option value="{{$val->id}}">{{$val->m_name}}</option>
                @endforeach
            </select><p>
      菜单标识(或URL)：<input type="text" name="select" style="width: 300px"><p>
      类型选择：  <select name="m_type">
                    <option value="click">click</option>
                    <option value="view">view</option>
                </select><p>
                <input type="submit">
        </center>
    </form>
@endsection()