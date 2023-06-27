<?php

namespace Plang\functions\output;

use Plang\IContext;
use Plang\IFunc;
use Plang\Plang;

class DprintFunc implements IFunc
{

    private Plang $plang;

    public function __constrsuct(Plang $plang)
    {
        $this->plang = $plang;
    }

    public function call(IContext $ctx, array $args)
    {
        foreach ($args as $arg) {
            print_r($arg);
            echo "\n";
        }
    }

    public function isSystem(): bool
    {
        return false;
    }


}
