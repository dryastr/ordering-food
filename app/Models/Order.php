<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'code_order',
        'customer',
        'table_number',
        'pelayan_id',
        'qty',
        'menu_id',
        'note',
        'status',
    ];

    public function menuItem()
    {
        return $this->belongsTo(MenuItem::class, 'menu_id');
    }

    public function pelayan()
    {
        return $this->belongsTo(User::class, 'pelayan_id');
    }
}
