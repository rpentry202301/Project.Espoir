@extends('layouts.app')

@section('title')
    {{ $item->name }} | 商品詳細
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

                @include('items.item_detail_panel', [
                    'item' => $item,
                    ])
                    
                <div class="my-3 text-center">{!! nl2br(e($item->description)) !!}</div>
                <div class="row">
                    <div class="col-8 offset-2">
                        <form action="{{ route('add.item.cart') }}" method="post" class="btn btn-secondary btn-block">
                            @csrf
                            <input type="hidden" value="{{ $item->id }}" name="id">
                            <input type="submit" value="カートに入れる">
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    @if(Auth::check())
        @if($user->admin_flag === 1)
        <a href="{{route('item.showEditForm',$item)}}"
        class="bg-secondary text-white d-inline-block d-flex justify-content-center align-items-center flex-column"
        role="button"
        style="position: fixed; bottom: 30px; right: 200px; width: 150px; height: 150px; border-radius: 75px;"
        >
        <div style="font-size: 24px;">編集</div>
        <div>
            <i class="fas fa-edit" style="font-size: 30px;"></i>
        </div>
        </a>
        @endif
    @endif

    <a href="{{ route('show.item.cart') }}"
        class="bg-secondary text-white d-inline-block d-flex justify-content-center align-items-center flex-column"
        role="button"
        style="position: fixed; bottom: 30px; right: 30px; width: 150px; height: 150px; border-radius: 75px;">
        <div style="font-size: 24px;">カート一覧へ</div>
        <div>
            <i class="fas fa-shopping-cart" style="font-size: 30px;"></i>
        </div>
    </a>
@endsection
