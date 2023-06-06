<?php

namespace Plang;

class CompareFunc implements IFunc
{

    private Plang $plang;

    private $comparator;

    private string $fname;

    public function __construct(Plang $plang, callable $cmp, string $fname)
    {
        $this->plang = $plang;
        $this->fname = $fname;
        $this->comparator = $cmp;
    }

    public function call(IContext $ctx, array $args)
    {
        $this->plang->helpers->checkExactArgsCount(
            $args,
            2,
            $this->fname
        );
        foreach ($args as $arg) {
            if (!($arg instanceof Scalar)) {
                throw new \Exception("Argument should be scalar");
            }
        }
        $res = call_user_func($this->comparator, $args[0]->get(), $args[1]->get());
        if (gettype($res) !== "boolean") {
            throw new \Exception("Compare function return non boolean value");
        }
        return new Scalar($res);
    }

    public function isSystem(): bool
    {
        return false;
    }

    public static function greater($a, $b)
    {
        return $a > $b;
    }

    public static function less($a, $b)
    {
        return $a < $b;
    }

    public static function greaterOrEqual($a, $b)
    {
        return $a >= $b;
    }

    public static function lessOrEqual($a, $b)
    {
        return $a <= $b;
    }

}
