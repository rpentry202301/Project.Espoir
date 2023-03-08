@extends('layouts.app')

@section('title')
    プロフィール編集
@endsection

@section('content')
    <div id="profile-edit-form" class="container">
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

                <div class="font-weight-bold text-center border-bottom pb-3 pt-3" style="font-size: 24px">プロフィール編集</div>

                <form method="POST" action="{{ route('mypage.edit-profile') }}" class="p-5" enctype="multipart/form-data">
                    @csrf

                    {{-- ユーザ名 --}}
                    <div class="form-group mt-3">
                        <label for="name">ユーザー名</label>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" required autocomplete="name" autofocus>
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    {{-- メールアドレス --}}
                    <div class="form-group mt-3">
                        <label for="email">メールアドレス</label>
                        <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" required autocomplete="email" autofocus>
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    
                    {{-- お届け先 --}}
                    <div class="form-group mt-3">
                        <label for="delivery_destination_name">お届け先</label>
                        <input id="delivery_destination_name" type="text" class="form-control @error('delivery_destination_name') is-invalid @enderror" name="delivery_destination_name"  required autocomplete="delivery_destination_name" autofocus>
                        @error('delivery_destination_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    {{-- 郵便番号 --}}
                    <div class="form-group mt-3">
                        <label for="zipcode">郵便番号</label>
                        <input id="zipcode" type="text" class="form-control @error('zipcode') is-invalid @enderror" name="zipcode" required autocomplete="zipcode" autofocus>
                        @error('zipcode')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    {{-- 住所 --}}
                    <div class="form-group mt-3">
                        <label for="address">住所</label>
                        <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" required autocomplete="address" autofocus>
                        @error('address')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    
                    {{-- 電話番号 --}}
                    <div class="form-group mt-3">
                        <label for="telephone">電話番号</label>
                        <input id="telephone" type="text" class="form-control @error('telephone') is-invalid @enderror" name="telephone"  required autocomplete="telephone" autofocus>
                        @error('telephone')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>                    

                    <div class="form-group mb-0 mt-3">
                        <button type="submit" class="btn btn-block btn-secondary">
                            保存
                        </button>
                    </div>
                    <div class="mt-1">
                        パスワードを変更の方は<a href="{{ route('password.request') }}">こちら</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
