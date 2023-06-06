<?php

namespace Plang;

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
        foreach ($args as $arg) {
            if (!($arg instanceof Scalar)) {
                throw new \Exception("Argument is not scalar");
            }
        }
        $sum = $args[0]->get();
        for ($i = 1; $i < count($args); $i++) {
            $sum = call_user_func($this->fn, $sum, $args[$i]->get());
        }
        return new Scalar($sum);
    }

    public function isSystem(): bool
    {
        return false;
    }

    public static function plus($a, $b)
    {
        return $a + $b;
    }

    public static function minus($a, $b)
    {
        return $a - $b;
    }

    public static function div($a, $b)
    {
        return $a / $b;
    }

    public static function mult($a, $b)
    {
        return $a * $b;
    }

    public static function mod($a, $b)
    {
        return $a % $b;
    }

}
