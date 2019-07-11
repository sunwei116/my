@extends('index.layout.common')
@section('login')
    <div class="pages section">
        <div class="container">
            <div class="pages-head">
                <h3>LOGIN</h3>
            </div>
            <div class="login">
                <div class="row">
                    <form class="col s12" action="{{url('index/doLogin')}}" method="post">
                        @csrf
                        <div class="input-field">
                            <input type="text" class="validate" name="name" placeholder="USERNAME" required>
                        </div>
                        <div class="input-field">
                            <input type="password" class="validate" name="password" placeholder="PASSWORD" required>
                        </div>
                        <a href=""><h6>Forgot Password ?</h6></a>
                        <button class="btn button-default">LOGIN</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection()