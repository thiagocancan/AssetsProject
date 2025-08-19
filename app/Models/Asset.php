<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Asset extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'category',
        'title',
        'description',
        'file_path',
        'preview_path',
        'type',
        'format',
        'price',
        'storage_disk',
    ];

    // Relationships

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

}
