<?php

declare(strict_types=1);

use Illuminate\Foundation\Testing\RefreshDatabase;

describe('Commission Report API', function () {
    
    describe('GET /api/v1/reports/commission', function () {
        
        it('returns successful response', function () {
            $response = $this->getJson('/api/v1/reports/commission');
            
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

        it('accepts valid filter parameters', function () {
            $response = $this->getJson('/api/v1/reports/commission?' . http_build_query([
                'distributor' => 'John',
                'date_from' => '2020-01-01',
                'date_to' => '2020-12-31',
                'invoice' => 'ABC',
                'per_page' => 20,
            ]));
            
            $response->assertStatus(200);
        });

        it('validates date format', function () {
            $response = $this->getJson('/api/v1/reports/commission?' . http_build_query([
                'date_from' => 'invalid-date',
            ]));
            
            $response->assertStatus(422)
                ->assertJsonValidationErrors(['date_from']);
        });

        it('validates date_to is after date_from', function () {
            $response = $this->getJson('/api/v1/reports/commission?' . http_build_query([
                'date_from' => '2020-12-31',
                'date_to' => '2020-01-01',
            ]));
            
            $response->assertStatus(422)
                ->assertJsonValidationErrors(['date_to']);
        });

        it('validates per_page is within range', function () {
            $response = $this->getJson('/api/v1/reports/commission?' . http_build_query([
                'per_page' => 999,
            ]));
            
            $response->assertStatus(422)
                ->assertJsonValidationErrors(['per_page']);
        });
    });

    describe('GET /api/v1/reports/commission/orders/{invoice}/items', function () {
        
        it('returns 404 for non-existent invoice', function () {
            $response = $this->getJson('/api/v1/reports/commission/orders/NONEXISTENT/items');
            
            $response->assertStatus(404)
                ->assertJson([
                    'success' => false,
                    'message' => 'Order not found.',
                ]);
        });
    });
});
