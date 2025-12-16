<?php

declare(strict_types=1);

use App\Enums\CommissionTier;

describe('CommissionTier Enum', function () {
    
    describe('getPercentage', function () {
        
        it('returns 5% for 0-4 distributors', function () {
            expect(CommissionTier::getPercentage(0))->toBe(5);
            expect(CommissionTier::getPercentage(1))->toBe(5);
            expect(CommissionTier::getPercentage(4))->toBe(5);
        });

        it('returns 10% for 5-10 distributors', function () {
            expect(CommissionTier::getPercentage(5))->toBe(10);
            expect(CommissionTier::getPercentage(8))->toBe(10);
            expect(CommissionTier::getPercentage(10))->toBe(10);
        });

        it('returns 15% for 11-20 distributors', function () {
            expect(CommissionTier::getPercentage(11))->toBe(15);
            expect(CommissionTier::getPercentage(15))->toBe(15);
            expect(CommissionTier::getPercentage(20))->toBe(15);
        });

        it('returns 20% for 21-29 distributors', function () {
            expect(CommissionTier::getPercentage(21))->toBe(20);
            expect(CommissionTier::getPercentage(25))->toBe(20);
            expect(CommissionTier::getPercentage(29))->toBe(20);
        });

        it('returns 30% for 30+ distributors', function () {
            expect(CommissionTier::getPercentage(30))->toBe(30);
            expect(CommissionTier::getPercentage(50))->toBe(30);
            expect(CommissionTier::getPercentage(100))->toBe(30);
        });
    });

    describe('enum values', function () {
        
        it('has correct tier values', function () {
            expect(CommissionTier::TIER_1->value)->toBe(5);
            expect(CommissionTier::TIER_2->value)->toBe(10);
            expect(CommissionTier::TIER_3->value)->toBe(15);
            expect(CommissionTier::TIER_4->value)->toBe(20);
            expect(CommissionTier::TIER_5->value)->toBe(30);
        });

        it('has descriptive labels', function () {
            expect(CommissionTier::TIER_1->label())->toContain('0-4');
            expect(CommissionTier::TIER_2->label())->toContain('5-10');
            expect(CommissionTier::TIER_3->label())->toContain('11-20');
            expect(CommissionTier::TIER_4->label())->toContain('21-29');
            expect(CommissionTier::TIER_5->label())->toContain('30+');
        });
    });
});
