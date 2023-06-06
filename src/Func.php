<?php

namespace Plang;

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
        $this->args = $args;
        $this->program = $program;
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
                $this->callContext->add($this->args[$k], $args[$k]);
            } else {
                $this->callContext->add($this->args[$k], new Scalar(null));
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
        $this->callContext = $ctx;
//        if (count($this->args) !== count($args)) {
//            $fnArgsCnt = count($this->args);
//            $factArgsCnt = count($args);
//            throw new \Exception("Function has {$fnArgsCnt} arguments, but receive {$factArgsCnt}");
//        }
        $this->associateArgs($args);
        return $this->exec();
    }

    public function isSystem(): bool
    {
        return false;
    }

}
