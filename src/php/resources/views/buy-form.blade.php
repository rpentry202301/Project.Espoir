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
                <div>
                    @if (count($errors) > 0)
                        @foreach ($errors->all() as $error)
                            <div class="alert  alert-danger text-center col-8 mx-auto text-danger" role="alert">
                                {{ $error }}
                            </div>
                        @endforeach
                        <br>
                    @endif
                </div>

                <h2 class="text-center border-bottom border-top py-2">購入確認画面</h2>
                <form action="{{ route('buy.form') }}" method="POST" id="buy-form">
                    @csrf
                    <input type="hidden" id="card-token" name="card-token">
                    <br>
                    {{-- カートの枠 --}}
                    <table class="table mx-auto table-striped table-hover col-11 table-bordered">
                        <thead>
                            <tr>
                                <th>商品名</th>
                                <th>トッピング</th>
                                <th>価格</th>
                                <th>数量</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orderItemList as $itemKey => $orderItem)
                                <tr>
                                    <td>{{ $orderItem->name }}<br>
                                        <input type="hidden" name="onetime_id[]" value="{{ $orderItem->id }}">
                                        <input type="hidden" name="item_id[]" value="{{ $orderItem->item_id }}">
                                    </td>
                                    <td>
                                        @foreach ($orderToppingList as $toppingKey => $orderTopping)
                                            @if ($orderItem->id == $orderTopping->order_item_id)
                                                <small class="text-black-50">{{ $orderTopping->name }}</small><br>
                                                <input type="hidden" name="topping_id[]"
                                                    value="{{ $orderTopping->topping_id }}">
                                                <input type="hidden" name="order_item_id[]"
                                                    value="{{ $orderTopping->order_item_id }}">
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>¥{{ number_format($orderItem->customed_price) }}/個
                                        <input type="hidden" name="customed_price[]"
                                            value="{{ $orderItem->customed_price }}">
                                    </td>
                                    <td><span>{{ $orderItem->quantity }}
                                            <input type="hidden" name="quantity[]" value="{{ $orderItem->quantity }}">
                                        </span></td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="5" class="text-right font-weight-bold">
                                    @if ($tax != 0)
                                        <div>消費税：¥{{ number_format($tax) }}</div>
                                    @endif
                                    <div>合計金額 : <span class="text-danger">¥{{ number_format($priceIncludeTax) }}</span>
                                    </div>
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
                                <div class="">
                                    @foreach ($deliveryDestinations as $deliveryDestination)
                                        <div class="w-100">
                                            <input id="place{{ $deliveryDestination->id }}" type="radio" name="place"
                                                value="{{ $deliveryDestination->id }}"
                                                {{ old('place') ? 'checked' : '' }}><label
                                                for="place{{ $deliveryDestination->id }}">{{ $deliveryDestination->delivery_destination_name }}
                                                | 〒{{ $deliveryDestination->zipcode }} {{ $deliveryDestination->address }}
                                                | {{ $deliveryDestination->telephone }}</label>
                                            <hr>
                                        </div>
                                    @endforeach
                                </div>
                                {{-- お届け先登録 --}}
                                <p>
                                    お届け先の登録は<a href="{{ route('mypage.register-destination') }}"
                                        class="text-primary">こちら</a>
                                </p>
                            </div>
                            <div class="form-group mx-auto">
                                <label>支払方法</label>
                                <div>
                                    <span> <input type="radio" name="payment_method" id="input-payment-method-1"
                                            class="" value="1" onclick="buttonClick()"><label
                                            for="input-payment-method-1">代金引換</label></span>
                                    <span> </span>
                                    <span><input type="radio" name="payment_method" id="input-payment-method-2"
                                            class="" value="2" onclick="buttonClick()"><label
                                            for="input-payment-method-2">クレジットカード</label></span>
                                </div>
                            </div>
                </form>
                <span id="sub-form" style="display: none">

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
                </span>

            </div>
        </div>

        <div class="row mt-3 mb-3">
            <div class="col-8 offset-2">
                <button id="buy-button" class="btn btn-secondary btn-block" form="buy-form">購入</button>
            </div>
        </div>
        <br>
    </div>
    </div>
    <br>
    <br>
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

    <script>
        function buttonClick() {
            let btnHide = document.getElementById("input-payment-method-1");
            let btnOpen = document.getElementById("input-payment-method-2");
            let subForm = document.getElementById("sub-form");
            let buyButton = document.getElementById("buy-button");
            if (btnHide.checked) {
                subForm.style.display = "none";
                buyButton.setAttribute('onclick', "");
                buyButton.setAttribute('form', 'buy-form');
            } else {
                subForm.style.display = "";
                buyButton.setAttribute('onclick', "onSubmit(event)");
                buyButton.setAttribute('form', '');
            }
        }
    </script>
@endsection
