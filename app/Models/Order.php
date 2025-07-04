<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\OrderItem;
use App\Models\Item;

class Order extends Model
{
    use HasFactory;
    protected $table = 'orders';


    protected $fillable = [
        'total_price',
    ];

 
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function items()
    {
        return $this->belongsToMany(Item::class, 'order_items')
                    ->withPivot('quantity')
                    ->withTimestamps();
    }
}
