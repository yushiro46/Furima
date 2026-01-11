<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'image', 'brand', 'price', 'description', 'condition_id', 'user_id'];

    public function condition()
    {
        return $this->belongsTo(Condition::class);
    }
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'item_category');
    }

    public function likes()
    {
        return $this->hasMany(LIke::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    public function buyers()
    {
        return $this->belongsToMany(User::class, 'purchases');
    }

    public function isSold(): bool
    {
        return $this->purchases()->exists();
    }
}
