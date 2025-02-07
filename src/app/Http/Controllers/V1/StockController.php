<?php

namespace App\Http\Controllers\V1;

use App\Exceptions\StockNotCreatedException;
use Exception;
use App\Actions\{GetStockAction, SyncStockAction};
use App\Http\Controllers\Controller;
use App\Http\Requests\CheckAvailabilityRequest;
use App\Http\Requests\SyncStockRequest;
use App\Http\Resources\StockResource;
use App\Services\ProductStockService;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

#[OA\Tag(name: "Stock", description: "API endpoints related to stock operations")]
class StockController extends Controller
{
    public function __construct(
        protected ProductStockService $productStockService
    ) {}

    /**
     * @throws StockNotCreatedException
     */
    #[OA\Post(
        path: "/api/v1/stocks/sync",
        summary: "Synchronize stock levels",
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["product_id", "quantity"],
                properties: [
                    new OA\Property(property: "product_id", description: "Product ID", type: "integer", example: 1),
                    new OA\Property(property: "quantity", description: "Product stock quantity", type: "integer", example: 101),
                ]
            )
        ),
        tags: ["Stock"],
        responses: [
            new OA\Response(
                response: 200,
                description: "Stock successfully synchronized",
                content: new OA\JsonContent(ref: "#/components/schemas/StockResource")
            ),
            new OA\Response(response: 400, description: "Invalid data"),
            new OA\Response(response: 500, description: "Stock could not be created"),
        ]
    )]
    public function sync(SyncStockRequest $request, SyncStockAction $action): JsonResponse
    {
        return $this->successResponse('Success', StockResource::make($action->execute($request->payload())));
    }

    #[OA\Get(
        path: "/api/v1/stocks/{productId}",
        summary: "Retrieve stock quantity for a specific product",
        tags: ["Stock"],
        parameters: [
            new OA\Parameter(
                name: "productId",
                description: "Product ID",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "integer")
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Successfully retrieved",
                content: new OA\JsonContent(ref: "#/components/schemas/StockResource")
            ),
            new OA\Response(response: 404, description: "Product not found"),
        ]
    )]
    public function getStock(int $productId, GetStockAction $action): JsonResponse
    {
        return $this->successResponse('Success', StockResource::make($action->execute($productId)));
    }

    /**
     * @throws Exception
     */
    #[OA\Post(
        path: "/api/v1/stocks/check-availability",
        summary: "Check stock availability for products",
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["products"],
                properties: [
                    new OA\Property(
                        property: "products",
                        type: "array",
                        items: new OA\Items(
                            properties: [
                                new OA\Property(property: "product_id", description: "Product ID", type: "integer", example: 101),
                                new OA\Property(property: "quantity", description: "Requested quantity", type: "integer", example: 3),
                            ]
                        )
                    )
                ]
            )
        ),
        tags: ["Stock"],
        responses: [
            new OA\Response(
                response: 200,
                description: "Stock availability retrieved successfully",
                content: new OA\JsonContent(type: "array", items: new OA\Items(ref: "#/components/schemas/StockResource"))
            ),
            new OA\Response(response: 400, description: "Invalid data"),
            new OA\Response(response: 404, description: "Product not found"),
        ]
    )]
    public function checkAvailability(CheckAvailabilityRequest $request): JsonResponse
    {
        return $this->successResponse('Success', StockResource::collection($this->productStockService->checkAvailability($request->payload())));
    }
}
