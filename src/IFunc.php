<?php

namespace Plang;

interface IFunc
{

    public function call(IContext $ctx, array $args);

    public function isSystem(): bool;

}
