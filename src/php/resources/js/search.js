$(function () {
    $('.user-search-form .search-icon').on('click', function () {
        alert('クリック動作確認');
        // $('.user-table tbody').empty(); //もともとある要素を空にする
        // $('.search-null').remove(); //検索結果が0のときのテキストを消す

        let userName = $('#search_name').val(); //検索ワードを取得

        if (!userName) {
            return false;
        } //ガード節で検索ワードが空の時、ここで処理を止めて何もビューに出さない

        // $.ajax({
        //     type: 'GET',
        //     url: '/user/index/' + userName, //後述するweb.phpのURLと同じ形にする
        //     data: {
        //         'search_name': userName, //ここはサーバーに贈りたい情報。今回は検索ファームのバリューを送りたい。
        //     },
        //     dataType: 'json', //json形式で受け取る

        //     beforeSend: function () {
        //         $('.loading').removeClass('display-none');
        //     } //通信中の処理をここで記載。今回はぐるぐるさせるためにcssでスタイルを消す。
        //  }).done(function (data) {
        //  //以下は後述
        //  }
});
