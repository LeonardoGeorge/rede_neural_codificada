<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Twitter API Credentials
    |--------------------------------------------------------------------------
    |
    | Aqui você pode definir as credenciais da API do Twitter.
    | Estas credenciais são usadas para autenticar suas requisições à API do Twitter.
    | Certifique-se de manter estas informações seguras e não as exponha publicamente.
    |
    */

    'api_key' => env('TWITTER_API_KEY'),
    'api_secret' => env('TWITTER_API_SECRET'),
    'bearer_token' => env('TWITTER_BEARER_TOKEN'),
    'access_token' => env('TWITTER_ACCESS_TOKEN'),
    'access_token_secret' => env('TWITTER_ACCESS_TOKEN_SECRET'),

];