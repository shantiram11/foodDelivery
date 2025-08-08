<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'restaurant_id',
        'order_number',
        'status',
        'payment_method',
        'payment_status',
        'esewa_transaction_uuid',
        'esewa_reference_id',
        'esewa_paid_at',
        'subtotal',
        'total_amount',
        'customer_phone',
        'delivery_staff_id'
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'esewa_paid_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function deliveryStaff()
    {
        return $this->belongsTo(User::class, 'delivery_staff_id');
    }

    public static function generateOrderNumber()
    {
        return 'ORD-' . date('YmdHis') . rand(1000, 9999);
    }
}