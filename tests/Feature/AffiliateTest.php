<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AffiliateTest extends TestCase
{
    /** @test */
    public function list_affiliates_structure_test()
    {
        $response = $this->get('/api/affiliates')->assertJsonStructure([
            [
                'id',
                'name',
                'latitude',
                'longitude'
            ],
        ]);
        
        $response->assertStatus(200);
    }
}
