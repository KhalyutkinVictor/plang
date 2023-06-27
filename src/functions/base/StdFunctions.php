<?php

namespace Plang\functions\base;

use Plang\Scalar;

class StdFunctions
{

    public static function ifArgs()
    {
        return ['a', 'thenf',  '&optional', 'elsef'];
    }

    public static function if()
    {
        return [
            ['cond', new Scalar(true),
                ['a', ['thenf']],
                ['else', ['elsef']]
            ]
        ];
    }

}
