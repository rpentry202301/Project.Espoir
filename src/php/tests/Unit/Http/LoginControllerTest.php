<?php

namespace Tests\Unit\Http;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase,WithFaker;
    /**
     * ログイン画面のURLへアクセスして画面が表示されることを確認
     */
    public function test_ログイン画面のURLにアクセスできる()
    {
        $response = $this->get(route('login'));
        $response->assertStatus(200);
    }
     /**
     * ログイン画面のURLへアクセスしてログイン画面が表示されることを確認
     */
    public function test_ログイン画面のURLにアクセスしてログイン画面が表示される(){
        $response = $this->get(route('login'));
        $response->assertViewIs('auth.login');
    }
     /**
     * 登録済みのemailとpasswordでログインができることを確認
     */
    public function test_登録しておいたemailアドレスとパスワードでログインができる(){
        $user = User::factory()->createOne([
            'email' => 'pass@example.com',
            'password' => bcrypt('loginPass')
        ]);
        $response = $this->post(route('login'),[
            'email' => 'pass@example.com',
            'password' => 'loginPass'
        ]);
        $this->assertAuthenticatedAs($user);
    }
    /**
     * ログイン成功時にトップ画面が表示されることを確認
     */
    public function test_ログインに成功した後はトップ画面が表示される(){
        $user = User::factory()->createOne([
            'email' => 'pass@example.com',
            'password' => bcrypt('loginPass')
        ]);
        $response = $this->post(route('login'),[
            'email'=> 'pass@example.com',
            'password' => 'loginPass'
        ]);
        $response->assertRedirect(route('top'));
    }
     /**
     * 異なるメールアドレスではログインできないことを確認
     */
    public function test_登録したメールアドレスと異なるアドレスではログインできない(){
        $user = User::factory()->createOne([
            'email'=> 'pass@example.com',
            'password' => bcrypt('loginPass')
        ]);
        $response = $this->post(route('login'),[
            'email'=> 'pass2@example.com',
            'password' => 'loginPass'
        ]);
        $this->assertGuest();
    }
     /**
     * 異なるパスワードではログインできないことをかくにん
     */
    public function test_登録したパスワードと異なるパスワードではログインできない(){
        $user = User::factory()->createOne([
            'email'=> 'pass@example.com',
            'password' => bcrypt('loginPass')
        ]);
        $response = $this->post(route('login'),[
            'email'=> 'pass@example.com',
            'password' => 'loginPass2'
        ]);
        $this->assertGuest();
    }
     /**
     * 異なるメールアドレスではエラーメッセージが表示されることを確認
     */
    public function test_登録したメールアドレスと異なるアドレスではエラーメッセージが表示される(){
        $user = User::factory()->createOne([
            'email'=> 'pass@example.com',
            'password' => bcrypt('loginPass')
        ]);
        $response = $this->post(route('login'),[
            'email'=> 'pass2@example.com',
            'password' => 'loginPass'
        ]);
        $errorMessage = '認証情報と一致するレコードがありません。';
        $this->get(route('login'))->assertSee($errorMessage);
    }
     /**
     * 異なるパスワードではエラーメッセージが表示されることを確認
     */
    public function test_登録したパスワードと異なるパスワードではエラーメッセージが表示される(){
        $user = User::factory()->createOne([
            'email'=> 'pass@example.com',
            'password' => bcrypt('loginPass')
        ]);
        $response = $this->post(route('login'),[
            'email'=> 'pass@example.com',
            'password' => 'loginPass2'
        ]);
        $errorMessage = '認証情報と一致するレコードがありません。';
        $this->get(route('login'))->assertSee($errorMessage);
    }
    /**
     * ログアウトすると認証状態が解除されることを確認
     */
    public function test_ログアウトすると認証状態が解除される(){
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->post(route('logout'));
        $this->assertGuest();
    }
    /**
     * ログアウトすると直前の画面に遷移しようとすることを確認（一般ユーザーの場合）
     */
    public function test_ログアウトすると直前の画面を表示しようとする（一般ユーザー）(){
        $user = User::factory()->create();
        $this->actingAs($user);
        $response=$this->from('/items/cart')->post(route('logout'));
        $response->assertRedirect(route('show.item.cart'));
    }
     /**
     * 直前の画面が権限付与されたユーザーのみアクセス可能なページだった場合、ログアウトするとトップ画面に遷移しようとすることを確認（管理者アカウントの場合）
     */
    public function test_直前の画面が権限付与されたユーザーのみアクセス可能なページだった場合、ログアウトするとトップ画面に遷移しようとする（管理者）(){
        $user = User::factory()->createOne([
            'email'=> 'pass@example.com',
            'password' => bcrypt('loginPass'),
            'admin_flag' => 1
        ]);
        $this->actingAs($user);
        $this->post(route('logout'));
        $response=$this->from('/sell')->post(route('logout'));
        $response->assertRedirect(route('sell'));
    }
     /**
     * ログアウト後はトップページが表示されることを確認確認
     */
    public function test_ログアウト後はトップページが表示される(){
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->get(route('top'));
        $response->assertViewIs('top');
    }

}
