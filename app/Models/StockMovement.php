<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockMovement extends Model
{
   

 protected $fillable = [
        'product_id',
        'quantity',
        'type', 
    ];
public function product()
{
    return $this->belongsTo(Product::class);
}

protected static function booted()
{
    static::created(function ($movement) {
        $product = $movement->product;
        if ($movement->type === 'entrada') {
            $product->quantity += $movement->quantity;
        } elseif ($movement->type === 'saida') {
            $product->quantity -= $movement->quantity;
        }
        $product->save();
    });
}


}
