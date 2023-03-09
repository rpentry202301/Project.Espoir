@extends('layouts.app')

@section('title')
    購入確認画面
@endsection

@section('content')
    <script src="https://js.pay.jp/v2/pay.js"></script>
    <br>
    @if (session('status'))
        <div class="alert alert-success text-center col-2 mx-auto" role="alert">
            {{ session('status') }}
        </div>
    @endif
    @if (count($orderItemList) == 0)
        <h3 class="text-center py-2 text-danger">カートに商品が入っていません</h3>
    @endif
    </div>
    <div class="container">
        <div class="row">
            <div class="col-8 offset-2 bg-white">
                <div class="row mt-3">
                    <div class="col-8 offset-2">
                        @if (session('message'))
                            <div class="alert alert-{{ session('type', 'success') }}" role="alert">
                                {{ session('message') }}
                            </div>
                        @endif
                    </div>
                </div>

                <h2 class="text-center border-bottom border-top py-2">購入確認画面</h2>
                <form action="{{ route('buy.form') }}" method="POST" id="buy-form">
                    @csrf
                    <input type="hidden" id="card-token" name="card-token">
                    <br>
                    {{-- カートの枠 --}}
                    <table class="table mx-auto table-striped table-hover w-75 p-3 table-bordered">
                        <thead>
                            <tr>

                                <th colspan="2">商品名</th>
                                <th>価格</th>
                                <th>数量</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orderItemList as $itemKey => $orderItem)
                                <tr>
                                    <td>{{ $itemKey }} / {{ $orderItem->name }}<br>
                                        <input type="hidden" name="order_item_id" value="{{ $orderItem->id }}">
                                        <input type="hidden" name="item_id" value="{{ $orderItem->item_id }}">
                                        @foreach ($orderToppingList as $toppingKey => $orderTopping)
                                            @if ($orderTopping->order_item_id == $itemKey)
                                                <small
                                                    class="text-muted">{{ $orderTopping->name }}/{{ $orderTopping->price }}円</small><br>
                                                <input type="hidden" name="topping_id"
                                                    value="{{ $orderTopping->topping_id }}">
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>本当はここに追加されているトッピングがあれば表示させたい
                                    </td>
                                    <td>¥{{ $orderItem->customed_price }}/個
                                        <input type="hidden" name="customed_price"
                                            value="{{ $orderItem->customed_price }}">
                                    </td>
                                    <td><span>{{ $orderItem->quantity }}
                                            <input type="hidden" name="quantity" value="{{ $orderItem->quantity }}">
                                        </span></td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="5" class="text-right font-weight-bold">合計金額 : <span
                                        class="text-danger">¥{{ $priceIncludeTax }}</span>
                                </td>
                                <input type="hidden" name="price_include_tax" value="{{ $priceIncludeTax }}">
                            </tr>
                        </tbody>
                    </table>

                    {{-- Formの枠  --}}

                    <div class="row">
                        <div class="col-8 offset-2">
                            <div class="card-form-alert alert alert-danger" role="alert" style="display: none"></div>
                            {{-- delivery_destination_name --}}
                            <div class="form-group mx-auto">
                                <label for="input-delivery-destination">お届け先</label>
                                <input type="text" class="form-control" id="input-delivery-destination"
                                    name="delivery_destination_name" aria-describedby="delivery-destination-help"
                                    placeholder="ここにお届け先の名前を入力してください">
                                <small id="delivery-destination-help"
                                    class="form-text text-muted">この位置にプルダウンで「登録住所から選択」を置きたい</small>
                            </div>
                            {{-- zipcode --}}
                            <div class="form-group mx-auto">
                                <label for="input-zipcode">郵便番号</label>
                                <input type="text" class="form-control col-3" maxlength="7" name="zipcode"
                                    id="input-zipcode" oninput="value = value.replace(/[^0-9]+/i,'');"
                                    aria-describedby="zipcode-help" placeholder="9991234">
                                <small id="zipcode-help" class="form-text text-muted">半角数字で入力してください</small>
                            </div>

                            {{-- address --}}
                            <div class="form-group mx-auto">
                                <label for="input-address">住所</label><input type="text" class="form-control"
                                    id="input-address" name="address" aria-describedby="address-help"
                                    placeholder="ここに住所を入力してください">
                                <small id="address-help" class="form-text text-muted">郵便番号から補完してくれたらうれしい</small>
                            </div>

                            {{-- telephone --}}
                            <div class="form-group mx-auto">
                                <label for="input-telephone">電話番号</label>
                                <input type="text" class="form-control" maxlength="9" name="telephone"
                                    id="input-telephone" oninput="value = value.replace(/[^0-9]+/i,'');"
                                    aria-describedby="telephone-help" placeholder="電話番号">
                                <small id="telephone-help" class="form-text text-muted">全角を自動的に半角にしてくれたらうれしい</small>
                            </div>

                            {{-- payment_method --}}
                            <div class="form-group mx-auto">
                                <label for="input-payment-method">支払方法</label>
                                <select name="payment_method" id="input-payment-method" class="form-control"
                                    aria-describedby="payment-method-help">
                                    <option>--</option>
                                    <option value="1">代金引換</option>
                                    <option value="2">クレジットカード</option>
                                </select>
                                <small id="payment-method-help"
                                    class="form-text text-muted">クレジットカードだったら下の入力フォームが出る仕様にしたい</small>
                            </div>
                </form>

                <div class="form-group mt-3">
                    <label for="number-form">カード番号</label>
                    <div id="number-form" class="form-control">
                        <!-- ここにカード番号入力フォームが生成されます -->
                    </div>
                </div>
                <div class="form-group mt-3">
                    <label for="expiry-form">有効期限</label>
                    <div id="expiry-form" class="form-control">
                        <!-- ここに有効期限入力フォームが生成されます -->
                    </div>
                </div>
                <div class="form-group mt-3">
                    <label for="expiry-form">セキュリティコード</label>
                    <div id="cvc-form" class="form-control">
                        <!-- ここにCVC入力フォームが生成されます -->
                    </div>
                </div>

            </div>
        </div>

        <div class="row mt-3 mb-3">
            <div class="col-8 offset-2">
                <button class="btn btn-secondary btn-block" onclick="onSubmit(event)">購入</button>
            </div>
        </div>
    </div>
    </div>
    </div>
    <script>
        var payjp = Payjp('{{ config('payjp.public_key') }}')

        var elements = payjp.elements()

        var numberElement = elements.create('cardNumber')
        var expiryElement = elements.create('cardExpiry')
        var cvcElement = elements.create('cardCvc')
        numberElement.mount('#number-form')
        expiryElement.mount('#expiry-form')
        cvcElement.mount('#cvc-form')

        function onSubmit(event) {
            const msgDom = document.querySelector('.card-form-alert');
            msgDom.style.display = "none";

            payjp.createToken(numberElement).then(function(r) {
                if (r.error) {
                    msgDom.innerText = r.error.message;
                    msgDom.style.display = "block";
                    return;
                }

                document.querySelector('#card-token').value = r.id;
                document.querySelector('#buy-form').submit();
            })
        }
    </script>
@endsection
