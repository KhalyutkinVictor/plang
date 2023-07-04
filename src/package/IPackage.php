<?php

namespace Plang\package;

use Plang\IFunc;
use Plang\Plang;
use Plang\Scalar;

interface IPackage
{

    /**
     * @param Plang $plang
     * @return void
     */
    public function addTo(Plang $plang): void;

}
