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

                {{-- タイトル --}}
                <div class="font-weight-bold text-center border-bottom pb-3 pt-3" style="font-size: 24px">
                    プロフィール編集
                </div>

                <form method="POST" action="{{ route('mypage.edit-profile') }}" class="p-5" enctype="multipart/form-data">
                    @csrf

                    {{-- ユーザー名 --}}
                    <div class="form-group mt-3">
                        <label for="name">
                            ユーザー名
                        </label>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" required autocomplete="name" value="{{$user->name}}" autofocus>
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                        @enderror
                    </div>

                    {{-- メールアドレス --}}
                    <div class="form-group mt-3">
                        <label for="email">
                            メールアドレス
                        </label>
                        <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" required autocomplete="email" value="{{$user->email}}" autofocus>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                        @enderror
                    </div>                    

                    {{-- 保存 --}}
                    <div class="form-group mb-0 mt-3">
                        <button type="submit" class="btn btn-block btn-secondary">
                            保存
                        </button>
                    </div>

                    {{-- 配送先一覧 --}}
                    <div class="mt-1">
                        配送先一覧は<a href="{{ route('mypage.destination-list') }}">こちら</a>
                    </div>

                    {{-- パスワード変更 --}}
                    <div class="mt-1">
                        パスワードの変更は<a href="{{ route('password.request') }}">こちら</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
