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

                <div class="row">
                    <div class="col-8 offset-2">
                        <form action="{{ route('add.item.cart') }}" method="post" class="btn btn-secondary btn-block">
                            @csrf
                            <input type="hidden" value="{{ $item->id }}" name="id">
                            <input type="submit" value="カートに入れる">
                        </form>
                    </div>
                </div>

                <div class="my-3 text-center">{!! nl2br(e($item->description)) !!}</div>
            </div>
        </div>
    </div>

    <a href="{{ route('show.item.cart') }}"
        class="bg-secondary text-white d-inline-block d-flex justify-content-center align-items-center flex-column"
        role="button"
        style="position: fixed; bottom: 30px; right: 30px; width: 150px; height: 150px; border-radius: 75px;">
        <div style="font-size: 24px;">カートへ</div>
        <div>
            <i class="fas fa-camera" style="font-size: 30px;"></i>
        </div>
    </a>
@endsection
