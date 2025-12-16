<?php

declare(strict_types=1);

use App\Enums\UserType;

describe('UserType Enum', function () {
    
    it('has Customer type', function () {
        expect(UserType::CUSTOMER->value)->toBe('Customer');
    });

    it('has Distributor type', function () {
        expect(UserType::DISTRIBUTOR->value)->toBe('Distributor');
    });

    it('correctly identifies distributor', function () {
        expect(UserType::DISTRIBUTOR->isDistributor())->toBeTrue();
        expect(UserType::CUSTOMER->isDistributor())->toBeFalse();
    });

    it('correctly identifies customer', function () {
        expect(UserType::CUSTOMER->isCustomer())->toBeTrue();
        expect(UserType::DISTRIBUTOR->isCustomer())->toBeFalse();
    });
});
