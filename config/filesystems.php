<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => env('FILESYSTEM_DRIVER', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Default Cloud Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Many applications store files both locally and in the cloud. For this
    | reason, you may specify a default "cloud" driver here. This driver
    | will be bound as the Cloud disk implementation in the container.
    |
    */

    'cloud' => env('FILESYSTEM_CLOUD', 's3'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been setup for each driver as an example of the required options.
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
        ],

        'cambio_sim' => [
            'driver' => 'local',
            'root' => storage_path('app/actividades_tecnicas/cambio_sim'),
            'url' => env('APP_URL').'/storage/app/actividades_tecnicas/cambio_sim',
            'visibility' => 'public',
        ],

        'cambio_gps' => [
            'driver' => 'local',
            'root' => storage_path('app/actividades_tecnicas/cambio_gps'),
            'url' => env('APP_URL').'/storage/app/actividades_tecnicas/cambio_gps',
            'visibility' => 'public',
        ],

        'desinstalacion' => [
            'driver' => 'local',
            'root' => storage_path('app/actividades_tecnicas/desinstalacion'),
            'url' => env('APP_URL').'/storage/app/actividades_tecnicas/desinstalacion',
            'visibility' => 'public',
        ],

        'homologacion' => [
            'driver' => 'local',
            'root' => storage_path('app/actividades_tecnicas/homologacion'),
            'url' => env('APP_URL').'/storage/app/actividades_tecnicas/homologacion',
            'visibility' => 'public',
        ],

        'instalacion_nueva' => [
            'driver' => 'local',
            'root' => storage_path('app/actividades_tecnicas/instalacion_nueva'),
            'url' => env('APP_URL').'/storage/app/actividades_tecnicas/instalacion_nueva',
            'visibility' => 'public',
        ],

        'reinstalacion' => [
            'driver' => 'local',
            'root' => storage_path('app/actividades_tecnicas/reinstalacion'),
            'url' => env('APP_URL').'/storage/app/actividades_tecnicas/reinstalacion',
            'visibility' => 'public',
        ],

        'revision' => [
            'driver' => 'local',
            'root' => storage_path('app/actividades_tecnicas/revision'),
            'url' => env('APP_URL').'/storage/app/actividades_tecnicas/revision',
            'visibility' => 'public',
        ],

        'traslado_gps' => [
            'driver' => 'local',
            'root' => storage_path('app/actividades_tecnicas/traslado_gps'),
            'url' => env('APP_URL').'/storage/app/actividades_tecnicas/traslado_gps',
            'visibility' => 'public',
        ], 

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
        ],

    ],

];
