<?php

namespace App\Http\Requests;

use App\Data\CheckAvailabilityDTO;
use App\Data\ProductStockDTO;
use Illuminate\Foundation\Http\FormRequest;

class CheckAvailabilityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'products' => 'required|array',
            'products*.product_id' => 'required|integer',
        ];
    }

    public function payload(): CheckAvailabilityDTO
    {
        return new CheckAvailabilityDTO(
            collect($this->validated()['products'])
                ->map(fn ($product) => new ProductStockDTO($product['product_id'], $product['quantity']))
        );
    }

}
