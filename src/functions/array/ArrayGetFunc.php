<?php

namespace Plang\functions\array;

use Plang\IContext;
use Plang\IFunc;
use Plang\Plang;
use Plang\Scalar;

class ArrayGetFunc implements IFunc
{

    private Plang $plang;

    public function __construct(Plang $plang)
    {
        $this->plang = $plang;
    }

    public function call(IContext $ctx, array $args)
    {
        $this->plang->helpers->checkExactArgsCount($args, 2, 'arr-get');
        $this->plang->helpers->checkIfArgumentsIsScalar($args, 'arr-get');
        $arr = $args[0]->get();
        $key = $args[1]->get();
        if (gettype($arr) !== 'array') {
            $t = gettype($arr);
            throw new \Exception("Function arr-get argument should be array, {$t} given");
        }
        $ktype = gettype($key);
        if ($ktype !== 'string' && $ktype !== 'integer') {
            throw new \Exception("Key should be string or integer");
        }
        if (!array_key_exists($key, $arr)) {
            throw new \Exception("Key {$key} does not exists in array");
        }
        if ($arr[$key] instanceof IFunc || $arr[$key] instanceof Scalar) {
            return $arr[$key];
        }
        return new Scalar($arr[$key]);
    }

    public function isSystem(): bool
    {
        return false;
    }

}
