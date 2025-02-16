<?php
return [
    'uri' => env('GENPO_URI'),
    'token' => env('GENPO_TOKEN'),
    'contact' => [
        'create' => [
            'channel_id' => env('GENPO_CREATE_CONTACT_CHANNEL_ID')
        ]
    ]
];
