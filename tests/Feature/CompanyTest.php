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
    use RefreshDatabase;

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
        $user = User::factory()->create();

        Auth::login($user);

        $response = $this->post('/companies', [
            'name' => 'PRUM',
        ]);

        $response->assertStatus(302);

        $company = Company::where('name', 'PRUM')->first();
        $this->assertNotNull($company);
    }

    public function testGetEditCompanies()
    {
        $company = Company::factory()->create();

        $user = User::factory()->create();

        $response = $this->actingAs($user)->get("/companies/#{ $company>id }");

        $response->assertStatus(200);
    }
}
