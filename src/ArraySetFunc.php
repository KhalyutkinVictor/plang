<?php

namespace Plang;

class ArraySetFunc implements IFunc
{

    private Plang $plang;

    public function __construct(Plang $plang)
    {
        $this->plang = $plang;
    }

    public function call(IContext $ctx, array $args)
    {
        $this->plang->helpers->checkExactArgsCount($args, 3, 'arr-set');
        $this->plang->helpers->checkIfArgumentsIsScalar($args, 'arr-set');
        $arr = $args[0]->get();
        $key = $args[1]->get();
        $val = $args[2];
        if (gettype($arr) !== 'array') {
            $t = gettype($arr);
            throw new \Exception("Function arr-set argument should be array, {$t} given");
        }
        $ktype = gettype($key);
        if ($ktype !== 'string' && $ktype !== 'integer') {
            throw new \Exception("Key should be string or integer");
        }
        if ($val instanceof Scalar) {
            $arr[$key] = $val->get();
        } else {
           $arr[$key] = $val;
        }
        $args[0]->set($arr);
        if ($val instanceof IFunc || $val instanceof Scalar) {
            return $val;
        }
        return new Scalar($val);
    }

    public function isSystem(): bool
    {
        return false;
    }

}
