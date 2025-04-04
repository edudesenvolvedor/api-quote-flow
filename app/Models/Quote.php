<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    /** @use HasFactory<\Database\Factories\QuoteFactory> */
    use HasFactory;

    protected $fillable = ['id', 'code', 'short_code', 'name', 'description'];

    public function products()
    {
        return $this->belongsToMany(Product::class, "quotes_products");
    }
}
