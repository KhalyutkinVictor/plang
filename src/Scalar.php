<?php

namespace Plang;

class Scalar
{

    private $val;

    public function __construct($val)
    {
        $this->val = $val;
    }

    public function get()
    {
        return $this->val;
    }

}
