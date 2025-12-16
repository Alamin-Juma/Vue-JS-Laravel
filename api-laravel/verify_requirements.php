<?php

/**
 * Script to verify the expected commission and top distributor values
 * from the TSA requirements.
 */

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Services\Implementations\CommissionReportService;
use App\Services\Implementations\TopDistributorsService;
use App\Repositories\Eloquent\EloquentOrderRepository;
use App\Repositories\Eloquent\EloquentDistributorRepository;
use Illuminate\Support\Facades\DB;

echo "═══════════════════════════════════════════════════════════\n";
echo "  TASK 1: Commission Report Verification\n";
echo "═══════════════════════════════════════════════════════════\n\n";

$orderRepo = new EloquentOrderRepository();
$commissionService = new CommissionReportService($orderRepo);

$testCases = [
    'ABC4170' => 6.00,
    'ABC6931' => 37.20,
    'ABC23352' => 27.60,
    'ABC3010' => 0,
    'ABC19323' => 0,
];

foreach ($testCases as $invoice => $expectedCommission) {
    $filters = ['invoice' => $invoice];
    $result = $orderRepo->getCommissionReport($filters, 1);
    
    if ($result->total() > 0) {
        $order = $result->items()[0];
        
        // Calculate commission using the service
        $commissionPercentage = $commissionService->calculateCommissionPercentage(
            (int) $order->referred_distributors
        );
        
        $isEligible = ($order->purchaser_category_id == 2) && // Customer
                     ($order->referrer_category_id == 1);      // Distributor referrer
        
        $actual = $commissionService->calculateCommission(
            (float) $order->order_total,
            $commissionPercentage,
            $isEligible
        );
        
        $status = abs($actual - $expectedCommission) < 0.01 ? '✓ PASS' : '✗ FAIL';
        
        echo sprintf(
            "%s | Invoice: %s | Expected: $%.2f | Actual: $%.2f\n",
            $status,
            $invoice,
            $expectedCommission,
            $actual
        );
    } else {
        echo sprintf("✗ FAIL | Invoice: %s | Not found in database\n", $invoice);
    }
}

echo "\n═══════════════════════════════════════════════════════════\n";
echo "  TASK 2: Top Distributors Verification\n";
echo "═══════════════════════════════════════════════════════════\n\n";

$distributorRepo = new EloquentDistributorRepository();
$topDistributorsService = new TopDistributorsService($distributorRepo);

$testDistributors = [
    'Demario Purdy' => 22026.75,
    'Floy Miller' => 9645.00,
    'Loy Schamberger' => 575.00,
];

// Get top 200 distributors
$result = $distributorRepo->getTopDistributors(200);

foreach ($testDistributors as $name => $expectedSales) {
    $distributor = $result->firstWhere('distributor_name', $name);
    
    if ($distributor) {
        $actual = $distributor->total_sales;
        $status = abs($actual - $expectedSales) < 0.01 ? '✓ PASS' : '✗ FAIL';
        
        echo sprintf(
            "%s | Distributor: %-20s | Expected: $%10.2f | Actual: $%10.2f\n",
            $status,
            $name,
            $expectedSales,
            $actual
        );
    } else {
        echo sprintf("✗ FAIL | Distributor: %s | Not found in top 200\n", $name);
    }
}

echo "\n═══════════════════════════════════════════════════════════\n";
echo "  Rank Verification\n";
echo "═══════════════════════════════════════════════════════════\n\n";

$rankTests = [
    ['name' => 'Demario Purdy', 'rank' => 1],
    ['name' => 'Chaim Kuhn', 'rank' => 197],
    ['name' => 'Eliane Bogisich', 'rank' => 197],
];

// Add ranking
$rank = 1;
$previousSales = null;
$sameRankCount = 0;

foreach ($result as $index => $distributor) {
    if ($previousSales !== null && abs($distributor->total_sales - $previousSales) > 0.01) {
        $rank = $index + 1;
    }
    
    $distributor->rank = $rank;
    $previousSales = $distributor->total_sales;
}

foreach ($rankTests as $test) {
    $distributor = $result->firstWhere('distributor_name', $test['name']);
    
    if ($distributor) {
        $actualRank = $distributor->rank;
        $status = $actualRank == $test['rank'] ? '✓ PASS' : '✗ FAIL';
        
        echo sprintf(
            "%s | Distributor: %-20s | Expected Rank: #%-3d | Actual Rank: #%-3d | Sales: $%10.2f\n",
            $status,
            $test['name'],
            $test['rank'],
            $actualRank,
            $distributor->total_sales
        );
    } else {
        echo sprintf("✗ FAIL | Distributor: %s | Not found in top 200\n", $test['name']);
    }
}

echo "\n═══════════════════════════════════════════════════════════\n";
echo "  Verification Complete\n";
echo "═══════════════════════════════════════════════════════════\n";
