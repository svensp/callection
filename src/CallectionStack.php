<?php

namespace Callection;

use SplStack;
use Callection\Exceptions\NoValueException;

class CallectionStack {
  
  /**
   * @var SplStack
   **/
    private $stack;

  /**
   * @var string
   **/
    private $name = '';

    public function __construct($name)
    {
      $this->stack = new SplStack();
      $this->name = $name;
    }

    public function push($value)
    {
        $this->stack->push($value);
    }

    public function pop()
    {
        $this->stack->pop();
    }

    public function current()
    {
        if ($this->stack->isEmpty()) {
            throw new NoValueException("Tried to read value from {$this->name} while it is empty");
        }

        return $this->stack->top();
    }
}
