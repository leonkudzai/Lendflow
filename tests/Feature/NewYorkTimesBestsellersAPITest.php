<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class NewYorkTimesBestsellersAPITest extends TestCase
{
    // Test that query parameters work correctly
    public function test_query_parameters()
    {
        $response = $this->withoutMiddleware(\Illuminate\Routing\Middleware\ThrottleRequests::class)
            ->get('/api/v1/bestsellers?title=give&author=Diana&isbn=0399178570&offset=0');
        $response->assertStatus(200);


        $response->assertJson([
            'results' => [
                [
                    'title' => "\"I GIVE YOU MY BODY ...\"",
                ]
            ]
        ]);
    }

    public function test_isbn_validation()
    {
        //10 digits
        $response = $this->withoutMiddleware(\Illuminate\Routing\Middleware\ThrottleRequests::class)
            ->get('/api/v1/bestsellers?isbn=0399178570');
        $response->assertStatus(200);

        //13 digits
        $response = $this->withoutMiddleware(\Illuminate\Routing\Middleware\ThrottleRequests::class)
            ->get('/api/v1/bestsellers?isbn=9780399178573');
        $response->assertStatus(200);

        // Multiple
        $response = $this->withoutMiddleware(\Illuminate\Routing\Middleware\ThrottleRequests::class)
            ->get('/api/v1/bestsellers?isbn=9780399178573;0399178570');
        $response->assertStatus(200);

        //wrong
        $response = $this->withoutMiddleware(\Illuminate\Routing\Middleware\ThrottleRequests::class)
            ->get('/api/v1/bestsellers?isbn=12345');
        $response->assertStatus(422);  // Validation error

        //wrong multiple
        $response = $this->withoutMiddleware(\Illuminate\Routing\Middleware\ThrottleRequests::class)
            ->get('/api/v1/bestsellers?isbn=12345;987654');
        $response->assertStatus(422);  // Validation error
    }

    public function test_offset_validation()
    {

        $response = $this->withoutMiddleware(\Illuminate\Routing\Middleware\ThrottleRequests::class)
            ->get('/api/v1/bestsellers?offset=20');
        $response->assertStatus(200);

        $response = $this->get('/api/v1/bestsellers?offset=25');
        $response->assertStatus(422);
    }

}
