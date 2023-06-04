<?php

namespace Plang;

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
        return call_user_func($this->fn, ...$args);
    }

    public function isSystem(): bool
    {
        return false;
    }


}
