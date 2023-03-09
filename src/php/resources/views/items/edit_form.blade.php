@extends('layouts.app')

@section('title')
    商品情報編集
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-8 offset-2">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
            </div>
        </div>

        <div class="row">
            <div class="col-8 offset-2 bg-white">

                <div class="font-weight-bold text-center border-bottom pb-3 pt-3" style="font-size: 24px">商品情報を編集する</div>

                <form method="POST" action="{{ route('sell.updateSellInformation')}}" class="p-5" enctype="multipart/form-data">
                    @csrf
    
                    <input id="itemId" type="hidden" class="form-control" name="itemId" value="{{ $item->id }}">

                    {{-- 商品画像 --}}
                    <div>商品画像</div>
                    <span class="item-image-form image-picker">
                        <input type="file" name="item-image" class="d-none" accept="image/png,image/jpeg,image/gif" id="image_file" />
                        <label for="image_file" class="d-inline-block" role="button">
                            <img src="{{ asset('images/item-image-default.png') }}" style="object-fit: cover; width: 300px; height: 300px;">
                        </label>
                    </span>
                    @error('item-image')
                        <div style="color: #E4342E;" role="alert">
                            <strong>{{ $message }}</strong>
                        </div>
                    @enderror

                    {{-- 商品名 --}}
                    <div class="form-group mt-3">
                        <label for="name">商品名</label>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $item->name }}" required autocomplete="name" autofocus>
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    {{-- 商品の説明 --}}
                    <div class="form-group mt-3">
                        <label for="description">商品の説明</label>
                        <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" required autocomplete="description" autofocus>{{ $item->description }}</textarea>
                        @error('description')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    {{-- カテゴリ --}}
                    <div class="form-group mt-3">
                        <label for="category">カテゴリ</label>
                        <select name="category" class="custom-select form-control @error('category') is-invalid @enderror">
                            @foreach($categories as $category)
                                <optgroup label="{{$category->name}}">
                                    @foreach($category->secondaryCategories as $secondary)
                                        <option value="{{$secondary->id}}" {{$item->secondary_category_id == $secondary->id ? 'selected' : ''}}>{{$secondary->name}}</option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                        @error('category')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    {{-- 販売価格 --}}
                    <div class="form-group mt-3">
                        <label for="price">販売価格（税抜き）</label>
                        <input id="price" type="number" class="form-control @error('price') is-invalid @enderror" name="price" value="{{ $item->price }}" required autocomplete="price" autofocus>
                        @error('price')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    {{-- おすすめのON/OFF --}}
                    <div class="form-check">
                        <input class="form-check-input" type="radio" id="flexRadioDefault1" name="is_recommend" value="true" {{ $item->is_recommend == '1' ? 'checked' : '' }}>
                        <label class="form-check-label" for="flexRadioDefault1">
                            おすすめ
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" id="flexRadioDefault2" name="is_recommend" value="false" {{ $item->is_recommend == '0' ? 'checked' : '' }}>
                        <label class="form-check-label" for="flexRadioDefault2">
                            そんなことはない
                        </label>
                    </div>

                    <!-- <div class="custom-control custom-switch text-center">
                        <input type="checkbox" class="custom-control-input" id="customSwitch1" name="is_recommend" value="1"  {{ $item->is_recommend == '1' ? 'checked' : '' }}>
                        <label class="custom-control-label" for="customSwitch1">おすすめ！</label>
                    </div> -->

                    <div class="form-group mb-0 mt-3">
                        <button type="submit" class="btn btn-block btn-secondary">
                            更新する
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @if(Auth::check() && $user->admin_flag === 1)
        @if($item->is_selling == 1)
            <a href="{{route('item.stopSelling',$item)}}"
            class="bg-secondary text-white d-inline-block d-flex justify-content-center align-items-center flex-column"
            role="button"
            style="position: fixed; bottom: 30px; right: 30px; width: 150px; height: 150px; border-radius: 75px;"
            >
            <div style="font-size: 24px;">販売停止</div>
            <div>
                <i class="fas fa-hand-paper" style="font-size: 30px;"></i>
            </div>
            </a>
            @elseif($item->is_selling == 0)
            <a href="{{route('item.restartSelling',$item)}}"
            class="bg-secondary text-white d-inline-block d-flex justify-content-center align-items-center flex-column"
            role="button"
            style="position: fixed; bottom: 30px; right: 30px; width: 150px; height: 150px; border-radius: 75px;"
            >
            <div style="font-size: 24px;">販売再開</div>
            <div>
                <i class="fas fa-check" style="font-size: 30px;"></i>
            </div>
            </a>
        @endif
    @endif
@endsection
