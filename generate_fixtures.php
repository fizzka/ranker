<?php

use Illuminate\Support\Str;

require 'vendor/autoload.php';

$size = $argv[1] ?? 10;

echo collect([])->pad($size, null)->map(function ($item) {
    return [
        'team' => Str::random(4),
        'scores' => rand(-10, 10),
    ];
})->toJson();
