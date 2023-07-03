<?php

namespace Plang\functions\base;

use Plang\Context;
use Plang\FuncContext;
use Plang\IContext;
use Plang\IFunc;
use Plang\Plang;
use Plang\Scalar;

class Func implements IFunc
{

    private IContext $context;

    private IContext $callContext;

    private array $args = [];

    private array $program = [];

    private Plang $plang;

    public function __construct(Plang $plang, array $args, array $program, IContext $parentCtx)
    {
        $this->context = $parentCtx;
        $this->plang = $plang;
        $this->initArgs($args);
        $this->program = $program;
    }

    private function initArgs($args)
    {
        $isOptional = false;
        $this->args = [];
        foreach ($args as $arg) {
            if ($arg === '&optional') {
                $isOptional = true;
                continue;
            }
            $this->args[] = [
                'name' => $arg,
                'isOptional' => $isOptional
            ];
        }
    }
 
    private function getVar($name)
    {
        if ($this->callContext->has($name)) {
            return $this->callContext->get($name);
        }
        if ($this->context->has($name)) {
            return $this->context->get($name);
        }
        throw new \Exception("Variable with name: {$name} does not exists in this scope");
    }

    private function associateArgs(array $args): void
    {
        foreach ($this->args as $k => $v) {
            if (array_key_exists($k, $args)) {
                $this->callContext->add($v['name'], $args[$k]);
            } elseif ($v['isOptional']) {
                $this->callContext->add($v['name'], new Scalar(null));
            } else {
                $fnArgsCnt = count($this->args);
                $factArgsCnt = count($args);
                throw new \Exception("Function has {$fnArgsCnt} arguments, but receive {$factArgsCnt}");
            }
        }
    }

    private function exec()
    {
        $ctx = new FuncContext($this->callContext, $this->context);
        return $this->plang->execute($this->program, $ctx);
    }

    public function call(IContext $ctx, array $args = [])
    {
        $this->callContext = new Context([], $ctx);
        $this->associateArgs($args);
        return $this->exec();
    }

    public function isSystem(): bool
    {
        return false;
    }

}
