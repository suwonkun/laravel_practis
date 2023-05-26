<?php

namespace Tests\Feature;

use App\Models\Company;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Database\Factories\UserFactory;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

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
        Company::factory()->create();
        // ユーザー作成
        $user = User::factory()->create();

        // ユーザーのログインする
        Auth::login($user);

        // 会社一覧を取得する
        $response = $this->get('/companies');

        // レスポンスが200かえっているか
        $response->assertStatus(200);
    }

    public function testGetCreateCompanies()
    {
        Company::factory()->create();

        $user = User::factory()->create();

        Auth::login($user);

        $response = $this->get('/companies/create');

        $response->assertStatus(200);
    }

    public function testStoreCompanies()
    {
        Company::factory()->create();

        $user = User::factory()->create();

        Auth::login($user);

        $response = $this->post('/companies', [
            'name' => 'PRUM',
        ]);

        $response->assertStatus(302);

        $company = Company::where('name', 'PRUM')->first();
        $this->assertNotNull($company);
    }

    public function testShowCompanies()
    {
        $company = Company::factory()->create();

        $user = User::factory()->create();

        Auth::login($user);

        $response = $this->actingAs($user)->get("/companies/$company->id");

        $response->assertStatus(200);


        $user->company->id = $company->id + 1;

        $user->save();

        $response = $this->actingAs($user)->get("/companies/$company->id");


        $response->assertStatus(403);
    }

    public function testGetEditCompanies()
    {
        $company = Company::factory()->create();

        $user = User::create([
            'name' => 'test', // ユーザー名
            'email' => 'test@example.com', // ユーザーのメールアドレス
            'email_verified_at' => now(),
            'password' => bcrypt('password'), // パスワード
            'remember_token' => Str::random(10),
        ]);

        $user->company_id = $company->id;

        $user->save();

        $response = $this->actingAs($user)->get("/companies/$company->id/edit");

        $response->assertStatus(200);

        $user->company->id = $company->id + 1;

        $user->save();

        $response = $this->actingAs($user)->get("/companies/$company->id/edit");


        $response->assertStatus(403);
    }

    public function testUpdateCompany()
    {
        $company = Company::factory()->create();


        $user = User::create([
            'name' => 'test', // ユーザー名
            'email' => 'test@example.com', // ユーザーのメールアドレス
            'email_verified_at' => now(),
            'password' => bcrypt('password'), // パスワード
            'remember_token' => Str::random(10),
        ]);

        $user->company_id = $company->id;

        $user->save();

        Auth::login($user);

        $response = $this->put("/companies/$company->id", [
            'name' => 'PRUM2',
        ]);

        $company = Company::where('name', 'PRUM2')->first();
        $response->assertStatus(302);
        $this->assertNotNull($company);


        $user->company->id = $company->id + 1;

        $user->save();

        $response = $this->actingAs($user)->put("/companies/$company->id", [
            'name' => 'PRUM3',
        ]);

        $response->assertStatus(403);
        $company = Company::where('name', 'PRUM3')->first();
        $this->assertNull($company);
    }

    public function testDestroyCompany()
    {
        $company = Company::factory()->create();

        $user = User::create([
            'name' => 'test', // ユーザー名
            'email' => 'test@example.com', // ユーザーのメールアドレス
            'email_verified_at' => now(),
            'password' => bcrypt('password'), // パスワード
            'remember_token' => Str::random(10),
        ]);

        $user->company_id = $company->id;

        $user->save();

        $url = route('companies.destroy', $company->id);

        $response = $this->actingAs($user)->delete($url);


        $response->assertStatus(302);

        $this->assertDatabaseMissing('companies', [
            'id' => $company->id,
        ]);
    }
}
