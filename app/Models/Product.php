<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    protected $table = 'products';

    protected $fillable = ['id', 'name', 'description', 'price', 'status', 'type'];

    public function quotes()
    {
        return $this->belongsToMany(Quote::class, 'quotes_products');
    }
}
