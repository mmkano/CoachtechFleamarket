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
        'condition_id',
        'brand_id',
    ];

    public function categoryItem()
    {
        return $this->belongsTo(CategoryItem::class);
    }

    public function condition()
    {
        return $this->belongsTo(Condition::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function soldItems()
    {
        return $this->hasMany(SoldItem::class);
    }

    public function paymentMethods()
    {
        return $this->hasMany(UserItemPaymentMethod::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
}
