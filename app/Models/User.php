<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Http\Constants\UserRoleConstant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'restaurant_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the restaurant that the user belongs to.
     */
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function isAdmin()
    {
        return $this->role === UserRoleConstant::ADMIN;
    }

    public function isCustomer()
    {
        return $this->role === UserRoleConstant::CUSTOMER;
    }

    public function isRestaurantUser()
    {
        return $this->role === UserRoleConstant::RESTAURANT_USER;
    }

    public function shouldAccessDashboard()
    {
        return $this->isAdmin() || $this->isRestaurantUser();
    }

    public function canViewAllRestaurants()
    {
        return $this->isAdmin();
    }

    public function getRestaurantScope()
    {
        if ($this->isAdmin()) {
            return null; // Can see all restaurants
        }

        if ($this->isRestaurantUser()) {
            return $this->restaurant_id;
        }

        return null;
    }

    public function scopeForCurrentUser($query)
    {
        $user = auth()->user();

        if ($user->isAdmin()) {
            return $query; // No filtering for admin
        }

        if ($user->isRestaurantUser()) {
            return $query->where('restaurant_id', $user->restaurant_id);
        }

        return $query;
    }
}
