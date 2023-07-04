<?php

namespace Plang\package;

use Plang\functions\logical\CompareFunc;
use Plang\functions\logical\EqualsFunc;
use Plang\functions\logical\NotFunc;
use Plang\Plang;
use Plang\Scalar;

class LogicalPackage implements IPackage
{
    /**
     * @inheritDoc
     */
    public function addTo(Plang $plang): void
    {
        $ctx = $plang->getContext();
        $ctx->add('=', new EqualsFunc($plang));
        $ctx->add('>', new CompareFunc($plang, [CompareFunc::class, 'greater'], '>'));
        $ctx->add('>=', new CompareFunc($plang, [CompareFunc::class, 'greaterOrEqual'], '>='));
        $ctx->add('<', new CompareFunc($plang, [CompareFunc::class, 'less'], '<'));
        $ctx->add('<=', new CompareFunc($plang, [CompareFunc::class, 'lessOrEqual'], '<='));
        $ctx->add('and', new CompareFunc($plang, [CompareFunc::class, 'and'], 'and'));
        $ctx->add('or', new CompareFunc($plang, [CompareFunc::class, 'or'], 'or'));
        $ctx->add('not', new NotFunc($plang));

        $ctx->add('true', new Scalar(true));
        $ctx->add('false', new Scalar(false));
    }


}
