@extends('layouts.app')

@section('title')
    カート一覧
@endsection

@section('content')
    @foreach ($orderItemList as $orderItems)
        @foreach ($orderItems as $orderItem)
            {{ $orderItem->name }}
        @endforeach
    @endforeach
    <form action="{{ route('add.item.cart') }}" method="post">
        @csrf
        <input type="submit" value="送信">
    </form>
@endsection
