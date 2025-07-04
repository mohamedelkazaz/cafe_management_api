<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;
use App\Models\Item;

class OrderItem extends Model
{
    use HasFactory;

    protected $table = 'order_items';

    protected $fillable = [
        'order_id',
        'item_id',
        'quantity',
    ];


    public function order()
    {
        return $this->belongsTo(Order::class);
    }


    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}