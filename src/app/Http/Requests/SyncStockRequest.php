<?php

namespace App\Http\Requests;

use App\Data\ProductStockDTO;
use Illuminate\Foundation\Http\FormRequest;

class SyncStockRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_id' => 'required|integer',
            'quantity' => 'required|integer'
        ];
    }

    public function payload(): ProductStockDTO
    {
        return  ProductStockDTO::from($this->validated());
    }

}
