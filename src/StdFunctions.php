<?php

namespace Plang;

// TODO make cond, +, -, etc like static::cond, static::plus
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
