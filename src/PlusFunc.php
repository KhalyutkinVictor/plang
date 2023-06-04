<?php

namespace Plang;

class PlusFunc implements IFunc
{

    private Plang $plang;

    public function __construct(Plang $plang)
    {
        $this->plang = $plang;
    }

    public function call(IContext $ctx, array $args)
    {
        $sum = 0;
        foreach ($args as $arg) {
            if (!($arg instanceof Scalar)) {
                throw new \Exception("Argument should be scalar");
            }
            $sum += $arg->get();
        }
        return new Scalar($sum);
    }

    public function isSystem(): bool
    {
        return false;
    }

}
