<?php

namespace Plang;

use Plang\Scalar;

class Plang
{

    private $context;

    public Helpers $helpers;

    public function __construct(array $additionals)
    {
        $ctx = [];
        foreach ($additionals as $key => $additional) {
            if (is_callable($additional)) {
                $ctx[$key] = new ClosureFunc($this, $additional);
                continue;
            }
            if ($additional instanceof IFunc || $additional instanceof Scalar) {
                $ctx[$key] = $additional;
                continue;
            }
            throw new \Exception("Additional is not a callable or IFunc or Scalar");
        }

        $this->helpers = new Helpers($this);
        $this->context = new Context($ctx);
        $this->context->add('the', new DefineFunc($this));
        $this->context->add('fn', new LambdaFunc($this));
        $this->context->add('print', new PrintFunc($this));
        $this->context->add('+', new PlusFunc($this));
    }

    public function processList(array $list, IContext $context): mixed
    {
        $fnname = array_shift($list);
        $fn = $context->get($fnname);
        $args = $list;
        if (!($fn instanceof IFunc)) {
            throw new \Exception("{$fnname} is not a function");
        }
        if ($fn->isSystem()) {
            return $fn->call($context, $args);
        }
        $args = $this->helpers->simplify($context, $args);
        return $fn->call($context, $args);
    }

    public function execute(array $program, ?IContext $context = null)
    {
        $res = null;
        if (!$context) {
            $context = new Context([], $this->context);
        }
        foreach ($program as $statement) {
            if (gettype($statement) !== 'array') {
                throw new \Exception("Statement is not list");
            }
            $res = $this->processList($statement, $context);
        }
        return $res;
    }

}
