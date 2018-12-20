@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">儲值清單(餘額：{{ $coin }})</div>

                    @if ( count($orders) > 0)
                        <div class="card-body">
                            <table width="100%" border="1">
                                <tr>
                                    <td align="center">時間</td>
                                    <td align="center">消費金額</td>
                                    <td align="center">購買商品</td>
                                </tr>
                                @foreach($orders as $order)
                                    <tr>
                                        <td align="center">{{$order->created_at}}</td>
                                        <td align="center">{{$order->PayAmt}}</td>
                                        <td align="center">{{$order->Merchandise}}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                        @else
                        <div class="card-body">

                            <font size="20"> Hi, {{ Auth::user()->name }} <br> </font>
                                你還沒儲值過<br>
                                歡迎儲值， 買越多賺越多喔!<br>

                        </div>
                        @endif
                </div>
            </div>
        </div>
    </div>
@endsection
