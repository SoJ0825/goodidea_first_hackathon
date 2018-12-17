@extends('layouts.app')

@section('content')
    <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
        <img src="/img/goodIdeaCoin.png" alt="" width="150" height="150">
        <p class="lead">好想工作室 - 遊戲儲值系統</p>
    </div>
    @for ($i = 0; $i < count($items); $i++)
        @if ($i % 3 == 0)
            <div class="container">
                <div class="card-deck mb-3 text-center">
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header">
                            <h4 class="my-0 font-weight-normal">{{ $items[$i] }}</h4>
                        </div>
                        <div class="card-body">
                            <img class="list-unstyled mt-3 mb-4" src="/img/{{ $items[$i] }}.png" alt="" width="130"
                                 height="130">
                            <h1 class="card-title pricing-card-title">${{$price[$i]}}
                                {{--<small class="text-muted"></small>--}}
                            </h1>
                            {{--<ul class="list-unstyled mt-3 mb-4">--}}
                            {{--<li>60 coins</li>--}}
                            {{--</ul>--}}
                            <a class="btn btn-lg btn-block btn-outline-primary" href="sentOrder"
                               onclick="event.preventDefault();
                               document.getElementById('sentOrder-form{{$i}}').submit();">
                                {{ __('Buy') }}
                            </a>
                            <form id="sentOrder-form{{$i}}" action="sentOrder" method="POST">
                                <input type="hidden" name="Name" value=" {{$items[$i]}} ">
                                <input type="hidden" name="Price" value=" {{$price[$i]}} ">
                                <input type="hidden" name="Currency" value="NT">
                                <input type="hidden" name="Quantity" value="1">
                                @csrf
                            </form>
                        </div>
                    </div>
                    @elseif ($i % 3 == 2)
                        <div class="card mb-4 shadow-sm">
                            <div class="card-header">
                                <h4 class="my-0 font-weight-normal">{{$items[$i]}}</h4>
                            </div>
                            <div class="card-body">
                                <img class="list-unstyled mt-3 mb-4" src="/img/{{$items[$i]}}.png" alt="" width="130"
                                     height="130">
                                <h1 class="card-title pricing-card-title"> ${{ $price[$i] }}
                                </h1>
                                <a class="btn btn-lg btn-block btn-outline-primary" href="sentOrder"
                                   onclick="event.preventDefault();
                               document.getElementById('sentOrder-form{{$i}}').submit();">
                                    {{ __('Buy') }}
                                </a>
                                <form id="sentOrder-form{{$i}}" action="sentOrder" method="post">
                                    <input type="hidden" name="Name" value=" {{$items[$i]}} ">
                                    <input type="hidden" name="Price" value=" {{$price[$i]}} ">
                                    <input type="hidden" name="Currency" value="NT">
                                    <input type="hidden" name="Quantity" value="1">
                                    @csrf
                                </form>
                            </div>
                        </div>
                </div>
            </div>
        @elseif($i % 3 == 1)
            <div class="card mb-4 shadow-sm">
                <div class="card-header">
                    <h4 class="my-0 font-weight-normal">{{$items[$i]}}</h4>
                </div>
                <div class="card-body">
                    <img class="list-unstyled mt-3 mb-4" src="/img/{{$items[$i]}}.png" alt="" width="130"
                         height="130">
                    <h1 class="card-title pricing-card-title"> ${{ $price[$i] }}
                    </h1>
                    <a class="btn btn-lg btn-block btn-outline-primary" href="sentOrder"
                       onclick="event.preventDefault();
                               document.getElementById('sentOrder-form{{$i}}').submit();">
                        {{ __('Buy') }}
                    </a>
                    <form id="sentOrder-form{{$i}}" action="sentOrder" method="POST">
                        <input type="hidden" name="Name" value=" {{$items[$i]}} ">
                        <input type="hidden" name="Price" value=" {{$price[$i]}} ">
                        <input type="hidden" name="Currency" value="NT">
                        <input type="hidden" name="Quantity" value="1">
                        @csrf
                    </form>
                </div>
            </div>
        @endif
    @endfor
@endsection()
