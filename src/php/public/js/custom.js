$(".slider").slick({
    autoplay: true, //自動的に動き出すか。初期値はfalse。
    infinite: true, //スライドをループさせるかどうか。初期値はtrue。
    slidesToShow: 2, //スライドを画面に3枚見せる
    slidesToScroll: 2, //1回のスクロールで3枚の写真を移動して見せる
    prevArrow: '<div class="slick-prev"></div>', //矢印部分PreviewのHTMLを変更
    nextArrow: '<div class="slick-next"></div>', //矢印部分NextのHTMLを変更
    dots: true, //下部ドットナビゲーションの表示
    responsive: [
        {
            breakpoint: 769, //モニターの横幅が769px以下の見せ方
            settings: {
                slidesToShow: 2, //スライドを画面に2枚見せる
                slidesToScroll: 2, //1回のスクロールで2枚の写真を移動して見せる
            },
        },
        {
            breakpoint: 426, //モニターの横幅が426px以下の見せ方
            settings: {
                slidesToShow: 1, //スライドを画面に1枚見せる
                slidesToScroll: 1, //1回のスクロールで1枚の写真を移動して見せる
            },
        },
    ],
});

// スタンプのスライダー設定
$(".slider-stamp").slick({
    autoplay: true, //自動的に動き出すか。初期値はfalse。
    infinite: true, //スライドをループさせるかどうか。初期値はtrue。
    slidesToShow: 3, //スライドを画面に3枚見せる
    slidesToScroll: 1, //1回のスクロールで3枚の写真を移動して見せる
    prevArrow: '<div class="slick-prev"></div>', //矢印部分PreviewのHTMLを変更
    nextArrow: '<div class="slick-next"></div>', //矢印部分NextのHTMLを変更
    dots: true, //下部ドットナビゲーションの表示
    responsive: [
        {
            breakpoint: 769, //モニターの横幅が769px以下の見せ方
            settings: {
                slidesToShow: 2, //スライドを画面に2枚見せる
                slidesToScroll: 2, //1回のスクロールで2枚の写真を移動して見せる
            },
        },
        {
            breakpoint: 426, //モニターの横幅が426px以下の見せ方
            settings: {
                slidesToShow: 1, //スライドを画面に1枚見せる
                slidesToScroll: 1, //1回のスクロールで1枚の写真を移動して見せる
            },
        },
    ],
});

// レコメンド商品のモーダル
var recommendImgs = document.querySelectorAll(".recommend-img");
var myModalLabel = document.getElementById("myModalLabel");

recommendImgs.forEach(function (element) {
    element.addEventListener("click", function () {
        console.log("動作確認");
        var price = element.getAttribute("data-price");
        var name = element.getAttribute("data-name");
        var dataPrimaryCategoryName = element.getAttribute(
            "data-primaryCategoryName"
        );
        var dataSecondaryCategoryName = element.getAttribute(
            "data-secondaryCategoryName"
        );
        var dataText = element.getAttribute("data-text");
        var url = element.getAttribute("data-url");

        document.getElementById("myModalLabel").innerText = name;
        document.getElementById("modal-name").innerText = name;
        document.getElementById("modal-price").innerText = price;
        document.getElementById("modal-text").innerText = dataText;
        document.getElementById("modal-category").innerText =
            dataPrimaryCategoryName;
        document.getElementById("modal-sub-category").innerText =
            dataSecondaryCategoryName;
        document.getElementById("modal-form").setAttribute("action", url);
    });
});

// スタンプのモーダル
var stampImg = document.getElementsByClassName("stamp-img");

var stampImgs = document.querySelectorAll(".stamp-img");
var stampModalLabel = document.getElementById("stampModalLabel");

stampImgs.forEach(function (element) {
    element.addEventListener("click", function () {
        console.log("動作確認");
        var name = element.getAttribute("data-name");
        var url = element.getAttribute("data-url");
        var dataText = element.getAttribute("data-text");

        document.getElementById("stampModalLabel").innerText = name;
        document.getElementById("stamp-modal-text").innerText = dataText;
        document.getElementById("stamp-url").setAttribute("src", url);
    });
});
