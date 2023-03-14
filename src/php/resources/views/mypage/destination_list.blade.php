@extends('layouts.app')

@section('title')
    お届け先一覧
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
                    お届け先一覧
                </div>

                <table class="table table-striped">
                    <thead>
                      <tr>
                        <th>お届け先名</th>
                        <th>郵便番号</th>
                        <th>住所</th>
                        <th>電話番号</th>
                        <th>編集</th>
                        <th>削除</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($deliverydestinations as $deliverydestination)
                            <div class="border col-100">
                                <tr>
                                    <td>{{$deliverydestination->delivery_destination_name}}</td>
                                    <td>{{$deliverydestination->zipcode}} </td>
                                    <td>{{$deliverydestination->address}} </td>
                                    <td>{{$deliverydestination->telephone}}</td>
                                    <td><a href="{{route ('mypage.edit-destination',[$deliverydestination->id])}}" class="btn btn-block btn-secondary">編集</a></td>
                                    <td>
                                        <form action="{{route ('mypage.destroy-destination',[$deliverydestination->id])}}" method="POST">
                                          @csrf
                                          <button type="submit" class="btn btn-block btn-secondary">削除</button>
                                        </form>
                                    </td>
                                </tr>
                            </div>
                        @endforeach
                    </tbody>
                </table>

                {{-- お届け先登録 --}}
                <div class="mt-1">
                    お届け先の登録は<a href="{{ route('mypage.register-destination') }}">こちら</a>
                </div>    
            </div>    
        </div>    
    </div>
@endsection
