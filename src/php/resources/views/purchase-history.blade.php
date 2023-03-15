@extends('layouts.app')

@section('title')
    購入履歴
@endsection

@section('content')
    <br>
    <div class="container">
        <div class="row">
            <div class="col-8 mx-auto">
                <form action="#" class="" method="POST">
                    <input type="text" class="form-control" placeholder="検索ワードとか期間で表示される履歴を変更">
                    <br>
                    <button class="btn btn-primary offset-5">検索</button>
                    <br>
                    @if (count($orders) == 0)
                        <br>
                        <h3 class="text-center py-2 text-danger">購入履歴が存在しません</h3>
                    @endif
                    <br>
                </form>
            </div>
            <br>
            <br>
            <br>
            <div class="col-12 bg-white">
                購入履歴一覧
                <br>
                @if (Auth::id() == 1)
                    @if (count($orders) != 0)
                        <div class="text-right">
                            <form action="{{ route('cvs-export') }}" method="POST">
                                @csrf
                                <button class="btn btn-link">CSVダウンロード</button>
                            </form>
                        </div>
                    @endif
                @endif
                <table class="table mx-auto w-100 p-3 table-bordered" style="font-size:5px;">
                    <thead>
                        <tr>
                            @if (Auth::id() == 1)
                                <th>オーダーID</th>
                            @endif
                            <th>購入者</th>
                            <th>購入日</th>
                            <th colspan="2">商品</th>
                            <th>購入金額</th>
                            <th colspan="2">配送先</th>
                            <th>支払い方法</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                @if (Auth::id() == 1)
                                    <td>{{ $order->id }}</td>
                                @endif
                                <td>{{ $order->user_id }}</td>
                                <td>{{ $order->order_date }}</td>
                                <td colspan="2">
                                    {{-- <span class="table-responsive"> --}}
                                    <table class="table table-borderless table-sm w-100 p-3">
                                        <tbody>
                                            @foreach ($orderItems as $orderItem)
                                                @if ($orderItem->order_id == $order->id)
                                                    <tr>
                                                        <td class="col-1"> <a
                                                                href="{{ route('item.showDetail', [$orderItem->item_id]) }}"
                                                                class="text-primary">{{ $orderItem->name }}</a>
                                                            ×{{ $orderItem->quantity }}</td>
                                                        <td class="col-1">
                                                            @foreach ($orderToppings as $orderTopping)
                                                                @if ($orderTopping->order_item_id == $orderItem->id)
                                                                    <div> <small
                                                                            class="text-black-50">{{ $orderTopping->name }}</small>
                                                                    </div>
                                                                @endif
                                                            @endforeach
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                    {{-- </span> --}}
                                </td>
                                <td>¥{{ $order->price_include_tax }}</td>
                                <td colspan="2">
                                    <div>{{ $order->delivery_destination_name }}</div>
                                    <div>〒{{ $order->zipcode }}</div>
                                    <div> {{ $order->address }}</div>
                                    <div>{{ $order->telephone }}</div>
                                </td>
                                <td>{{ $order->payment_method }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <br>
    </div>
@endsection
