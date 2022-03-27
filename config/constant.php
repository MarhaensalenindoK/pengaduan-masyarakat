<?php

use App\Models\User;

return [
    'user' => [
        'roles' => [
            User::ADMIN,
            User::PETUGAS,
            User::MASYARAKAT,
        ],
    ],

    'pengaduan' => [
        'status' => [
            'done',
            'inprogress',
            'todo'
        ]
    ],
];
