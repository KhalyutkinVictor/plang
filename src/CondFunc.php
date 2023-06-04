<?php

namespace Plang;

class CondFunc implements IFunc
{

    private Plang $plang;

    public function __construct(Plang $plang)
    {
        $this->plang = $plang;
    }

    private function checkEquals($f, $s): bool
    {
        if ($f === $s) {
            return true;
        }
        if ($s instanceof Scalar && $f instanceof Scalar && $f->get() === $s->get()) {
            return true;
        }
        return false;
    }

    public function call(IContext $ctx, array $args)
    {
        $cond = array_shift($args);
        $cond = $this->plang->helpers->getValue($cond, $ctx);
        $this->plang->helpers->throwIfNotFirstClass($cond, "Condition first argument should be scalar");

        $lastIdx = count($args) - 1;
        foreach ($args as $key => $list) {
            if (count($list) !== 2) {
                throw new \Exception("Condition part must have exactly 2 elements list");
            }
            $val = $list[0];
            $res = $list[1];
            if ($key === $lastIdx && $val === 'else') {
                $res = $this->plang->helpers->getValue($res, $ctx);
                $this->plang->helpers->throwIfNotFirstClass($res, "Condition part second should be scalar");
                return $res;
            }
            $val = $this->plang->helpers->getValue($val, $ctx);
            $this->plang->helpers->throwIfNotFirstClass(
                $val,
                "Condition part first argument should be scalar"
            );
            if ($this->checkEquals($val, $cond)) {
                $res = $this->plang->helpers->getValue($res, $ctx);
                $this->plang->helpers->throwIfNotFirstClass($res, "Condition part second should be scalar");
                return $res;
            }
        }
        return new Scalar(null);
    }

    public function isSystem(): bool
    {
        return true;
    }

}
