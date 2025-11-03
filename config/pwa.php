<?php

return [

  /*
    |--------------------------------------------------------------------------
    | Would you like the install button to appear on all pages?
      Set true/false
    |--------------------------------------------------------------------------
    */

  'install-button' => true,

  /*
    |--------------------------------------------------------------------------
    | PWA Manifest Configuration
    |--------------------------------------------------------------------------
    |  php artisan erag:update-manifest
    */

  'manifest' => [
    'name' => 'Nix Software',
    'short_name' => 'Nix',
    'background_color' => '#6777ef',
    'display' => 'fullscreen',
    'description' => 'Nix Software Solutions Pvt Ltd',
    'theme_color' => '#6777ef',
    'icons' => [
      [
        'src' => 'logo.png',
        'sizes' => '512x512',
        'type' => 'image/png',
      ],
    ],
  ],

  /*
    |--------------------------------------------------------------------------
    | Debug Configuration
    |--------------------------------------------------------------------------
    | Toggles the application's debug mode based on the environment variable
    */

  'debug' => env('APP_DEBUG', false),

  /*
    |--------------------------------------------------------------------------
    | Livewire Integration
    |--------------------------------------------------------------------------
    | Set to true if you're using Livewire in your application to enable
    | Livewire-specific PWA optimizations or features.
    */

  'livewire-app' => false,
];
