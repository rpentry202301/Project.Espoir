@extends('layouts.app')

@section('title')
    購入確認画面
@endsection

@section('content')
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
                <br>
                {{-- カートの枠 --}}
                <table class="table mx-auto table-striped table-hover w-75 p-3 table-bordered">
                    <thead>
                        <tr>

                            <th colspan="2">商品名</th>
                            <th>数量</th>
                            <th>価格</th>

                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>コーヒー(S)</td>
                            <td>ここに追加されているトッピングがあれば表示させたい</td>
                            <td>1</td>
                            <td>100円</td>
                        </tr>
                        <tr>
                            <td>コーヒー(M)</td>
                            <td>ここに追加されているトッピングがあれば表示させたい</td>
                            <td>2</td>
                            <td>200円</td>
                        </tr>
                        <tr>
                            <td>コーヒー(L)</td>
                            <td>ここに追加されているトッピングがあれば表示させたい</td>
                            <td>1</td>
                            <td>300円</td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-right font-weight-bold">合計金額 : <span class="text-danger">1,000円(
                                    +税 )</span></td>
                        </tr>
                    </tbody>
                </table>

                {{-- @include('items.item_detail_panel', [
                    'item' => $item,
                ]) --}}

                {{-- Formの枠  --}}

                <div class="row">
                    <div class="col-8 offset-2">
                        <div class="card-form-alert alert alert-danger" role="alert" style="display: none"></div>
                        {{-- ここから下にformを作成していく --}}
                        <form action="">
                            {{-- delivery_destination_name --}}
                            <div class="form-group mx-auto">
                                <label for="input-delivery-destination">お届け先</label>
                                <input type="text" class="form-control" id="input-delivery-destination"
                                    aria-describedby="delivery-destination-help" placeholder="ここにお届け先の名前を入力してください">
                                <small id="delivery-destination-help"
                                    class="form-text text-muted">この位置にプルダウンで「登録住所から選択」を置きたい</small>
                            </div>
                            {{-- zipcode --}}
                            <div class="form-group mx-auto">
                                <label for="input-zipcode">郵便番号</label>
                                <input type="text" class="form-control col-3" maxlength="7" id="input-zipcode"
                                    oninput="value = value.replace(/[^0-9]+/i,'');" aria-describedby="zipcode-help"
                                    placeholder="9991234">
                                <small id="zipcode-help" class="form-text text-muted">半角数字で入力してください</small>
                            </div>

                            {{-- address --}}
                            <div class="form-group mx-auto">
                                <label for="input-address">住所</label>
                                <input type="text" class="form-control" id="input-address"
                                    aria-describedby="address-help" placeholder="ここに住所を入力してください">
                                <small id="address-help" class="form-text text-muted">郵便番号から補完してくれたらうれしい</small>
                            </div>

                            {{-- telephone --}}
                            <div class="form-group mx-auto">
                                <label for="input-telephone">電話番号</label>
                                <input type="text" class="form-control" id="input-telephone"
                                    oninput="value = value.replace(/[^0-9]+/i,'');" aria-describedby="telephone-help"
                                    placeholder="電話番号">
                                <small id="telephone-help" class="form-text text-muted">全角を自動的に半角にしてくれたらうれしい</small>
                            </div>

                            {{-- payment_method --}}
                            <div class="form-group mx-auto">
                                <label for="input-payment-method">支払方法</label>
                                <select name="" id="input-payment-method" class="form-control"
                                    aria-describedby="payment-method-help">
                                    <option>--</option>
                                    <option value="1">代金引換</option>
                                    <option value="2">クレジットカード</option>
                                </select>
                                <small id="payment-method-help"
                                    class="form-text text-muted">クレジットカードだったら下の入力フォームが出る仕様にしたい</small>
                            </div>

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
                        </form>
                    </div>
                </div>

                <div class="row mt-3 mb-3">
                    <div class="col-8 offset-2">
                        <button class="btn btn-secondary btn-block">購入</button>
                    </div>
                </div>

                {{-- <form id="buy-form" method="POST" action="{{ route('item.buy', [$item->id]) }}">
                    @csrf
                    <input type="hidden" id="card-token" name="card-token">
                </form> --}}
            </div>
        </div>
    </div>
@endsection
