<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $product_id
 * @property int $quantity
 * @method static create(array $data)
 * @method where(string $string, int $productId)
 */

class Stock extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'quantity',
    ];

}
