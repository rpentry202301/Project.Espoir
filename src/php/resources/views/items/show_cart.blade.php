@extends('layouts.app')

@section('title')
    カート一覧
@endsection

@section('content')
    {{-- 何番目の注文商品なのかを知りたい（for） --}}
    @for ($i = 0; $i < count($orderItemList); $i++)
        {{-- OrderItemの反復処理⑴ --}}
        @for ($j = 0; $j < count($orderItemList[$i]); $j++)
            {{-- OrderItemの反復処理⑵ --}}
            {{ $orderItemList[$i][$j]->name }}<br>
            {{ 'オーダー商品の添え字：' . $i }}<br>
            {{-- OrderToppingの反復処理⑴ --}}
            @for ($k = 0; $k < count($orderToppingList); $k++)
                {{-- OrderToppingの反復処理⑵ --}}
                @for ($l = 0; $l < count($orderToppingList[$k]); $l++)
                    @if ($orderToppingList[$k]->order_item_id == $i)
                        {{ 'オーダー商品に紐づくオーダートッピングのorder_item_id：' . $orderToppingList[$k]->order_item_id }}
                        <span>{{ $orderToppingList[$k][$l]->name }}/{{ $orderToppingList[$k][$l]->price }}円</span><br>
                    @endif
                @endfor
            @endfor
            <form action="{{ route('add.topping.cart') }}" method="POST">
                @csrf
                <select name="topping[]" id="" multiple>
                    @foreach ($toppings as $topping)
                        <option value="{{ $topping->id }}">{{ $topping->name }} / {{ $topping->price }}円</option>
                    @endforeach
                </select>
                <input type="hidden" name="index" value="{{ $i }}">
                <input type="submit" value="トッピングを追加">
            </form>
            <form action="{{ route('delete.item.cart') }}" method="post">
                @csrf
                <input type="submit" value="削除">
                <input type="hidden" name="index" value="{{ $i }}">
            </form>
        @endfor
    @endfor

    <br>
    <hr>
    <br>

    <form action="{{ route('add.item.cart') }}" method="post">
        @csrf
        <input type="submit" value="カートに入れる">
    </form>

    {{-- 以下は仮 --}}
    <div class="container">
        <div class="row">
            @foreach ($orderItemList as $orderItems)
                @foreach ($orderItems as $orderItem)
                    <div class="col-3 mb-3">
                        <div class="card">
                            <div class="position-relative overflow-hidden">
                                <img class="card-img-top" src="/storage/item-images/{{ $orderItem->image_file_name }}"
                                    alt="商品画像">
                                <div class="position-absolute py-2 px-3"
                                    style="left: 0; bottom: 20px; color: white; background-color: rgba(0, 0, 0, 0.70)">
                                    <i class="fas fa-yen-sign"></i>
                                    <span class="ml-1">{{ number_format($orderItem->price) }}</span>
                                </div>
                                <!-- <div class="position-absolute py-1 font-weight-bold d-flex justify-content-center align-items-end" style="left: 0; top: 0; color: white; background-color: #EA352C; transform: translate(-50%,-50%) rotate(-45deg); width: 125px; height: 125px; font-size: 20px;">
                                                                                                                                                                                                                                                        <span>SOLD</span>
                                                                                                                                                                                                                                                    </div> -->
                            </div>
                            <div class="card-body">
                                <small class="text-muted">PrimaryCategory / SecondaryCategory</small>
                                <h5 class="card-title">ItemName</h5>
                            </div>
                            {{-- <a href="{{ route('item.showDetail', [$orderItem->id]) }}" class="stretched-link"></a> --}}
                        </div>
                    </div>
                @endforeach
            @endforeach
        </div>
    </div>
@endsection
