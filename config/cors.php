<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Rutas con CORS
    |--------------------------------------------------------------------------
    |
    | Aquí se listan las rutas que aceptan peticiones cross-origin.
    | Para la Iteración 1 (RF-05) necesitamos:
    |   - /login, /register, /logout
    |   - /especialidades y /especialidades/*
    |   - /medicos y /medicos/*
    |   - /horarios y /horarios/*
    |
    */

    'paths' => [
        'api/*',
        'sanctum/csrf-cookie',
        'login',
        'register',
        'logout',
        'especialidades',
        'especialidades/*',
        'medicos',
        'medicos/*',
        'horarios',
        'horarios/*',
    ],

    'allowed_methods' => ['*'],

    'allowed_origins' => [
        'http://localhost:3000',   // React (CRA / Next.js)
        'http://localhost:5173',   // Vite (Vue / React)
        'http://localhost:4200',   // Angular
        'http://127.0.0.1:3000',
        'http://127.0.0.1:5173',
        'http://127.0.0.1:4200',
    ],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 3600,

    'supports_credentials' => true,

];