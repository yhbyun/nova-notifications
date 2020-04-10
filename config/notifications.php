<?php

return [
    // The Echo namespaced path to the User model
    'userModel' => 'users',
    'wsHost' => env('LARAVEL_WEBSOCKETS_HOST', 'localhost'),
    'wsPort' => env('LARAVEL_WEBSOCKETS_PORT', 6001),
    'wsPath' => env('PUSHER_APP_PATH'),
];
