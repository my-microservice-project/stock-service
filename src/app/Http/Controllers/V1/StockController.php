<?php

namespace App\Http\Controllers\V1;

use App\Actions\{GetStockAction, SyncStockAction};
use App\Exceptions\StockNotCreatedException;
use App\Http\Controllers\Controller;
use App\Http\Requests\CheckAvailabilityRequest;
use App\Http\Requests\SyncStockRequest;
use App\Http\Resources\StockResource;
use App\Services\ProductStockService;
use Illuminate\Http\JsonResponse;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="Stock",
 *     description="API endpoints related to stock operations"
 * )
 */
class StockController extends Controller
{
    public function __construct(
        protected ProductStockService $productStockService
    ) {}

    /**
     * @OA\Post(
     *     path="/api/v1/stocks/sync",
     *     summary="Synchronize stock levels",
     *     tags={"Stock"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"product_id", "quantity"},
     *             @OA\Property(property="product_id", type="integer", example=1, description="Product ID"),
     *             @OA\Property(property="quantity", type="integer", example=101, description="Product stock quantity")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Stock successfully synchronized",
     *         @OA\JsonContent(ref="#/components/schemas/StockResource")
     *     ),
     *     @OA\Response(response=400, description="Invalid data"),
     *     @OA\Response(response=500, description="Stock could not be created")
     * )
     * @throws StockNotCreatedException
     */
    public function sync(SyncStockRequest $request, SyncStockAction $action): JsonResponse
    {
        return $this->successResponse('Success', StockResource::make($action->execute($request->payload())));
    }

    /**
     * @OA\Get(
     *     path="/api/v1/stocks/{productId}",
     *     summary="Retrieve stock quantity for a specific product",
     *     tags={"Stock"},
     *     @OA\Parameter(
     *         name="productId",
     *         in="path",
     *         required=true,
     *         description="Product ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successfully retrieved",
     *         @OA\JsonContent(ref="#/components/schemas/StockResource")
     *     ),
     *     @OA\Response(response=404, description="Product not found")
     * )
     */
    public function getStock(int $productId, GetStockAction $action): JsonResponse
    {
        return $this->successResponse('Success', StockResource::make($action->execute($productId)));
    }

    /**
     * @OA\Post(
     *     path="/api/v1/stocks/check-availability",
     *     summary="Check stock availability for products",
     *     tags={"Stock"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"products"},
     *             @OA\Property(property="products", type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="product_id", type="integer", example=101, description="Product ID"),
     *                     @OA\Property(property="quantity", type="integer", example=3, description="Requested quantity")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Stock availability retrieved successfully",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/StockResource"))
     *     ),
     *     @OA\Response(response=400, description="Invalid data"),
     *     @OA\Response(response=404, description="Product not found")
     * )
     */
    public function checkAvailability(CheckAvailabilityRequest $request): JsonResponse
    {
        return $this->successResponse('Success', StockResource::collection($this->productStockService->checkAvailability($request->payload())));
    }
}
