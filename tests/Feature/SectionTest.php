<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Company;
use App\Models\User;
use App\Models\Section;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class SectionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->company = Company::factory()->create();
        $this->sections = Section::factory()->count(100)->create();
        $this->user = User::factory()->create();
    }

    public function test_create()
    {
        $companyId = $this->company->id;

        $response = $this->get("companies/$companyId/sections/create");

        $response->assertStatus(302);

        Auth::login($this->user);


        $response = $this->get("companies/$companyId/sections/create");

        $response->assertStatus(200);
    }

    public function test_store()
    {
        $companyId = $this->company->id;

        $this->post("/companies/$companyId/sections", [
            'name' => '人事',
        ]);

        $section = Section::where('name', '人事')->first();

//  　　 ログインしていないと部署は作られない
        $this->assertNull($section);

        Auth::login($this->user);


        $response = $this->post("/companies/$companyId/sections", [
            'name' => '人事',
        ]);

        $response->assertStatus(302);

        $section = Section::where('name', '人事')->first();

        $this->assertNotNull($section);
    }

    public function test_show()
    {
        $companyId = $this->company->id;
        $sectionId = $this->sections->first()->id;

        Auth::login($this->user);

        $response = $this->get("companies/$companyId/sections/$sectionId");

        $response->assertStatus(200);
    }

    public function test_edit()
    {
        $companyId = $this->company->id;
        $sectionId = $this->sections->first()->id;

        Auth::login($this->user);

        $response = $this->get("companies/$companyId/sections/$sectionId/edit");

        $response->assertStatus(200);
    }

    public function test_update()
    {
        $companyId = $this->company->id;
        $sectionId = $this->sections->first()->id;

        Auth::login($this->user);

        $response = $this->put("companies/$companyId/sections/$sectionId", [  'name' => '営業',
        ]);

        $section = Section::find($sectionId);
        $this->assertEquals('営業', $section->name);
        $response->assertStatus(302);
    }

    public function test_destroy()
    {
        $companyId = $this->company->id;
        $sectionId = $this->sections->first()->id;

        Auth::login($this->user);

        $response = $this->delete("companies/$companyId/sections/$sectionId");

        $this->assertDatabaseMissing('sections', [
            'id' => $sectionId,
        ]);
        $response->assertStatus(302);
    }
}
