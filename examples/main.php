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

    ['rec', sclr(1)],

    ['the', 'isTwo?', ['fn', ['a'], [
        ['=', 'a', sclr(2)]
    ]]],

    ['print', ['if', ['isTwo?', sclr(2)],
        sclr("2 is 2"),
        sclr("2 is not 2. What ?!?!?!")
    ]],

    ['if', ['isTwo?', sclr(3)],
        ['fn', [], [['print', sclr("3 is 2. What !?!?!??!?!?")]]],
        ['fn', [], [['print', sclr("3 is not 2")]]]
    ],

    ['if', ['>', sclr(2), sclr(1)],
        ['fn', [], [['print', sclr("2 more than 1")]]],
    ],

    ['if', ['<', sclr(2), sclr(1)],
        [sclr("By the way this code is unreachable")],
        ['fn', [], [['print', sclr("1 is not more then 2")]]]
    ],

    ['print', sclr("-------------------")],
    ['print', ['+', sclr(4), sclr(3)]],
    ['print', ['-', sclr(4), sclr(3)]],
    ['print', ['*', sclr(4), sclr(3)]],
    ['print', ['/', sclr(4), sclr(3)]],
    ['print', ['%', sclr(4), sclr(3)]],
    ['print', ['-', sclr(5)]],
    ['print', sclr("-------------------")],

    ['print', sclr("1 and null")],
    ['print', ['if', ['and', sclr(1), sclr(null)], sclr("True"), sclr("False")]],

    ['print', sclr("0 and null")],
    ['print', ['if', ['and', sclr(0), sclr(null)], sclr("True"), sclr("False")]],

    ['print', sclr("1 and true")],
    ['print', ['if', ['and', sclr(1), sclr(true)], sclr("True"), sclr("False")]],

    ['print', sclr("1 or null")],
    ['print', ['if', ['or', sclr(1), sclr(null)], sclr("True"), sclr("False")]],

    ['print', sclr("0 or null")],
    ['print', ['if', ['or', sclr(0), sclr(null)], sclr("True"), sclr("False")]],

    ['print', sclr("1 or true")],
    ['print', ['if', ['and', sclr(1), sclr(true)], sclr("True"), sclr("False")]],

    ['print', sclr("Not \"1212\"")],
    ['print', ['if', ['not', sclr("1212")], sclr("True"), sclr("False")]],

    ['print', sclr("Not 0")],
    ['print', ['if', ['not', sclr(0)], sclr("True"), sclr("False")]],

    ['print', sclr("Not false")],
    ['print', ['if', ['not', sclr(false)], sclr("True"), sclr("False")]],

    ['print', sclr("Not true")],
    ['print', ['if', ['not', sclr(true)], sclr("True"), sclr("False")]],

    ['print', sclr("-------------------")],

    ['the', 'array', sclr([])],
    ['arr-set', 'array', sclr("someKeyName"), sclr(12)],
    ['dprint', 'array'],
    ['print', ['arr-has', 'array', sclr("someKeyName")]],
    ['print', ['arr-get', 'array', sclr("someKeyName")]]


]);
