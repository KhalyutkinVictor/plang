<?php

namespace Plang;

class LambdaFunc implements IFunc
{
    private Plang $plang;

    public function __construct(Plang $plang)
    {
        $this->plang = $plang;
    }

    public function call(IContext $ctx, array $args)
    {
        if (count($args) !== 2) {
            throw new \Exception("Function lambda expect 2 arguments "
                . count($args) . " is provided");
        }
        list($argNames, $program) = $args;
        if (gettype($argNames) !== 'array') {
            throw new \Exception("Function lambda expect first argument to be list");
        }
        if (gettype($program) !== 'array') {
            throw new \Exception("Function lambda expect second argument to be list");
        }
        foreach ($argNames as $arg) {
            if (gettype($arg) !== 'string') {
                throw new \Exception("Argument name should be a string");
            }
        }
        return new Func($this->plang, $argNames, $program, $ctx);
    }

    public function isSystem(): bool
    {
        return true;
    }


}
