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
        $this->context->add('cond', new CondFunc($this));
        $this->context->add('if', new Func($this, StdFunctions::ifArgs(), StdFunctions::if(), $this->context));

        $this->context->add('+', new MathFunc($this, [MathFunc::class, 'plus'], '+'));
        $this->context->add('-', new MathFunc($this, [MathFunc::class, 'minus'], '-'));
        $this->context->add('*', new MathFunc($this, [MathFunc::class, 'mult'], '*'));
        $this->context->add('/', new MathFunc($this, [MathFunc::class, 'div'], '/'));
        $this->context->add('%', new MathFunc($this, [MathFunc::class, 'mod'], '%'));

        $this->context->add('=', new EqualsFunc($this));
        $this->context->add('>', new CompareFunc($this, [CompareFunc::class, 'greater'], '>'));
        $this->context->add('>=', new CompareFunc($this, [CompareFunc::class, 'greaterOrEqual'], '>='));
        $this->context->add('<', new CompareFunc($this, [CompareFunc::class, 'less'], '<'));
        $this->context->add('<=', new CompareFunc($this, [CompareFunc::class, 'lessOrEqual'], '<='));

    }

    public function processList(array $list, IContext $context): mixed
    {
        $fnname = array_shift($list);
        if ($fnname instanceof IFunc) {
            $fn = $fnname;
        } elseif (gettype($fnname) === 'string') {
            $fn = $context->get($fnname);
        } elseif (gettype($fnname) === 'array') {
            $fn = $this->processList($fnname, $context);
        } elseif ($fnname instanceof Scalar) {
            $fn = $fnname;
        } else {
            throw new \Exception("First argument should be a function\n"
                . print_r($list, 1));
        }
        $args = $list;
        if ($fn instanceof Scalar && empty($list)) {
            return $fn;
        }
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
            if (gettype($statement) === 'array') {
                $res = $this->processList($statement, $context);
                continue;
            }
            if (gettype($statement) === 'string') {
                $statement = $context->get($statement);
            }
            if ($statement instanceof Scalar || $statement instanceof IFunc) {
                $res = $statement;
                continue;
            }
            throw new \Exception("Unexpected statement " . print_r($statement, 1));
        }
        return $res;
    }

}
