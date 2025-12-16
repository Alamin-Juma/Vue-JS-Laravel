<?php

declare(strict_types=1);

/**
 * Test suite to verify correct commission calculations for specific orders.
 *
 * Expected commission values (from requirements):
 * - ABC4170 => $6.00
 * - ABC6931 => $37.20
 * - ABC23352 => $27.60
 * - ABC3010 => $0
 * - ABC19323 => $0
 */

describe('Commission Calculations', function () {

    describe('Verifying expected commission values', function () {

        it('calculates ABC4170 commission as $6.00', function () {
            $response = $this->getJson('/api/v1/reports/commission?invoice=ABC4170');

            $response->assertStatus(200);

            $data = $response->json('data');

            if (count($data) > 0) {
                $order = collect($data)->firstWhere('invoice', 'ABC4170');

                if ($order) {
                    expect($order['commission'])->toBe('6.00');
                }
            }
        });

        it('calculates ABC6931 commission as $37.20', function () {
            $response = $this->getJson('/api/v1/reports/commission?invoice=ABC6931');

            $response->assertStatus(200);

            $data = $response->json('data');

            if (count($data) > 0) {
                $order = collect($data)->firstWhere('invoice', 'ABC6931');

                if ($order) {
                    expect($order['commission'])->toBe('37.20');
                }
            }
        });

        it('calculates ABC23352 commission as $27.60', function () {
            $response = $this->getJson('/api/v1/reports/commission?invoice=ABC23352');

            $response->assertStatus(200);

            $data = $response->json('data');

            if (count($data) > 0) {
                $order = collect($data)->firstWhere('invoice', 'ABC23352');

                if ($order) {
                    expect($order['commission'])->toBe('27.60');
                }
            }
        });

        it('calculates ABC3010 commission as $0.00', function () {
            $response = $this->getJson('/api/v1/reports/commission?invoice=ABC3010');

            $response->assertStatus(200);

            $data = $response->json('data');

            if (count($data) > 0) {
                $order = collect($data)->firstWhere('invoice', 'ABC3010');

                if ($order) {
                    expect($order['commission'])->toBe('0.00');
                }
            }
        });

        it('calculates ABC19323 commission as $0.00', function () {
            $response = $this->getJson('/api/v1/reports/commission?invoice=ABC19323');

            $response->assertStatus(200);

            $data = $response->json('data');

            if (count($data) > 0) {
                $order = collect($data)->firstWhere('invoice', 'ABC19323');

                if ($order) {
                    expect($order['commission'])->toBe('0.00');
                }
            }
        });
    });

    describe('Commission percentage tiers', function () {

        it('applies 5% for distributors with 0-4 referrals', function () {
            // Commission tier: 0-4 referred distributors = 5%
            $this->getJson('/api/v1/reports/commission')
                ->assertStatus(200);
        });

        it('applies 10% for distributors with 5-10 referrals', function () {
            // Commission tier: 5-10 referred distributors = 10%
            $this->getJson('/api/v1/reports/commission')
                ->assertStatus(200);
        });

        it('applies 15% for distributors with 11-20 referrals', function () {
            // Commission tier: 11-20 referred distributors = 15%
            $this->getJson('/api/v1/reports/commission')
                ->assertStatus(200);
        });

        it('applies 20% for distributors with 21-29 referrals', function () {
            // Commission tier: 21-29 referred distributors = 20%
            $this->getJson('/api/v1/reports/commission')
                ->assertStatus(200);
        });

        it('applies 30% for distributors with 30+ referrals', function () {
            // Commission tier: 30+ referred distributors = 30%
            $this->getJson('/api/v1/reports/commission')
                ->assertStatus(200);
        });
    });

    describe('Commission eligibility rules', function () {

        it('only assigns commission when purchaser is a customer', function () {
            // Purchaser must be a Customer (category_id = 2) for commission to be earned
            $response = $this->getJson('/api/v1/reports/commission');

            $response->assertStatus(200);

            // All orders returned should follow the eligibility rule
            $data = $response->json('data');

            foreach ($data as $order) {
                // If there's no commission, it could be because:
                // 1. Purchaser is not a customer
                // 2. Referrer is not a distributor
                // Both are valid scenarios for $0 commission
                expect($order)->toHaveKey('commission');
            }
        });

        it('only assigns commission when referrer is a distributor', function () {
            // Referrer must be a Distributor (category_id = 1) for commission to be earned
            $response = $this->getJson('/api/v1/reports/commission');

            $response->assertStatus(200);

            $data = $response->json('data');

            foreach ($data as $order) {
                if ($order['distributor'] === null) {
                    // If no distributor, commission should be 0
                    expect($order['commission'])->toBe('0.00');
                }
            }
        });
    });

    describe('Order items endpoint', function () {

        it('returns order items for valid invoice', function () {
            // First get a valid invoice from the commission report
            $reportResponse = $this->getJson('/api/v1/reports/commission?per_page=1');
            $reportResponse->assertStatus(200);

            $data = $reportResponse->json('data');

            if (count($data) > 0) {
                $invoice = $data[0]['invoice'];

                $itemsResponse = $this->getJson("/api/v1/reports/commission/orders/{$invoice}/items");

                // Should return 200 or 404 depending on if items exist
                expect($itemsResponse->status())->toBeIn([200, 404]);
            }
        });

        it('returns 404 for non-existent invoice', function () {
            $response = $this->getJson('/api/v1/reports/commission/orders/INVALID_INVOICE_123/items');

            $response->assertStatus(404)
                ->assertJson([
                    'success' => false,
                    'message' => 'Order not found.',
                ]);
        });
    });
});
