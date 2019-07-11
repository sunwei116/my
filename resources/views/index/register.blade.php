@extends('index.layout.common')
<script src="/static/jquery.js"></script>
@section('register')
    <div class="pages section">
        <div class="container">
            <div class="pages-head">
                <h3>REGISTER</h3>
            </div>
            <div class="register">
                <div class="row">
                    <form class="col s12" action="{{url('index/doRegister')}}" method="post">
                        @csrf
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="input-field">
                            <input type="text" class="validate user" name="name" placeholder="NAME" required>
                        </div>
                        <div class="input-field">
                            <input type="email"  placeholder="EMAIL" name="email" class="validate email" required>
                        </div>
                        <div class="input-field">
                            <input type="password" placeholder="PASSWORD" name="password" class="validate pwd" required>
                        </div>
                        <button class="btn button-default">REGISTER</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection()
<script>
    /*$(function () {
        $('.btn').click(function () {
           var name = $('.user').val();
           var email = $('.email').val();
           var pwd = $('.pwd').val();
            if( name == '' || email == '' || pwd == ''){
                alert('请填写完整信息');return;
            }

        });
    })*/
</script>