<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'address',
        'phone',
        'email',
        'image',
        'status',
        'rating'
    ];

    protected $casts = [

        'rating' => 'decimal:1'
    ];

    public function menus()
    {
        return $this->hasMany(Menu::class);
    }

    /**
     * Get the users that belong to the restaurant.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

} 