@extends('index.layout.common')
@section('login')
    <div class="cart section">
        <div class="container">
            <div class="pages-head">
                <h3>CART</h3>
            </div>
            <div class="content">
                <div class="cart-1">
                    @foreach($goods as $g)
                    <div class="row">
                        <div class="col s5">
                            <h5>Image</h5>
                        </div>
                        <div class="col s7">
                            <img src="{{$g->goods_pic}}" alt="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s5">
                            <h5>Name</h5>
                        </div>
                        <div class="col s7">
                            <h5><a href="">{{$g->goods_name}}</a></h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s5">
                            <h5>Quantity</h5>
                        </div>
                        <div class="col s7">
                            <input value="{{$g->goods_num}}" type="text">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s5">
                            <h5>Price</h5>
                        </div>
                        <div class="col s7">
                            <h5>{{$g->goods_price}}</h5>
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
                </div>
                @endforeach
            <div class="total">
                @foreach($goods as $g)
                <div class="row">
                    <div class="col s7">
                        <h5>{{$g->goods_name}}</h5>
                    </div>
                    <div class="col s5">
                        <h5>{{$g->goods_price}}</h5>
                    </div>
                </div>
                @endforeach
                <div class="row">
                    <div class="col s7">
                        <h6>Total</h6>
                    </div>
                    <div class="col s5">
                        <h6>{{$sum}}</h6>
                    </div>
                </div>
            </div>
            <a class="btn button-default" href="{{url('index/order/confirmOrder')}}?gid={{$gid}}&sum={{$sum}}">结算</a>
        </div>
    </div>
    </div>
@endsection()