<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\OrderItem;
use App\Models\Order;

class Item extends Model
{
    use HasFactory;


    protected $table = 'items';


    protected $fillable = [
        'name',
        'description',
        'price',
        'image_url',
    ];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }


    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_items')
                    ->withPivot('quantity')
                    ->withTimestamps();
    }
}