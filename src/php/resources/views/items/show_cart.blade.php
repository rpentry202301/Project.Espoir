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
            @foreach ($orderItemList as $itemKey => $orderItem)
                <tr>
                    <td>{{ $itemKey }} / {{ $orderItem->name }}<br>
                        @foreach ($orderToppingList as $toppingKey => $orderTopping)
                            @if ($orderTopping->order_item_id == $itemKey)
                                <small class="text-muted">{{ $orderTopping->name }}/{{ $orderTopping->price }}円</small><br>
                            @endif
                        @endforeach
                    </td>
                    <td>
                        <table>
                            <tr>
                                <td colspan="{{ count($toppings) }}"><span class="form-group form-check-inline">
                                        <label for="select-topping" style="font-size: 8px">トッピング</label>
                                </td>
                            </tr>
                            <tr>
                                <form action="{{ route('add.topping.cart') }}" method="POST" id="item-update">
                                    @csrf
                                    <input type="hidden" name="index" value="{{ $itemKey }}">
                                    @foreach ($toppings as $topping)
                                        <td>
                                            <span class="small" style="font-size: 5px">{{ $topping->name }} /
                                                ¥{{ $topping->price }}</span>
                                            <input type="checkbox" class="form-control small" name="topping[]"
                                                value="{{ $topping->id }}" aria-describedby="topping-help"
                                                style="transform: scale(0.5,0.5)">
                                        </td>
                                    @endforeach
                            </tr>
                            <tr>
                                <td colspan="{{ count($toppings) }}"><small id="topping-help" class="form-text text-muted"
                                        style="font-size: 8px">ポップアップで表示したい</small></td>
                            </tr>
                        </table>


                    </td>
                    <td>¥{{ $orderItem->customed_price }}/個</td>
                    <td>{{ $orderItem->quantity }}<span class="form-group">
                            {{-- <form action="{{ route('add.topping.cart') }}" method="POST" id="item-update"> --}}
                            @csrf
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
                            </form>
                        </span></td>
                    <td>
                        <button type="submit" class="btn btn-primary mb-2" form="item-update">更新</button>
                        <form action="{{ route('delete.item.cart') }}" method="post">
                            @csrf
                            <button type="submit" class="btn btn-danger mb-2">削除</button>
                            <input type="hidden" name="index" value="{{ $itemKey }}">
                        </form>
                    </td>
                </tr>
            @endforeach
            <tr>
                <td colspan="5" class="text-right font-weight-bold">合計金額 : <span
                        class="text-danger">¥{{ $priceIncludeTax }}</span>
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
        <input type="submit" value="カートに入れる">
    </form>
@endsection
