<?php

namespace Tests\Unit\Http;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\DeliveryDestination;

class ProfileControllerTest extends TestCase
{
    use RefreshDatabase,WithFaker;
    public function test_ログインしていればURLにアクセスできる()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->get(route('mypage.edit-profile'));
        $response->assertstatus(200);
    }
    public function test_ログイン状態でURLにアクセスするとプロフィール編集画面が表示される()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->get(route('mypage.edit-profile'));
        $response->assertViewIs('mypage.profile_edit_form');
    }
    public function test_ログインしていない状態でURLにアクセスするとログイン画面に遷移する()
    {
        $user = User::factory()->create();
        $response = $this->get(route('mypage.edit-profile'));
        $response->assertRedirect(route('login'));
    }
    public function test_ユーザー名のみ編集して保存すると、ユーザー情報が更新されてプロフィール編集画面にリダイレクトされる()
    {
        $user = User::factory()->createOne([
            'name' => 'testUser',
            'email' => 'testUser@example.com'
        ]);
        $this->actingAs($user);
        $response = $this->from('/mypage/edit-profile')->post(route('mypage.edit-profile'),[
            'name' => 'testUser2',
            'email' => 'testUser@example.com'
        ]);
        $response->assertRedirect(route('mypage.edit-profile'));
    }
    public function test_メールアドレスのみ編集して保存すると、ユーザー情報が更新されてプロフィール編集画面にリダイレクトされる()
    {
        $user = User::factory()->createOne([
            'name' => 'testUser',
            'email' => 'testUser@example.com'
        ]);
        $this->actingAs($user);
        $response = $this->from('/mypage/edit-profile')->post(route('mypage.edit-profile'),[
            'name' => 'testUser',
            'email' => 'testUser2@example.com'
        ]);
        $response->assertRedirect(route('mypage.edit-profile'));
    }
    public function test_ユーザー名・メールアドレスともに編集して保存すると、ユーザー情報が更新されてプロフィール編集画面にリダイレクトされる()
    {
        $user = User::factory()->createOne([
            'name' => 'testUser',
            'email' => 'testUser@example.com'
        ]);
        $this->actingAs($user);
        $response = $this->from('/mypage/edit-profile')->post(route('mypage.edit-profile'),[
            'name' => 'testUser2',
            'email' => 'testUser2@example.com'
        ]);
        $response->assertRedirect(route('mypage.edit-profile'));
    }
    public function test_メールアドレスがすでに使用されている場合、エラーメッセージが表示される()
    {
        $user = User::factory()->createOne([
            'name' => 'testUser',
            'email' => 'testUser@example.com'
        ]);
        $anotherUser = User::factory()->createOne([
            'name' => 'testUser2',
            'email' => 'testUser2@example.com'
        ]);
        $this->actingAs($user);
        $response = $this->from('/mypage/edit-profile')->post(route('mypage.edit-profile'),[
            'name' => 'testUser3',
            'email' => $anotherUser->email
        ]);
        $errorMessage = '指定のメールアドレスは既に使用されています。';
        $this->get(route('mypage.edit-profile'))->assertSee($errorMessage);
    }
    public function test_ユーザー名が空(){
        $user = User::factory()->createOne([
            'name' => 'testUser',
            'email' => 'testUser@example.com'
        ]);
        $this->actingAs($user);
        $response = $this->from('/mypage/edit-profile')->post(route('mypage.edit-profile'),[
            'name' => '',
            'email' => $user->email
        ]);
        $errorMessage = 'ユーザー名は、必ず指定してください。';
        $this->get(route('mypage.edit-profile'))->assertSee($errorMessage);
    }
    public function test_メールアドレスが空(){
        $user = User::factory()->createOne([
            'name' => 'testUser',
            'email' => 'testUser@example.com'
        ]);
        $this->actingAs($user);
        $response = $this->from('/mypage/edit-profile')->post(route('mypage.edit-profile'),[
            'name' => $user->name,
            'email' => ''
        ]);
        $errorMessage = 'メールアドレスは、必ず指定してください。';
        $this->get(route('mypage.edit-profile'))->assertSee($errorMessage);
    }
}
