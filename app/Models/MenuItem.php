<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'photo',
        'name',
        'description',
        'category_id',
        'price',
    ];

    /**
     * Relationship dengan Category
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
