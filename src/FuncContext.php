<?php

namespace Plang;

class FuncContext implements IContext
{

    private IContext $callCtx;

    private IContext $parentCtx;

    public function __construct(IContext $callCtx, IContext $parentCtx)
    {
        $this->parentCtx = $parentCtx;
        $this->callCtx = $callCtx;
    }

    public function get(string $name): mixed
    {
        if ($this->callCtx->has($name)) {
            return $this->callCtx->get($name);
        }
        return $this->parentCtx->get($name);
    }

    public function add(string $name, mixed $val): void
    {
        $this->callCtx->add($name, $val);
    }

    public function has(string $name): bool
    {
        return $this->callCtx->has($name) || $this->parentCtx->has($name);
    }
}
