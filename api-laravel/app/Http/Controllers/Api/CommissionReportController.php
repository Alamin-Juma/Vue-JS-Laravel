<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Contracts\CommissionReportServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * API Controller for Commission Report endpoints.
 */
class CommissionReportController extends Controller
{
    public function __construct(
        private readonly CommissionReportServiceInterface $commissionReportService
    ) {}

    /**
     * Get the commission report with optional filters.
     *
     * @queryParam distributor string Search by distributor ID, first name, or last name. Example: John
     * @queryParam date_from string Filter orders from this date. Example: 2020-01-01
     * @queryParam date_to string Filter orders to this date. Example: 2020-12-31
     * @queryParam invoice string Search by invoice number. Example: ABC123
     * @queryParam per_page int Number of records per page. Default: 15. Example: 20
     */
    public function index(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'distributor' => ['nullable', 'string', 'max:255'],
            'date_from' => ['nullable', 'date', 'date_format:Y-m-d'],
            'date_to' => ['nullable', 'date', 'date_format:Y-m-d', 'after_or_equal:date_from'],
            'invoice' => ['nullable', 'string', 'max:50'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
        ]);

        $report = $this->commissionReportService->getReport($validated);

        return response()->json([
            'success' => true,
            'message' => 'Commission report retrieved successfully.',
            ...$report,
        ]);
    }

    /**
     * Get order items for a specific invoice.
     *
     * @urlParam invoice string required The invoice number. Example: ABC100
     */
    public function orderItems(string $invoice): JsonResponse
    {
        $items = $this->commissionReportService->getOrderItems($invoice);

        if ($items->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found.',
                'data' => [],
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Order items retrieved successfully.',
            'data' => [
                'invoice' => $invoice,
                'items' => $items->toArray(),
            ],
        ]);
    }
}
