<?php

declare(strict_types=1);

use NunoMaduro\PhpInsights\Domain\Sniffs\ForbiddenSetterSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\Files\LineLengthSniff;
use SlevomatCodingStandard\Sniffs\TypeHints\ParameterTypeHintSniff;

return [

    'preset' => 'symfony',

    'ide' => 'phpstorm',


    'exclude' => [
    ],

    'add' => [],

    'remove' => [
    ],

    'config' => [
        ForbiddenSetterSniff::class => [
            'exclude' => [
                'src/Entity/',
            ],
        ],
        LineLengthSniff::class => [
            'lineLimit' => 120,
            'absoluteLineLimit' => 120,
            'ignoreComments' => true,
        ],
        ParameterTypeHintSniff::class => [
            'exclude' => [],
        ],
        ForbiddenSetterSniff::class => [
            'exclude' => [
                'src/Entity/',
            ],
        ],



    ],


    'requirements' => [
        'min-quality' => 90,
        'min-complexity' => 90,
        'min-architecture' => 90,
        'min-style' => 90,
        'disable-security-check' => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | Threads
    |--------------------------------------------------------------------------
    |
    | Here you may adjust how many threads (core) PHPInsights can use to perform
    | the analyse. This is optional, don't provide it and the tool will guess
    | the max core number available. This accept null value or integer > 0.
    |
     */

    'threads' => null,
];
