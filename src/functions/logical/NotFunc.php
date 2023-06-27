<?php

namespace Plang\functions\logical;

use Plang\IContext;
use Plang\IFunc;
use Plang\Plang;
use Plang\Scalar;

class NotFunc implements IFunc
{

    private Plang $plang;

    public function __construct(Plang $plang)
    {
        $this->plang = $plang;
    }

    public function call(IContext $ctx, array $args)
    {
        $this->plang->helpers->checkExactArgsCount($args, 1);
        $arg = $args[0];
        if ($arg instanceof IFunc) {
            return new Scalar(true);
        }
        if ($arg instanceof Scalar) {
            return new Scalar(!($arg->get()));
        }
        throw new \Exception("Argument has unexpected type");
    }

    public function isSystem(): bool
    {
        return false;
    }

}
