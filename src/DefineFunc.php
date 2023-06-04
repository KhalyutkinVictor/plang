<?php

namespace Plang;

class DefineFunc implements IFunc
{

    private Plang $plang;

    public function __construct(Plang $plang)
    {
        $this->plang = $plang;
    }

    public function call(IContext $ctx, array $args)
    {
        $name = array_shift($args);
        $value = $args[0];
        if (gettype($name) !== 'string') {
            throw new \Exception("Function define expect first argument to be string");
        }
        if (count($args) > 1) {
            throw new \Exception("Function define expect exactly 2 arguments");
        }
        if (gettype($value) === 'string') {
            $value = $ctx->get($value);
        }
        if (gettype($value) === 'array') {
            $value = $this->plang->processList($value, $ctx);
        }
        if ($value instanceof Scalar || $value instanceof IFunc) {
            $ctx->add($name, $value);
            return $value;
        }
        throw new \Exception("Value is not of scalar type");
    }

    public function isSystem(): bool
    {
        return true;
    }


}
