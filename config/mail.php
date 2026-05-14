<?php

return [
    'driver' => env('MAIL_MAILER', 'log'),
    'from' => [
        'address' => env('MAIL_FROM_ADDRESS', 'noreply@hoclieu.vn'),
        'name' => env('MAIL_FROM_NAME', 'HocLieuTieuHoc'),
    ],
];
