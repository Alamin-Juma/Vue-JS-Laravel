<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Contracts\TopDistributorsServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * API Controller for Top Distributors Report endpoints.
 */
class TopDistributorsController extends Controller
{
    public function __construct(
        private readonly TopDistributorsServiceInterface $topDistributorsService
    ) {}

    /**
     * Get the top distributors report.
     *
     * @queryParam limit int Maximum number of distributors. Default: 200. Example: 200
     * @queryParam per_page int Number of records per page. Default: 20. Example: 10
     */
    public function index(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'limit' => ['nullable', 'integer', 'min:1', 'max:500'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
        ]);

        $limit = (int) ($validated['limit'] ?? 200);
        $perPage = (int) ($validated['per_page'] ?? 20);

        $report = $this->topDistributorsService->getTopDistributors($limit, $perPage);

        return response()->json([
            'success' => true,
            'message' => 'Top distributors report retrieved successfully.',
            ...$report,
        ]);
    }
}
