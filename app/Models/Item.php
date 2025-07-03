<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    // لو الجدول اسمه "item" بالـ مفرد حط السطر ده
    // لو الجدول اسمه "items" بالجمع احذف السطر ده
    protected $table = 'items';

    protected $fillable = [
        'name',
        'description',
        'price',
        'image_url',
    ];
}
