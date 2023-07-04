<?php

namespace Plang\package;

use Plang\functions\base\CondFunc;
use Plang\functions\base\Func;
use Plang\functions\base\LambdaFunc;
use Plang\functions\base\StdFunctions;
use Plang\functions\output\DprintFunc;
use Plang\functions\output\PrintFunc;
use Plang\Plang;
use Plang\functions\base\DefineFunc;

class StdPackage implements IPackage
{

    /**
     * @inheritDoc
     */
    public function addTo(Plang $plang): void
    {
        $ctx = $plang->getContext();
        $ctx->add('the', new DefineFunc($plang));
        $ctx->add('fn', new LambdaFunc($plang));
        $ctx->add('print', new PrintFunc($plang));
        $ctx->add('cond', new CondFunc($plang));
        $ctx->add('if', new Func($plang, StdFunctions::ifArgs(), StdFunctions::if(), $ctx));
        $ctx->add('dprint', new DprintFunc($plang));
        (new MathPackage())->addTo($plang);
        (new LogicalPackage())->addTo($plang);
        (new ArrayPackage())->addTo($plang);
    }

}
