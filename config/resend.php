<?php

return [

    /*
    |--------------------------------------------------------------------------
    | API Key
    |--------------------------------------------------------------------------
    |
    | Create (or find) your API key at https://resend.com/api-keys. It is sent
    | as a Bearer token on every request.
    |
    */
    'api_key' => env('RESEND_API_KEY', ''),

    /*
    |--------------------------------------------------------------------------
    | Base URL
    |--------------------------------------------------------------------------
    |
    | Only change this to point at a proxy or a mock server.
    |
    */
    'base_url' => env('RESEND_BASE_URL', 'https://api.resend.com'),

];
