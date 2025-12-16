<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * Commission percentage tiers based on number of referred distributors.
 * 
 * Commission Tiers:
 * - 0-4 referred distributors: 5%
 * - 5-10 referred distributors: 10%
 * - 11-20 referred distributors: 15%
 * - 21-29 referred distributors: 20%
 * - 30+ referred distributors: 30%
 */
enum CommissionTier: int
{
    case TIER_1 = 5;   // 0-4 distributors
    case TIER_2 = 10;  // 5-10 distributors
    case TIER_3 = 15;  // 11-20 distributors
    case TIER_4 = 20;  // 21-29 distributors
    case TIER_5 = 30;  // 30+ distributors

    /**
     * Get the commission percentage based on the number of referred distributors.
     */
    public static function getPercentage(int $referredDistributors): int
    {
        return match (true) {
            $referredDistributors >= 30 => self::TIER_5->value,
            $referredDistributors >= 21 => self::TIER_4->value,
            $referredDistributors >= 11 => self::TIER_3->value,
            $referredDistributors >= 5 => self::TIER_2->value,
            default => self::TIER_1->value,
        };
    }

    /**
     * Get the tier label for display purposes.
     */
    public function label(): string
    {
        return match ($this) {
            self::TIER_1 => '0-4 Distributors (5%)',
            self::TIER_2 => '5-10 Distributors (10%)',
            self::TIER_3 => '11-20 Distributors (15%)',
            self::TIER_4 => '21-29 Distributors (20%)',
            self::TIER_5 => '30+ Distributors (30%)',
        };
    }
}
