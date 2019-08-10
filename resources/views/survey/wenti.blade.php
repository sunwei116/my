<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>问题</title>
</head>
<body>
<form action="{{url('survey/save')}}" method="post">
    @csrf
    @if($data['type'] == 1)

<div align="center">
    <h3><input type="text" name="issue" value="{{$data['issue']}}" ></h3>
    <input type="hidden" name="sid" value="{{$data['sid']}}">
    <input type="hidden" name="type" value="{{$data['type']}}">
    <p><input type="radio" name="res" value="A"><input type="text" name="A" width="260"></p>
    <p><input type="radio" name="res" value="B"><input type="text" name="B" width="260"></p>
    <p><input type="radio" name="res" value="C"><input type="text" name="C" width="260"></p>
    <p><input type="radio" name="res" value="D"><input type="text" name="D" width="260"></p>
</div>
   @else
    <div align="center">
        <h3><input type="text" name="issue" value="{{$data['issue']}}" ></h3>
        <input type="hidden" name="sid" value="{{$data['sid']}}">
        <input type="hidden" name="type" value="{{$data['type']}}">
        <p><input type="checkbox" name="result[]" value="A"><input type="text" name="A" width="260"></p>
        <p><input type="checkbox" name="result[]" value="B" ><input type="text" name="B" width="260"></p>
        <p><input type="checkbox" name="result[]" value="C" ><input type="text" name="C" width="260"></p>
        <p><input type="checkbox" name="result[]" value="D"><input type="text" name="D" width="260"></p>
    </div>
        @endif
    <center>
        <input type="submit" value="添加"></center>
</form>
</body>
</html>