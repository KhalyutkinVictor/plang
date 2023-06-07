<?php

namespace Plang;

class Helpers
{

    private Plang $plang;

    public function __construct(Plang $plang)
    {
        $this->plang = $plang;
    }

    public function simplify(IContext $ctx, array $list): array
    {
        $res = [];
        $c = $list;
        foreach ($list as $val) {
            if (gettype($val) === 'array') {
                $val = $this->plang->processList($val, $ctx);
            }
            if (gettype($val) === 'string') {
                $val = $ctx->get($val);
            }
            if ($val instanceof Scalar || $val instanceof IFunc) {
                $res[] = $val;
                continue;
            }
            throw new \Exception("Value is not scalar " . print_r($c, 1));
        }
        return $res;
    }

    public function getValue($val, IContext $ctx)
    {
        if (gettype($val) === 'string') {
            $val = $ctx->get($val);
        }
        if (gettype($val) === 'array') {
            $val = $this->plang->processList($val, $ctx);
        }
        return $val;
    }

    public function isFirstClass(mixed $val): bool
    {
        if ($val instanceof Scalar || $val instanceof IFunc) {
            return true;
        }
        return false;
    }

    public function throwIfNotFirstClass(mixed $val, string $err)
    {
        if ($this->isFirstClass($val)) {
            return;
        }
        throw new \Exception("Value is not first class object\n" . $err);
    }

    public function checkExactArgsCount(array $args, int $count, string $fname = '')
    {
        if (count($args) !== $count) {
            throw new \Exception("Function {$fname} waits exact {$count} arguments, but receive "
                . count($args) . " arguments\n");
        }
    }

    public function checkIfArgumentsIsScalar(array $args, string $fname = '')
    {
        foreach ($args as $arg) {
            if (!($arg instanceof Scalar)) {
                throw new \Exception("Function {$fname} arguments should be scalar");
            }
        }
    }

}
