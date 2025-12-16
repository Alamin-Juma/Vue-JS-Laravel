<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * User types in the MLM system.
 */
enum UserType: string
{
    case CUSTOMER = 'Customer';
    case DISTRIBUTOR = 'Distributor';

    /**
     * Check if the user type is a distributor.
     */
    public function isDistributor(): bool
    {
        return $this === self::DISTRIBUTOR;
    }

    /**
     * Check if the user type is a customer.
     */
    public function isCustomer(): bool
    {
        return $this === self::CUSTOMER;
    }
}
