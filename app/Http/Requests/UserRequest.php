<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $currentUser = auth()->user();

        // Define allowed roles based on current user
        $allowedRoles = ['admin', 'customer', 'restaurant_user', 'delivery_staff'];
        if ($currentUser && $currentUser->isRestaurantUser()) {
            $allowedRoles = ['restaurant_user', 'delivery_staff']; // Restaurant users can create restaurant users and delivery staff
        }

        // Restaurant ID validation rules
        $restaurantIdRules = 'nullable|exists:restaurants,id';

        // Only require restaurant_id from form if current user is admin
        // Restaurant users automatically get their own restaurant_id assigned in controller
        if ($currentUser && $currentUser->isAdmin()) {
            $restaurantIdRules .= '|required_if:role,restaurant_user,delivery_staff';
        }

        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'role' => 'required|in:' . implode(',', $allowedRoles),
            'restaurant_id' => $restaurantIdRules,
        ];

        // Handle unique email validation for updates
        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $userId = $this->route('id');
            $rules['email'] = 'required|email|unique:users,email,' . $userId;
            $rules['password'] = 'nullable|min:8'; // Password is optional for updates
        } else {
            $rules['password'] = 'required|min:8'; // Password required for creation
        }

        return $rules;
    }
}
