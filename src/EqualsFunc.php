<?php

namespace Plang;

class EqualsFunc implements IFunc
{

    private Plang $plang;

    public function __construct(Plang $plang)
    {
        $this->plang = $plang;
    }

    private function isAllScalar($args)
    {
        foreach ($args as $arg) {
            if (!($arg instanceof Scalar)) {
                return false;
            }
        }
        return true;
    }

    private function isAllFunc($args)
    {
        foreach ($args as $arg) {
            if (!($arg instanceof IFunc)) {
                return false;
            }
        }
        return true;
    }

    public function call(IContext $ctx, array $args)
    {
        if (count($args) < 2) {
            throw new \Exception("Equals function waits 2 or more arguments");
        }
        $isAllScalar = $this->isAllScalar($args);
        $isAllFunc = $this->isAllFunc($args);
        if (!$isAllFunc && !$isAllScalar) {
            throw new \Exception("Equals function bad arguments");
        }
        if ($isAllScalar) {
            $prev = $args[0];
            for ($i = 1; $i < count($args); $i++) {
                if ($prev->get() !== $args[$i]->get()) {
                    return new Scalar(false);
                }
            }
        } else {
            $prev = $args[0];
            for ($i = 1; $i < count($args); $i++) {
                if ($prev !== $args[$i]) {
                    return new Scalar(false);
                }
            }
        }
        return new Scalar(true);
    }

    public function isSystem(): bool
    {
        return false;
    }


}
