<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Plang\Plang;
use Plang\Scalar;

function sclr($val) {
    return new Scalar($val);
}

$plang = new Plang([]);

$plang->execute([
    ['the', 'sum of 3', ['fn', ['x', 'y', 'z'], [
        ['+', 'x', 'y', 'z']
    ]]],
    ['print', ['sum of 3', sclr(2), sclr(3), sclr(4)]],

    ['print', ['+', sclr(5), sclr(12), sclr(22)]],
    ['print', sclr("Hello, world!!!")],

    ['the', 'closure', ['fn', ['x'], [
        ['the', 'inc x', ['fn', [], [
            ['+', 'x', sclr(1)]
        ]]],
        'inc x'
    ]]],
    ['the', 'inc 3', ['closure', sclr(3)]],
    ['print', sclr("The inc 3 is:")],
    ['print', ['inc 3']],
    ['print', sclr("The inc 2 is:")],
    ['print', [['closure', sclr(2)]]],

    ['cond', sclr(3),
        [['+', sclr(2), sclr(1)], ['print', sclr("3 = 2 + 1")]],
        [sclr(3), ['print', sclr("This never be printed")]]
    ],

    ['cond', sclr(3),
        [['+', sclr(2), sclr(2)], ['print', sclr("This never be printed")]],
        [sclr(3), ['print', ['+', sclr(100), sclr(100)]]]
    ],

    ['cond', sclr(3),
        [['+', sclr(2), sclr(2)], ['print', sclr("This never be printed")]],
        [sclr(4), ['print', sclr("This never be printed too")]],
        ['else', ['print', sclr("Else statement work :)")]]
    ],

    ['the', 'rec', ['fn', ['x'], [
        ['print', 'x'],
        ['cond', sclr(5),
            ['x', ['print', sclr("Done!!!")]],
            ['else', ['rec', ['+', 'x', sclr(1)]]]
        ]
    ]]],

    ['rec', sclr(1)]

]);
