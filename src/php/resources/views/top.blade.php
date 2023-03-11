@extends('layouts.app')

@section('title')
    商品一覧
@endsection

@section('content')
<!--/slider-->
@if($isRecommendItems)
<ul class="slider col-10">
    @foreach($isRecommendItems as $isRecommendItem)
    <li><img src="/storage/item-images/{{$isRecommendItem->image_file}}" alt="おすすめ画像"></li>
    @endforeach
</ul>
@endif
<!--/slider-->
<div class="container">
    <div class="row">
        @foreach ($items as $item)
            <div class="col-3 mb-3">
                <div class="card">
                    <div class="position-relative overflow-hidden esp-item-image">
                        <img class="card-img-top" src="/storage/item-images/{{$item->image_file}}" alt="商品画像">
                        <div class="position-absolute py-2 px-3" style="left: 0; bottom: 20px; color: white; background-color: rgba(0, 0, 0, 0.70)">
                            <i class="fas fa-yen-sign"></i>
                            <span class="ml-1">{{number_format($item->price)}}</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <small class="text-muted">{{$item->secondaryCategory->primaryCategory->name}} / {{$item->secondaryCategory->name}}</small>
                        <h5 class="card-title">{{$item->name}}</h5>
                    </div>
                    <a href="{{route ('item.showDetail',[$item->id])}}" class="stretched-link"></a>
                </div>
            </div>
        @endforeach
    </div>

        @if(count($items) == 0)
        <p>該当の商品はありません</p>
        @endif
        

    <div class="d-flex justify-content-center">
        {{$items->links()}}
    </div>
</div>
    @if(Auth::check())
        @if($user->admin_flag === 1)
        <a href="{{route('sell')}}"
        class="bg-secondary text-white d-inline-block d-flex justify-content-center align-items-center flex-column"
        role="button"
        style="position: fixed; bottom: 30px; right: 30px; width: 150px; height: 150px; border-radius: 75px;"
        >
        <div style="font-size: 24px;">出品</div>
        <div>
            <i class="fas fa-camera" style="font-size: 30px;"></i>
        </div>
        </a>
        @endif
    @endif
@endsection
