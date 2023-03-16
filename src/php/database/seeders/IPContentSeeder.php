<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IPContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ipcontents')->insert(
            [
                [
                    'id'=>1,
                    'name'=>'Luffy',
                    'image_file'=>'ONE_PIECE/onepiece01_luffy.png',
                    'description'=>'えすぽわぁるに、俺はなる！！'
                ],
                [
                    'id'=>2,
                    'name'=>'Zoro',
                    'image_file'=>'ONE_PIECE/onepiece02_zoro_bandana.png',
                    'description'=>'背中の傷はバリスタの恥だ'
                ],
                [
                    'id'=>3,
                    'name'=>'Nami',
                    'image_file'=>'ONE_PIECE/onepiece03_nami.png',
                    'description'=>'相手が客とコーヒー豆ならレジ打ちしてみせる!!この店の”経理”は誰!!？'
                ],
                [
                    'id'=>4,
                    'name'=>'Usopp',
                    'image_file'=>'ONE_PIECE/onepiece04_usopp_sogeking.png',
                    'description'=>'おれは元から!!!ネガティブだァ!!!!'
                ],
                [
                    'id'=>5,
                    'name'=>'Sanji',
                    'image_file'=>'ONE_PIECE/onepiece05_sanji.png',
                    'description'=>'レディが来店する音がした'
                ],
                [
                    'id'=>6,
                    'name'=>'Chopper',
                    'image_file'=>'ONE_PIECE/onepiece06_chopper.png',
                    'description'=>'バ…バカヤローそんなのほめられても嬉しくねェよ!!コノヤローが'
                ],
                [
                    'id'=>7,
                    'name'=>'Robin',
                    'image_file'=>'ONE_PIECE/onepiece07_robin.png',
                    'description'=>'淹れたいっ!!!! …!!!私も一緒にカフェへ連れてって!!!'
                ],
                [
                    'id'=>8,
                    'name'=>'Franky',
                    'image_file'=>'ONE_PIECE/onepiece08_franky.png',
                    'description'=>'ん~~~~~……スーパー~~~~!!     (コーヒー)ビーンズレフト!!!'
                ],
                [
                    'id'=>9,
                    'name'=>'Brook',
                    'image_file'=>'ONE_PIECE/onepiece09_brook.png',
                    'description'=>'レシート見せて貰ってもよろしいですか？'
                ],
                [
                    'id'=>10,
                    'name'=>'Jinbe',
                    'image_file'=>'ONE_PIECE/onepiece10_jinbe.png',
                    'description'=>'未来の「喫茶店チェーンNo.1」の仲間になろうっちゅう男が「タリーズ」ごときに臆しておられるかァ!!!'
                ],
                [
                    'id'=>11,
                    'name'=>'Arlong',
                    'image_file'=>'ONE_PIECE/onepiece11_arlong.png',
                    'description'=>'シャハハハ!!  シャハハハハハハハ!! シャ--ハッハッハッハッハ-!!笑'
                ],
                [
                    'id'=>12,
                    'name'=>'Buggy',
                    'image_file'=>'ONE_PIECE/onepiece12_buggy.png',
                    'description'=>'男なら……!! おれと一緒に夢を見ねェか…!? おれは今日…”スターバックス”の首を…即ち”世界”をとる!!!!'
                ],
                [
                    'id'=>13,
                    'name'=>'Crocodile',
                    'image_file'=>'ONE_PIECE/onepiece13_crocodile.png',
                    'description'=>'守りてェもんはしっかり守りやがれ!!!これ以上こいつらの思い通りにさせんじゃねェよ!!!'
                ],
                [
                    'id'=>14,
                    'name'=>'Enel',
                    'image_file'=>'ONE_PIECE/onepiece14_enel.png',
                    'description'=>'「神が予言を外すわけにはいくまい、絶対なのだから」'
                ],
                [
                    'id'=>15,
                    'name'=>'Lucci',
                    'image_file'=>'ONE_PIECE/onepiece15_lucci.png',
                    'description'=>'悪はこの世に栄えない！'
                ],
                [
                    'id'=>16,
                    'name'=>'Moria',
                    'image_file'=>'ONE_PIECE/onepiece16_moria.png',
                    'description'=>'俺は何も手を下さねえ。他人の力で海賊王になる男'
                ],
                [
                    'id'=>17,
                    'name'=>'Doflamingo',
                    'image_file'=>'ONE_PIECE/onepiece17_doflamingo.png',
                    'description'=>'正義は勝つって!?そりゃあそうだろ 勝者だけが正義だ!!!!'
                ],
                [
                    'id'=>18,
                    'name'=>'Linlin_Kaido',
                    'image_file'=>'ONE_PIECE/onepiece18_linlin_kaido.png',
                    'description'=>'まさかお前も…”カフェオレ色”を…!!?  / ライフ（寿命）オア コーヒー……!?'
                ],
                [
                    'id'=>19,
                    'name'=>'Kurohige_tech2',
                    'image_file'=>'ONE_PIECE/onepiece19_kurohige_teach2.png',
                    'description'=>'飲食店が夢を見る時代が終わるって……!!?えェ!?オイ!!!!人の夢は!!!終わらねェ!!!!'
                ],
                [
                    'id'=>20,
                    'name'=>'Santaisyou',
                    'image_file'=>'ONE_PIECE/onepiece20_santaisyou.png',
                    'description'=>'“白ひげ”は所詮…先の時代の”敗北者”じゃけェ…!!! / コワイねェ～ / お前にゃ まだこのステージは早すぎるよ'
                ],
            ]
        );
    }
}
