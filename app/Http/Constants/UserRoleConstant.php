<?php

namespace App\Http\Constants;

class UserRoleConstant
{
    const ADMIN = 'admin';
    const CUSTOMER = 'customer';
    const RESTAURANT_USER = 'restaurant_user';

    const LIST = [
        self::ADMIN => [
            'key' => self::ADMIN,
            'label' => 'Admin',
        ],
        self::CUSTOMER => [
            'key' => self::CUSTOMER,
            'label' => 'Customer',
        ],
        self::RESTAURANT_USER => [
            'key' => self::RESTAURANT_USER,
            'label' => 'Restaurant User',
        ],
    ];
}
