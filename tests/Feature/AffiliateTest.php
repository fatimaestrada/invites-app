<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Affiliate;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AffiliateTest extends TestCase
{
    /** @test */
    public function list_affiliates_structure_test()
    {
        $response = $this->get('/api/affiliates')->assertJsonStructure([
            [
                'id',
                'name',
                'location' => [
                    'latitude',
                    'longitude'
                ]
            ],
        ]);

        $response->assertStatus(200);
    }

    /** @test */
    public function get_single_affiliate_details_test()
    {
        $affiliatesIds = Affiliate::getAll()->pluck('id')->flatten()->toArray();
        $id = array_rand($affiliatesIds, 1);

        $response = $this->get("/api/affiliates/$id")->assertJsonStructure([
            'id',
            'name',
            'location' => [
                'latitude',
                'longitude'
            ]
        ]);

        $response->assertStatus(200);
    }
}
