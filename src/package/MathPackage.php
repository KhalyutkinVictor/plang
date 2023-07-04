<?php

namespace Plang\package;

use Plang\functions\math\MathFunc;
use Plang\Plang;

class MathPackage implements IPackage
{

    /**
     * @inheritDoc
     */
    public function addTo(Plang $plang): void
    {
        $ctx = $plang->getContext();
        $ctx->add('+', new MathFunc($plang, [MathFunc::class, 'plus'], '+'));
        $ctx->add('-', new MathFunc($plang, [MathFunc::class, 'minus'], '-'));
        $ctx->add('*', new MathFunc($plang, [MathFunc::class, 'mult'], '*'));
        $ctx->add('/', new MathFunc($plang, [MathFunc::class, 'div'], '/'));
        $ctx->add('%', new MathFunc($plang, [MathFunc::class, 'mod'], '%'));
        $ctx->add('pow', new MathFunc($plang, [MathFunc::class, 'pow'], 'pow'));
    }

}
