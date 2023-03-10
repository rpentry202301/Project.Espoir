@extends('layouts.app')

@section('title')
    購入履歴
@endsection

@section('content')
    <br>
    <div class="container">
        <div class="row">
            <div class="col-8 mx-auto">
                <form action="#" class="" method="POST">
                    <input type="text" class="form-control" placeholder="検索ワードとか期間で表示される履歴を変更">
                    <button class="btn btn-primary offset-5">検索</button>
                </form>
            </div>
            <br>
            <br>
            <br>
            <br>
            <div class="col-12 bg-white">
                購入履歴一覧（仮）
                <br>
                <br>
                <div class="text-right">
                    <form action="#" class="" method="POST">
                        <button class="btn btn-link">CSVダウンロード</button>
                    </form>
                </div>
                <table class="table mx-auto table-striped table-hover w-100 p-3 table-bordered">
                    <thead>
                        <tr>
                            <th>購入者</th>
                            <th>購入日</th>
                            <th colspan="2">商品</th>
                            <th>購入金額</th>
                            <th colspan="2">配送先</th>
                            <th>支払い方法</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>テスト太郎</td>
                            <td>2023年3月10日</td>
                            <td colspan="2">この中にテーブルで商品一覧を表示する</td>
                            <td>¥200</td>
                            <td colspan="2">この中にテーブルで配送先情報を表示する</td>
                            <td>クレジットカード</td>
                        </tr>
                        <tr>
                            <td>サンプル</td>
                            <td>2023年3月11日</td>
                            <td colspan="2">この中にテーブルで商品一覧を表示する</td>
                            <td>¥300</td>
                            <td colspan="2">この中にテーブルで配送先情報を表示する</td>
                            <td>代金引換</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
