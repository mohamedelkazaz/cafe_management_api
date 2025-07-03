<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $table = 'order_items';

    protected $fillable = [
        'order_id',
        'item_id',
        'quantity',
    ];

    // علاقة كل عنصر طلب بالطلب الرئيسي
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // علاقة كل عنصر طلب بالـ item نفسه
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
