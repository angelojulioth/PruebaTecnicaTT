<?php
// config/cors.php

return [
  /*
  |--------------------------------------------------------------------------
  | Cross-Origin Resource Sharing (CORS) Configuration
  |--------------------------------------------------------------------------
  */

  'paths' => ['api/*'],

  'allowed_methods' => ['*'],

  'allowed_origins' => ['*'], // En producción, restringe a tu dominio frontend

  'allowed_origins_patterns' => [],

  'allowed_headers' => ['*'],

  'exposed_headers' => [],

  'max_age' => 0,

  'supports_credentials' => false,
];