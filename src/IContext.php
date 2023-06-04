<?php

namespace Plang;

interface IContext
{

    public function get(string $name): mixed;

    public function add(string $name, mixed $val): void;

    public function has(string $name): bool;

}
