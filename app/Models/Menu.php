<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $table = 'menus';

    protected $fillable = [
        'name',
        'slug',
        'price',
        'description',
        'is_available',
        'image',
        'stock',
        'category_id',
        'is_best_seller',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function pesanan_detail()
    {
        return $this->hasMany(PesananDetail::class, 'menu_id', 'id');
    }
}
