<?php

namespace Callection;

class Callection
{

  /**
   * @var CallectionStack
   **/
    private $stack;

  /**
   * @var TestCollection
   **/
    private $collection;

    public function __construct($name = null)
    {
        $name = $name ?? '';

        $this->stack = new CallectionStack($name);
        $this->collection = new CallectionCollection;
    }

    public function callWith(callable $closure, $with)
    {
        $this->collection->push($with);
        $this->stack->push($with);
        $closure($with);
        $this->stack->pop();
    }

    public function current()
    {
      return $this->stack->current();
    }

    public function get($name)
    {
        return $this->collection->get($name);
    }

    public function setNameMapper(callable $nameMapper)
    {
        $this->collection->setValueToNameMapper($nameMapper);
    }
}
