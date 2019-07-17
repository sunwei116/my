@extends('/index/layout/common')
@section('login')
    <div class="wishlist section">
        <div class="container">
            <div class="pages-head">
                <h3>确认订单</h3>
            </div>
            <div class="content">
                <div class="cart-1">
                    @foreach($data as $v)
                    <div class="row">
                        <div class="col s5">
                            <h5>Image</h5>
                        </div>
                        <div class="col s7">
                            <img src="{{$v->goods_pic}}" alt="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s5">
                            <h5>Name</h5>
                        </div>
                        <div class="col s7">
                            <h5><a href="">{{$v->goods_name}}</a></h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s5">
                            <h5>Action</h5>
                        </div>
                        <div class="col s7">
                            <h5><i class="fa fa-trash"></i></h5>
                        </div>
                    </div>
                        @endforeach
                        <div class="row">
                            <div class="col s5">
                                <h5>总价</h5>
                            </div>
                            <div class="col s7">
                                <h5>{{$price}}</h5>
                            </div>
                        </div>
                        <a href="{{url('pay')}}?oid={{$oid}}&price={{$price}}">结算</a>
                </div>
            </div>
@endsection()