<?php

namespace Plang\functions\math;

use Plang\IContext;
use Plang\IFunc;
use Plang\Plang;
use Plang\Scalar;

class MathFunc implements IFunc
{

    private Plang $plang;

    private $fn;

    private string $fname;

    public function __construct(Plang $plang, callable $fn, string $fname)
    {
        $this->plang = $plang;
        $this->fn = $fn;
        $this->fname = $fname;
    }

    public function call(IContext $ctx, array $args)
    {
        if (empty($args)) {
            throw new \Exception("Function {$this->fname} needs at least one argument");
        }
        $this->plang->helpers->checkIfArgumentsIsScalar($args, $this->fname);
        $a = [];
        foreach ($args as $arg) {
            $a[] = $arg->get();
        }
        return new Scalar(call_user_func($this->fn, ...$a));
    }

    public function isSystem(): bool
    {
        return false;
    }

    public static function plus(...$args)
    {
        $s = 0;
        foreach ($args as $arg) {
            $s += $arg;
        }
        return $s;
    }

    public static function minus(...$args)
    {
        if (count($args) === 1) {
            return -$args[0];
        }
        $s = $args[0];
        for ($i = 1; $i < count($args); $i++) {
            $s -= $args[$i];
        }
        return $s;
    }

    public static function div(...$args)
    {
        $s = $args[0];
        for ($i = 1; $i < count($args); $i++) {
            $s /= $args[$i];
        }
        return $s;
    }

    public static function mult(...$args)
    {
        $s = $args[0];
        for ($i = 1; $i < count($args); $i++) {
            $s *= $args[$i];
        }
        return $s;
    }

    public static function mod(...$args)
    {
        $s = $args[0];
        for ($i = 1; $i < count($args); $i++) {
            $s %= $args[$i];
        }
        return $s;
    }

}
