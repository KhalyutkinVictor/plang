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

}
