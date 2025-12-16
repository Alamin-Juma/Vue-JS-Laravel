<?php

declare(strict_types=1);

describe('Top Distributors API', function () {
    
    describe('GET /api/v1/reports/top-distributors', function () {
        
        it('returns successful response', function () {
            $response = $this->getJson('/api/v1/reports/top-distributors');
            
            $response->assertStatus(200)
                ->assertJsonStructure([
                    'success',
                    'message',
                    'data',
                    'pagination' => [
                        'current_page',
                        'per_page',
                        'total',
                        'last_page',
                    ],
                ]);
        });

        it('accepts limit parameter', function () {
            $response = $this->getJson('/api/v1/reports/top-distributors?' . http_build_query([
                'limit' => 100,
            ]));
            
            $response->assertStatus(200);
        });

        it('accepts per_page parameter', function () {
            $response = $this->getJson('/api/v1/reports/top-distributors?' . http_build_query([
                'per_page' => 10,
            ]));
            
            $response->assertStatus(200);
        });

        it('validates limit is within range', function () {
            $response = $this->getJson('/api/v1/reports/top-distributors?' . http_build_query([
                'limit' => 999,
            ]));
            
            $response->assertStatus(422)
                ->assertJsonValidationErrors(['limit']);
        });

        it('validates per_page is within range', function () {
            $response = $this->getJson('/api/v1/reports/top-distributors?' . http_build_query([
                'per_page' => 999,
            ]));
            
            $response->assertStatus(422)
                ->assertJsonValidationErrors(['per_page']);
        });

        it('returns distributors with rank information', function () {
            $response = $this->getJson('/api/v1/reports/top-distributors');
            
            $response->assertStatus(200);
            
            if (count($response->json('data')) > 0) {
                $response->assertJsonStructure([
                    'data' => [
                        '*' => [
                            'rank',
                            'distributor_id',
                            'distributor_name',
                            'total_sales',
                            'total_sales_raw',
                        ],
                    ],
                ]);
            }
        });
    });
});
