<?php

namespace Plang;

class Context implements IContext
{

    private array $ctx = [];

    private ?IContext $parentCtx;

    public function __construct(array $ctx, ?IContext $parentCtx = null)
    {
        $this->ctx = $ctx;
        $this->parentCtx = $parentCtx;
    }

    public function get(string $name): mixed
    {
        if (array_key_exists($name, $this->ctx)) {
            return $this->ctx[$name];
        }
        if ($this->parentCtx) {
            return $this->parentCtx->get($name);
        }
        // TODO exception
        throw new \Exception("{$name} does not exists in this scope");
    }

    public function add(string $name, mixed $val): void
    {
        $this->ctx[$name] = $val;
    }

    public function has(string $name): bool
    {
        if (array_key_exists($name, $this->ctx)) {
            return true;
        }
        if (!$this->parentCtx) {
            return false;
        }
        return $this->parentCtx->has($name);
    }

}
