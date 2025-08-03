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
        $allowedRoles = ['admin', 'customer', 'restaurant_user'];
        if ($currentUser && $currentUser->isRestaurantUser()) {
            $allowedRoles = ['restaurant_user']; // Restaurant users can only create restaurant users
        }

        return [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'role' => 'required|in:' . implode(',', $allowedRoles),
            'restaurant_id' => 'nullable|exists:restaurants,id|required_if:role,restaurant_user',
        ];
    }
}
