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
    ['print', ['inc 3']]
]);
