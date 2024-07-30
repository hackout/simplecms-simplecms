<?php

return [
    'mode' => env("NICKNAME_MODE", 'name'),//Options: name,noun,nickname,custom
    'append_length' => env("NICKNAME_APPEND_LENGTH", 4), //random numerics length
    'dicts' => [
        'adjective' => env("NICKNAME_ADJECTIVE_PATH",null),
        'name' => env("NICKNAME_NAME_PATH",null),
        'noun' => env("NICKNAME_NOUN_PATH",null),
        'nickname' => env("NICKNAME_PATH",null),
        'custom' => env("NICKNAME_CUSTOM",null)
    ]
];