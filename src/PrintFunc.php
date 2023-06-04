<?php

namespace Plang;

class PrintFunc implements IFunc
{

    private Plang $plang;

    public function __construct(Plang $plang)
    {
        $this->plang = $plang;
    }

    public function call(IContext $ctx, array $args)
    {
        foreach ($args as $arg) {
            if (gettype($arg) === 'string') {
                $arg = $ctx->get($arg);
            }
            if (gettype($arg) === 'array') {
                $arg = $this->plang->processList($arg, $ctx);
            }
            if ($arg instanceof Scalar) {
                $arg = $arg->get();
            }
            if ($arg instanceof IFunc) {
                $arg = "function";
            }
            echo $arg . "\n";
        }
        return null;
    }

    public function isSystem(): bool
    {
        return false;
    }
}
