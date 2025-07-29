<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $fillable = [
    'name',
    'sku',
    'description',
    'category_id',
    'unit',
    'quantity',
    'location',
    'price',
    'image',
    'min_quantity'
];


   public function category(){
    return $this->belongsTo(Category::class);
   }

   public function stockMovements()
{
    return $this->hasMany(StockMovement::class);
}

}
