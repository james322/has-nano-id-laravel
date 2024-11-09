<?php

return [

    'alphabet' => env('NANO_ID_ALPHABET', '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ_abcdefghijklmnopqrstuvwxyz-'),

    'size' => (int) env('NANO_ID_SIZE', 21),
];
