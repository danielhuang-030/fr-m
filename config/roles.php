<?php

// The default permissions and roles of the system
return [
    'role' => [
        'admin' => ['name' => 'admin', 'guard_name' => 'admin'],
        'manager' =>['name' => 'manager', 'guard_name' => 'admin'],
        'category' =>['name' => 'category-manager', 'guard_name' => 'admin'],
        'book' =>['name' => 'book-manager', 'guard_name' => 'admin'],
        'user' => ['name' => 'user-manager', 'guard_name' => 'admin'],
    ],
    'permission' => [
        'manager' => [
            ['name' => 'add-manager', 'guard_name' => 'admin'],
            ['name' => 'update-manager', 'guard_name' => 'admin'],
            ['name' => 'delete-manager', 'guard_name' => 'admin'],
        ],
        'category' => [
            ['name' => 'add-category', 'guard_name' => 'admin'],
            ['name' => 'update-category', 'guard_name' => 'admin'],
            ['name' => 'delete-category', 'guard_name' => 'admin'],
        ],
        'book' => [
            ['name' => 'add-book', 'guard_name' => 'admin'],
            ['name' => 'update-book', 'guard_name' => 'admin'],
            ['name' => 'delete-book', 'guard_name' => 'admin'],
        ],
        'user' => [
            ['name' => 'add-user', 'guard_name' => 'admin'],
            ['name' => 'update-user', 'guard_name' => 'admin'],
            ['name' => 'delete-user', 'guard_name' => 'admin'],
        ]
    ]
];