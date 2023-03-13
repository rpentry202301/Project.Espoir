@extends('layouts.app')

@section('title')
    商品一覧
@endsection

@section('content')

<!--/slider-->
@if($isRecommendItems)
<h2>～{{\Carbon\Carbon::now()->format('n')}}月のおすすめ～</h2>
<ul class="slider col-8">
    @foreach($isRecommendItems as $isRecommendItem)
    <li><a href="#" data-toggle="modal" data-target="#my-modal" 
    data-price="{{number_format($isRecommendItem->price)}}" 
    data-name="{{$isRecommendItem->name}}" 
    data-primaryCategoryName = "{{$isRecommendItem->secondaryCategory->primaryCategory->name}}" 
    data-secondaryCategoryName = " {{$isRecommendItem->secondaryCategory->name}}">
    <img src="/storage/item-images/{{$isRecommendItem->image_file}}" alt="おすすめ画像"></a></li>
    @endforeach
</ul>
@endif
<!--/slider-->

<div class="modal fade" id="my-modal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">title（商品名）</h4>
            </div>
            <div class="modal-body">
                <label>データを削除しますか？</label>
                <table class="table table-bordered">
                    <tr>
                        <th class="w-25">テキストテキストテキスト</th>
                    </tr>
                    <tr>
                        <th class="w-25">カテゴリー</th>
                    </tr>
                    <tr>
                        <th class="w-25">値段(税抜)</th>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">閉じる</button>
            </div>
        </div>
    </div>
</div>

<script>
    window.onload = function() {
        $('#my-modal').on('shown.bs.modal', function (event) {
            console.log('動作確認');
            //Ajaxの処理はここに
            //modal-bodyのpタグにtextメソッド内を表示
            modal.find('.modal-body p').eq(0).text("本当に"+title+"を削除しますか?");
            //formタグのaction属性にurlのデータ渡す
            modal.find('form').attr('action',url);
        });
    }
</script>


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
<br>


@if(Auth::check())
    <div class="mt-5">
        <h3>取得したスタンプ</h3>
        <!--/slider-->
        @if($IPContents && Auth::check())
        <ul class="slider-stamp col-7">
            @foreach($IPContents as $IPContent)
            <li><img src="/storage/item-images/{{$IPContent->image_file}}" class="rounded-circle border border-1" alt="IPスタンプ"></li>
            @endforeach
        </ul>
        @endif
        <!--/slider-->
    </div>
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
