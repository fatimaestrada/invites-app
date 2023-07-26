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
        $response = $this->get('/v1/affiliates')->assertJsonStructure([
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

        $response = $this->get("/v1/affiliates/$id")->assertJsonStructure([
            'id',
            'name',
            'location' => [
                'latitude',
                'longitude'
            ]
        ]);

        $response->assertStatus(200);
    }

    /** @test */
    public function get_affiliate_by_distance_test()
    {
        $response = $this->call('GET', '/v1/affiliates/getByDistance', ['from' => 'Dublin', 'km' => '100'])->assertJsonStructure([
            [
                'id',
                'name',
                'location' => [
                    'latitude',
                    'longitude'
                ],
                'distance'
            ]
        ]);

        $response->assertStatus(200);
    }

        /** @test */
        public function get_affiliate_by_distance_validation_test()
        {
            $response = $this->call('GET', '/v1/affiliates/getByDistance', ['from' => 'Some City', 'km' => 'ABC']);
            $responseFrom = $this->call('GET', '/v1/affiliates/getByDistance', ['from' => 'Some City', 'km' => '100']);
            $responseKm = $this->call('GET', '/v1/affiliates/getByDistance', ['from' => 'Cork', 'km' => 'ANC']);
            
            $response->assertStatus(404);
            $responseFrom->assertStatus(404);
            $responseKm->assertStatus(404);
        }
}
