<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'description',
        'img_url',
        'user_id',
        'category_item_id',
        'condition_id'
    ];

    public function categoryItem()
    {
        return $this->belongsTo(CategoryItem::class);
    }

    public function condition()
    {
        return $this->belongsTo(Condition::class);
    }
}
