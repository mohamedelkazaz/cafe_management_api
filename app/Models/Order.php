<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // لو الجدول اسمه "order" بالمفرد، ضيف السطر ده
    protected $table = 'orders';

    protected $fillable = [
        'total_price',
    ];

    public function orderItems()
    {
        return $this->hasMany(\App\Models\OrderItem::class);
    }
}
