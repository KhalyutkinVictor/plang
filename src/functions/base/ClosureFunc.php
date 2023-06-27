<?php

namespace Plang\functions\base;

use Plang\IContext;
use Plang\IFunc;
use Plang\Plang;
use Plang\Scalar;

class ClosureFunc implements IFunc
{

    private Plang $plang;

    private $fn;

    public function __construct(Plang $plang, callable $fn)
    {
        $this->plang = $plang;
        $this->fn = $fn;
    }

    public function call(IContext $ctx, array $args)
    {
        $a = [];
        foreach ($args as $arg) {
            $a[] = $arg->get();
        }
        return new Scalar(call_user_func($this->fn, ...$a));
    }

    public function isSystem(): bool
    {
        return false;
    }


}
