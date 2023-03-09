<div class="font-weight-bold text-center pb-3 pt-3" style="font-size: 24px">{{$item->name}}</div>

<div class="row">
    <div class="col-4 offset-1">
        <img class="card-img-top" src="/storage/item-images/{{$item->image_file}}" alt="商品画像">
    </div>
    <div class="col-7">
        <table class="table table-bordered">
            <tr>
                <th class="w-25">商品名</th>
                <td class="w-75">{{$item->name}}</td>
            </tr>
            <tr>
                <th class="w-25">カテゴリー</th>
                <td class="w-75">{{$item->secondaryCategory->primaryCategory->name}} / {{$item->secondaryCategory->name}}</td>
            </tr>
            <tr>
                <th class="w-25">値段(税抜)</th>
                <td class="w-75"><i class="fas fa-yen-sign"></i> {{number_format($item->price)}}</td>
            </tr>
        </table>
    </div>
</div>

