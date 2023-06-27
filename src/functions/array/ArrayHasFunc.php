<?php

namespace Plang\functions\array;

use Plang\IContext;
use Plang\IFunc;
use Plang\Plang;
use Plang\Scalar;

class ArrayHasFunc implements IFunc
{

    private Plang $plang;

    public function __construct(Plang $plang)
    {
        $this->plang = $plang;
    }

    public function call(IContext $ctx, array $args)
    {
        $this->plang->helpers->checkExactArgsCount($args, 2, 'arr-has');
        $this->plang->helpers->checkIfArgumentsIsScalar($args, 'arr-has');
        $arr = $args[0]->get();
        $key = $args[1]->get();
        if (gettype($arr) !== 'array') {
            $t = gettype($arr);
            throw new \Exception("Function arr-has argument should be array, {$t} given");
        }
        $ktype = gettype($key);
        if ($ktype !== 'string' && $ktype !== 'integer') {
            throw new \Exception("Key should be string or integer");
        }
        if (!array_key_exists($key, $arr)) {
            return new Scalar(false);
        }
        return new Scalar(true);
    }

    public function isSystem(): bool
    {
        return false;
    }

}
