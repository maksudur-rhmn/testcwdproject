<?php

return [
    'user' => [
        'model' => 'App\User',
        'foreignKey' => null,
        'ownerKey' => null,
    ],
    'broadcast' => [
        'enable' => true,
        'app_name' => 'test',
        'pusher' => [
            'app_id' => '979574',
            'app_key' => 'a839ca04c4f59447c0df',
            'app_secret' => '38c5fae604ff45232687',
            'options' => [
                'cluster' => 'ap1',
                'encrypted' => true
            ]
        ],
    ],
    'oembed' => [
        'enabled' => false,
        'url' => '',
        'key' => ''
    ]
];
