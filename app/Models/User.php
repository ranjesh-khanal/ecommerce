<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'customer_type',
        'phone',
        'company_name',
        'address',
        'city',
        'state',
        'zip_code',
        'country',
        'phone_verified',
        'email_verified',
        'verification_token',
        'documents',
        'is_approved',
        'approved_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'phone_verified' => 'boolean',
        'email_verified' => 'boolean',
        'is_approved' => 'boolean',
        'approved_at' => 'datetime',
        'documents' => 'array',
    ];

    /**
     * Get the user's customer type label.
     */
    public function getCustomerTypeLabel(): string
    {
        return match($this->customer_type) {
            'dealer' => 'Dealer',
            'sub_dealer' => 'Sub Dealer',
            'retailer' => 'Retailer',
            'freelancer' => 'Freelancer',
            'end_customer' => 'End Customer',
            default => 'Customer'
        };
    }

    /**
     * Check if user is approved.
     */
    public function isApproved(): bool
    {
        return $this->is_approved;
    }

    /**
     * Check if user is verified.
     */
    public function isVerified(): bool
    {
        return $this->email_verified && $this->phone_verified;
    }

    /**
     * Get the user's full address.
     */
    public function getFullAddress(): string
    {
        $address = $this->address;
        if ($this->city) $address .= ', ' . $this->city;
        if ($this->state) $address .= ', ' . $this->state;
        if ($this->zip_code) $address .= ' ' . $this->zip_code;
        if ($this->country) $address .= ', ' . $this->country;
        
        return $address;
    }

    /**
     * Get price for specific customer type.
     */
    public function getPriceForProduct($product)
    {
        return match($this->customer_type) {
            'dealer' => $product->dealer_price ?? $product->price,
            'sub_dealer' => $product->sub_dealer_price ?? $product->price,
            'retailer' => $product->retailer_price ?? $product->price,
            'freelancer' => $product->freelancer_price ?? $product->price,
            'end_customer' => $product->customer_price ?? $product->price,
            default => $product->price
        };
    }

    /**
     * Get all orders for the user.
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
