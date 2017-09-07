<?php

return [
    'host' => env('CAS_HOST', 'cas.xjtu.edu.cn'),
    'port' => (int)env('CAS_PORT', 443),
    'context' => env('CAS_CONTEXT', ''),
];
