<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'feature_image',
        'price',
        'description',
        'dealer_price',
        'sub_dealer_price',
        'retailer_price',
        'freelancer_price',
        'customer_price',
        'stock_quantity',
        'sku',
        'weight',
        'dimensions',
        'is_featured',
        'is_active',
        'meta_title',
        'meta_description',
        'tags'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'dealer_price' => 'decimal:2',
        'sub_dealer_price' => 'decimal:2',
        'retailer_price' => 'decimal:2',
        'freelancer_price' => 'decimal:2',
        'customer_price' => 'decimal:2',
        'weight' => 'decimal:2',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'stock_quantity' => 'integer',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getPriceForCustomerType($customerType)
    {
        return match($customerType) {
            'dealer' => $this->dealer_price ?? $this->price,
            'sub_dealer' => $this->sub_dealer_price ?? $this->price,
            'retailer' => $this->retailer_price ?? $this->price,
            'freelancer' => $this->freelancer_price ?? $this->price,
            'end_customer' => $this->customer_price ?? $this->price,
            default => $this->price
        };
    }

    public function isInStock()
    {
        return $this->stock_quantity > 0;
    }

    public function getPriceForUser($user)
    {
        if (!$user) return $this->price;
        return $this->getPriceForCustomerType($user->customer_type);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
}
