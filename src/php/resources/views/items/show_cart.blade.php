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
    <table class="table mx-auto table-striped table-hover w-75 p-3 table-bordered">
        <thead>
            <tr>
                <th colspan="2">商品名</th>
                <th>価格</th>
                <th>数量</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>

        <script>
            window.onload = function(){
                calc_total();
            }
        function calc_total(){
            console.log('onclickイベントの動作確認');
            var totalPrice =0;
            var goukei = document.getElementById('goukei');
            var formElements = document.forms;//ブラウザのすべてのフォームを取得（6こ）
            for(i=0; i<formElements.length-3; i++){//商品フォーム以外の3つのフォームを除外
                console.log(i+'番目のセッション（フォーム）が呼ばれている');
                var form_row = formElements[i+1];//i+1番目のフォーム情報を取得
                var item_price = Number(form_row.elements['itemPrice'].getAttribute('value'));//i+1番目の商品の値段を取得
                var kingaku = 0;
                var radioNodeList = Number(form_row.elements['toppingPrice']);
                for(j=1; j<form_row.length-1; j++){
                    var toppingPrice = Number(form_row.elements[j].value);
                    if(form_row.elements[j].checked){
                        item_price +=toppingPrice;
                    }
                }
                form_row.elements['customedPrice'].value = item_price;
                totalPrice += item_price;
                goukei.value = totalPrice;
            }
        }
        </script>
        
            @foreach ($orderItemList as $index => $orderItem)
                <form action="{{ route('delete.item.cart') }}" method="POST" id="item-update" name="orderForm">
                    @csrf
                    <tr>
                        <td>
                            {{ $index }} / {{ $orderItem->name }}
                        </td>
                        <td>
                            <table>
                                <tr>
                                    <td colspan="{{ count($toppings) }}"><span class="form-group form-check-inline">
                                            <label for="select-topping" style="font-size: 8px">トッピング</label>
                                    </td>
                                </tr>
                                <tr>
                                    <!-- <input type="hidden" name="index" value="{{ $index }}"> -->
                                    @foreach ($toppings as $topping)
                                        <td>
                                            <span class="small" style="font-size: 5px">{{ $topping->name }} /
                                                ¥{{ $topping->price }}</span>
                                            <input id="toppingPrice" type="checkbox" class="form-control small" name="toppingPrice"
                                                value="{{ $topping->price }}" aria-describedby="topping-help"
                                                style="transform: scale(0.5,0.5)" onclick="calc_total()">
                                        </td>
                                    @endforeach
                                </tr>
                            </table>
                        </td>
                        <td><span id="itemPrice" value="{{ $orderItem->price }}"> ¥<input name="customedPrice" class="customedPrice w-50" value="{{ $orderItem->price }}" readonly>/個<input type="hidden" value="{{$orderItem->price}}" name="itemPrice"></span></td>
                        <td>
                            <span class="form-group">
                                <select id="quantity" name="quantity" class="form-control col-8">
                                    <option value="">--</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                </select>
                            </span>
                        </td>
                        <td>
                            <!-- <button type="button" class="btn btn-primary mb-2">更新</button> -->
                            <button type="submit" class="btn btn-danger mb-2">削除</button>
                        </td>
                    </tr>
                </form>
            @endforeach
            <tr>
                <td colspan="5" class="text-right font-weight-bold">合計金額 : <input id="goukei" name="goukei" class="text-danger" value="" readonly>円
                </td>
            </tr>
        </tbody>
    </table>

    {{-- 購入確認画面に遷移するボタンの枠 --}}
    <a href="{{ route('buy.form') }}"
        class="bg-secondary text-white d-inline-block d-flex justify-content-center align-items-center flex-column"
        role="button"
        style="position: fixed; bottom: 30px; right: 30px; width: 150px; height: 150px; border-radius: 75px;">
        <div style="font-size: 24px;">購入確認画面へ</div>
        <div>
            <i class="fas fa-camera" style="font-size: 30px;"></i>
        </div>
    </a>
    <br>
    <br>
    <br>
    <hr>
    <br>
    <form action="{{ route('add.item.cart') }}" method="post">
        @csrf
        <input type="hidden" value="1" name="id">
        <input type="submit" value="カートに入れる（1）">
    </form>
    <form action="{{ route('add.item.cart') }}" method="post">
        @csrf
        <input type="hidden" value="2" name="id">
        <input type="submit" value="カートに入れる（2）">
    </form>
@endsection
