@extends('layouts.app')

@section('title')
お届け先編集
@endsection

@section('content')
<script src="https://ajaxzip3.github.io/ajaxzip3.js"></script>

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

            {{-- タイトル --}}
            <div class="font-weight-bold text-center border-bottom pb-3 pt-3" style="font-size: 24px">
                お届け先を編集する
            </div>

            <form method="POST"
                action="{{ route('mypage.edit-destination', ['deliverydestination' => $deliverydestination->id,]) }}"
                class="p-5" enctype="multipart/form-data">
                @csrf

                <input id="id" type="hidden" class="form-control" name="id" value="{{ $deliverydestination->id }}">

                <div id="editForm">

                    {{-- お届け先名 --}}
                    <div class="form-group mt-3">
                        <label for="delivery_destination_name">
                            お届け先名
                        </label>
                        <input id="delivery_destination_name" type="text"
                            class="form-control @error('delivery_destination_name') is-invalid @enderror"
                            name="delivery_destination_name" required autocomplete="delivery_destination_name" autofocus
                            value="{{ $deliverydestination->delivery_destination_name }}">
                        @error('delivery_destination_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>
                                {{ $message }}
                            </strong>
                        </span>
                        @enderror
                    </div>

                    {{-- 郵便番号 --}}
                    <div class="form-group mt-3">
                        <label for="zipcode">
                            郵便番号
                        </label>
                        <input id="zipcode" type="text" class="form-control @error('zipcode') is-invalid @enderror"
                            name="zipcode" required autocomplete="zipcode" autofocus
                            value="{{ $deliverydestination->zipcode }}"
                            onKeyUp="AjaxZip3.zip2addr(this,'','addr11','addr11');">
                        @error('zipcode')
                        <span class="invalid-feedback" role="alert">
                            <strong>
                                {{ $message }}
                            </strong>
                        </span>
                        @enderror
                    </div>

                    {{-- 住所 --}}
                    <div class="form-group mt-3">
                        <label for="address">
                            住所
                        </label>
                        <input id="address" type="text" class="form-control @error('address') is-invalid @enderror"
                            name="addr11" required autocomplete="address" autofocus
                            value="{{ $deliverydestination->address }}">
                        @error('address')
                        <span class="invalid-feedback" role="alert">
                            <strong>
                                {{ $message }}
                            </strong>
                        </span>
                        @enderror
                    </div>

                    {{-- 電話番号 --}}
                    <div class="form-group mt-3">
                        <label for="telephone">
                            電話番号
                        </label>
                        <input id="telephone" type="text" class="form-control @error('telephone') is-invalid @enderror"
                            name="telephone" required autocomplete="telephone" autofocus
                            value="{{ $deliverydestination->telephone }}">
                        @error('telephone')
                        <span class="invalid-feedback" role="alert">
                            <strong>
                                {{ $message }}
                            </strong>
                        </span>
                        @enderror
                    </div>
                </div>

                {{-- 編集する --}}
                <div class="form-group mb-0 mt-3">
                    <button type="submit" class="btn btn-block btn-secondary">
                        編集する
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection