@extends('layouts.app')

@section('title')
    購入履歴
@endsection

@section('content')
    <br>
    <div class="container">
        <div class="row">
            <div class="col-8 mx-auto">
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
                @if ($user->admin_flag == 1)
                    @if (count($orders) != 0)
                        <div class="text-right">
                            <form action="/purchase-history/csv-export-order" method="POST" name="csvExport" id="csvExport">
                                @csrf
                                <select name="csvExportSelect" id="csvExportSelect" class="form-control col-2 float-right"
                                    onchange="changeCsvExport()">
                                    <option value="order">注文履歴</option>
                                    <option value="item">商品</option>
                                    <option value="topping">トッピング</option>
                                </select>
                                <button type="submit" class="btn btn-link">CSVダウンロード</button>
                            </form>
                        </div>
                    @endif
                @endif
                <script>
                    function changeCsvExport() {
                        let num = document.csvExport.csvExportSelect.selectedIndex;
                        let csvExportForm = document.getElementById("csvExport");
                        if (csvExportSelect.options[num].value == 'order') {
                            csvExportForm.setAttribute("action", "/purchase-history/csv-export-order");
                        } else if (csvExportSelect.options[num].value == 'item') {
                            csvExportForm.setAttribute("action", "/purchase-history/csv-export-item");
                        } else if (csvExportSelect.options[num].value == 'topping') {
                            csvExportForm.setAttribute("action", "/purchase-history/csv-export-topping");
                        }
                    }
                </script>
                <table class="table mx-auto w-100 p-3 table-bordered" style="font-size:5px;">
                    <thead>
                        <tr>
                            @if ($user->admin_flag == 1)
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
                                @if ($user->admin_flag == 1)
                                    <td>{{ $order->id }}</td>
                                @endif
                                <td>{{ $order->user_id }}</td>
                                <td>{{ $order->order_date }}</td>
                                <td colspan="2">
                                    {{-- <span class="table-responsive"> --}}
                                    <table class="table table-borderless table-sm w-100 p-3">
                                        <tbody>
                                            @foreach ($orderItems as $orderItem)
                                                @if ($user->admin_flag == 1)
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
                                                @elseif($user->admin_flag != 1)
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
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                    {{-- </span> --}}
                                </td>
                                <td>¥{{ number_format($order->price_include_tax) }}</td>
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
        <br>
        @if ($recommendItemCollection != null)
            <div class="mx-auto text-center">
                <h2>あなたへのおすすめ</h2>

                <div class="slider">
                    @foreach ($recommendItemCollection as $recommendItem)
                        <div class="">
                            <img src="/storage/item-images/{{ $recommendItem->image_file }}" alt="商品画像"
                                style="height: 250px;object-fit: cover;">
                        </div>
                    @endforeach
                </div>
        @endif
    </div>
@endsection
