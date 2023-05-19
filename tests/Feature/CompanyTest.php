<?php

namespace Tests\Feature;

use App\Models\Company;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Database\Factories\UserFactory;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CompanyTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testGetCompanies()
    {
        // ユーザー作成
        $user = User::factory()->create();

        // ユーザーのログインする
        Auth::login($user);

        // 会社一覧を取得する
        $response = $this->get('/companies');

       // レスポンスが200かえっているか
        $response->assertStatus(200);
    }

    public function testStoreCompanies()
    {
        // テスト用のユーザーを作成する
        $user = User::factory()->create();

        // テスト用のユーザーでログインする
        Auth::login($user);

        // 会社を登録するリクエストを送信する
        $response = $this->post('/companies', [
            'name' => 'PRUM',
        ]);

        // レスポンスのステータスコードが 200 であることをアサートする
        $response->assertStatus(200);

        $company = Company::where('name', 'Test Company')->where('user_id', $user->id)->first();
        $this->assertNotNull($company);
    }
}
