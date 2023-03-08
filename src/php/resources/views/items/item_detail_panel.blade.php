<div class="font-weight-bold text-center pb-3 pt-3" style="font-size: 24px">{{$item->name}}</div>

<div class="row">
    <div class="col-4 offset-1">
        <img class="card-img-top" src="/storage/item-images/{{$item->image_file}}" alt="商品画像">
    </div>
    <div class="col-6">
        <table class="table table-bordered">
            <tr>
                <th>商品名</th>
                <td>
                    @if (!empty($item->seller->avatar_file_name))
                        <img src="/storage/avatars/{{$item->seller->avatar_file_name}}" class="rounded-circle" style="object-fit: cover; width: 35px; height: 35px;">
                    @else
                        <img src="/images/avatar-default.svg" class="rounded-circle" style="object-fit: cover; width: 35px; height: 35px;">
                    @endif
                    {{$item->name}}
                </td>
            </tr>
            <tr>
                <th>カテゴリー</th>
                <td>{{$item->secondaryCategory->primaryCategory->name}} / {{$item->secondaryCategory->name}}</td>
            </tr>
            <tr>
                <th>値段（税抜き）</th>
                <td><i class="fas fa-yen-sign"></i> {{number_format($item->price)}}</td>
            </tr>
        </table>
    </div>
</div>

