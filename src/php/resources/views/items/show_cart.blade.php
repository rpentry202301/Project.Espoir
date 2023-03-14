@extends('layouts.app')

@section('title')
    カート一覧
@endsection

@section('content')
    <div class="col-3 offset-2 mx-auto">
        <br>
        @if (session('message'))
            <div class="alert alert-{{ session('type', 'success') }}" role="alert">
                {{ session('message') }}
            </div>
        @endif
        @if (session('status'))
            <div class="alert alert-success text-center" role="alert">
                {{ session('status') }}
            </div>
        @endif
    </div>

    <h2 class="text-center border-bottom border-top py-2">カート一覧</h2>
    <br>
    @if (count($orderItemList) == 0)
        <h3 class="text-center py-2 text-danger">カートに商品が入っていません</h3>
    @endif
    {{-- カートの枠 --}}
    <table class="table mx-auto table-hover col-11 table-bordered">
        <thead>
            <tr>
                <th>商品名</th>
                <th>トッピング</th>
                <th>価格</th>
                <th class="col-1">数量</th>
                <th class="col-1">操作</th>
            </tr>
        </thead>
        <tbody>

            <script>
                window.onload = function() {
                    calc_total();
                }

                function calc_total() {
                    console.log('onclickイベントの動作確認');
                    var totalPrice = 0;
                    var goukei = document.getElementById('goukei');
                    var formElements = document.forms; //ブラウザのすべてのフォームを取得(商品*2+2)
                    console.log(formElements);
                    console.log(formElements.length);
                    for (i = 2; i < formElements.length - 1; i++) { //商品フォームは2番目～.length-1番目となる
                        if (i % 2 == 0) {
                            console.log(i + '番目のセッション（フォーム）が呼ばれている');
                            var form_row = formElements[i]; //i+1番目のフォーム情報を取得
                            var item_price = Number(form_row.elements['itemPrice'].getAttribute('value')); //i+1番目の商品の値段を取得
                            console.log('商品価格は' + item_price);
                            var kingaku = 0;
                            var quantity = form_row.elements['quantity'].value;
                            for (j = 1; j <= 7; j++) {
                                console.log(form_row.elements['toppingPrice' + j]);
                                if (form_row.elements['toppingPrice' + j].checked) {
                                    var toppingPrice = Number(form_row.elements['toppingPrice' + j].value);
                                    console.log(form_row.elements['toppingPrice1' + j]);
                                    item_price += toppingPrice;
                                    console.log('if文の動作確認');
                                }
                            }
                            form_row.elements['customedPrice'].value = item_price;
                            totalPrice += item_price * quantity;
                            console.log('合計金額は' + totalPrice);
                            goukei.value = totalPrice;
                        }
                    }
                }
            </script>

            @foreach ($orderItemList as $index => $orderItem)
                <form action="{{ route('add.topping.cart') }}" method="post" id="item-update{{ $index }}"
                    name="orderForm">
                    @csrf
                    <input type="hidden" name="index" value="{{ $orderItem->id }}">
                    <input type="hidden" name="item_id" value="{{ $orderItem->item_id }}">
                    <tr>
                        <td>
                            {{ $orderItem->name }}
                        </td>
                        <td>
                            <table>
                                <tr>
                                    @foreach ($toppings as $topping)
                                        <td>
                                            <span class="small" style="font-size: 5px">{{ $topping->name }} /
                                                ¥{{ $topping->price }}
                                            </span>
                                            <input id="toppingPrice{{ $topping->id }}" type="checkbox"
                                                class="form-control small" name="toppingPrice{{ $topping->id }}"
                                                value="{{ $topping->price }}" aria-describedby="topping-help"
                                                style="transform: scale(0.5,0.5)" onclick="calc_total()"
                                                @foreach ($orderToppingList as $orderTopping)
                                                @if ($orderTopping->order_item_id == $orderItem->id && $orderTopping->topping_id == $topping->id)
                                                checked                                                    
                                                @endif @endforeach>
                                        </td>
                                    @endforeach
                                </tr>
                            </table>
                        </td>
                        <td><span id="itemPrice" value="{{ $orderItem->price }}"> ¥<input name="customedPrice"
                                    class="customedPrice col-5" value="{{ $orderItem->price }}" readonly>/個<input
                                    type="hidden" value="{{ $orderItem->price }}" name="itemPrice"></span></td>
                        <td>
                            <span class="form-group">
                                <select id="quantity" name="quantity{{ $index }}" class="form-control col-11"
                                    onchange="calc_total()">
                                    <option value="{{ $orderItem->quantity }}" selected="selected">
                                        {{ $orderItem->quantity }}</option>
                                    @for ($i = 1; $i <= 9; $i++)
                                        @if ($i == $orderItem->quantity)
                                            <?php continue; ?>
                                        @else
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endif
                                    @endfor
                                </select>
                            </span>
                        </td>
                </form>
                <td>
                    <button type="submit" class="btn btn-primary mb-2" form="item-update{{ $index }}">変更</button>
                    <form action="{{ route('delete.item.cart') }}" method="post" id="delete-item{{ $index }}">
                        @csrf
                        <button type="submit" class="btn btn-danger mb-2"
                            form="delete-item{{ $index }}">削除</button>
                        <input type="hidden" name="index" value="{{ $orderItem->id }}">
                    </form>
                </td>
                </tr>
            @endforeach
            <tr>
                <td colspan="5" class="text-right font-weight-bold">合計金額 : <input id="goukei" name="goukei"
                        class="text-danger col-1" value="" readonly>円
                </td>
            </tr>
        </tbody>
    </table>

    {{-- 購入確認画面に遷移するボタンの枠 --}}
    <a href="{{ route('buy.form') }}"
        class="bg-secondary text-white d-inline-block d-flex justify-content-center align-items-center flex-column"
        role="button"
        style="position: fixed; bottom: 30px; right: 30px; width: 150px; height: 150px; border-radius: 75px;">
        <div style="font-size: 20px;">購入確認画面へ</div>
        <div>
            <i class="fas fa-money-check-alt" style="font-size: 30px;"></i>
        </div>
    </a>
    <br>
    <br>
    <br>
@endsection
