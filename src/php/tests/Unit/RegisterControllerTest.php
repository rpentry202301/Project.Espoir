<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Database\Eloquent\Factories\Factory;
use Tests\TestCase;

class RegisterControllerTest extends TestCase
{
    use RefreshDatabase,WithFaker;
    /**
     * ユーザー登録画面のURLにアクセスして画面が表示されることを確認
     */
    public function test_ユーザー登録画面のURLにアクセスしてユーザー登録画面が表示される()
    {
        $response = $this->get(route('register'));
        $response->assertViewIs('auth.register');
    }
    /**
     * 登録完了時にトップ画面に遷移することを確認
     */
    public function test_ユーザー登録に成功した後は投稿一覧画面が表示される()
    {
        // ユーザー登録処理
        $response = $this->post(route('register'),[
            'name' => 'testUser',
            'email' => 'test@example.com',
            'password' => 'registerPass',
        ]);
        $response->assertRedirect(route('top'));
    }
    /**
     * 名前が空のエラーを確認
     */
    public function test_名前を入力しないで登録しようとするとエラーメッセージが表示される(){
        $response = $this->post(route('register'),[
            'name' => '',
            'email' => 'test@example.com',
            'password' => 'password123'
        ]);
        $errorMessage = 'ユーザー名は、必ず指定してください。';
        $this->get(route('register'))->assertSee($errorMessage);
    }
    /**
     * 名前が31文字以上のエラーを確認
     */
    public function test_名前が31文字以上で入力しようとするとエラーメッセージが表示される(){
        $response = $this->post(route('register'),[
            'name' => $this->faker->realText(31),
            'email' => 'test@example.com',
            'password' => 'password123'
        ]);
        $errorMessage = 'ユーザー名は、30文字以下にしてください。';
        $this->get(route('register'))->assertSee($errorMessage);
    }
    /**
     * メールアドレスが空のエラーを確認
     */
    public function test_メールアドレスを入力しないで登録しようとするとエラーメッセージが表示される(){
        $response = $this->post(route('register'),[
            'name' => 'testUser',
            'email' => '',
            'password' => 'password123'
        ]);
        $errorMessage = 'メールアドレスは、必ず指定してください';
        $this->get(route('register'))->assertSee($errorMessage);
    }
    /**
     * メールアドレスが254文字以上のエラーを確認
     */
    public function test_メールアドレスが254文字以上だとエラーメッセージが表示される(){
        $response = $this->post(route('register'),[
            'name' => 'testUser',
            'email' => $this->faker->realText(254).'@example.com',
            'password' => 'password123'
        ]);
        $errorMessage = 'メールアドレスは、254文字以下にしてください';
        $this->get(route('register'))->assertSee($errorMessage);
    }
    /**
     * メールアドレスが6文字未満のエラーを確認
     */
    public function test_メールアドレスが6文字以下だとエラーメッセージが表示される(){
        $response = $this->post(route('register'),[
            'name' => 'testUser',
            'email' => '12@34',
            'password' => 'password123'
        ]);
        $errorMessage = 'メールアドレスは、6文字以上にしてください';
        $this->get(route('register'))->assertSee($errorMessage);
    }

    /**
     * メールアドレスの重複エラーを確認
     */
    public function test_メールアドレスがすでに登録されていると、エラーメッセージが表示される(){
        $user = factory(User::class)->create([
            'email'=>'pass@example.com',
            'password'=>'password123'
        ]);

        $response = $this->post(route('register'),[
            'name' => 'testUser',
            'email' => '12345',
            'password' => 'password123'
        ]);
        $errorMessage = '指定のメールアドレスは既に使用されています。';
        $this->get(route('register'))->assertSee($errorMessage);
    }

    /**
     * パスワードが空のエラーを確認
     */
    public function test_パスワードを入力しないで登録しようとするとエラーメッセージが表示される(){
        $response = $this->post(route('register'),[
            'name' => 'testUser',
            'email' => 'test@example.com',
            'password' => ''
        ]);
        $errorMessage = 'パスワードは、必ず指定してください';
        $this->get(route('register'))->assertSee($errorMessage);
    }
    
}
