<?php

namespace Plang\package;

use Plang\functions\array\ArrayGetFunc;
use Plang\functions\array\ArrayHasFunc;
use Plang\functions\array\ArraySetFunc;
use Plang\Plang;

class ArrayPackage implements IPackage
{
    /**
     * @inheritDoc
     */
    public function addTo(Plang $plang): void
    {
        $ctx = $plang->getContext();
        $ctx->add('arr-get', new ArrayGetFunc($plang));
        $ctx->add('arr-has', new ArrayHasFunc($plang));
        $ctx->add('arr-set', new ArraySetFunc($plang));
    }


}
