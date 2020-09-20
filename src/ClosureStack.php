<?php

namespace ClosureStack;

use Closure;
use ClosureStack\Exceptions\NoValueException;
use SplStack;

class ClosureStack {

  /**
   * @var SplStack
   **/
  private $valueStack;

  /**
   * @var string
   **/
  private $name = '';

  public function __construct($name = null)
  {
    $name = $name ?? '';

    $this->valueStack = new SplStack;
    $this->name = $name;
  }

  public function currentValue()
  {
    if( $this->valueStack->isEmpty() )
      throw new NoValueException("Tried to read value from {$this->name} while it is empty");
    return $this->valueStack->top();
  }

  public function callWith(Closure $closure, $with)
  {
    $this->valueStack->push($with);
    $closure($with);
    $this->valueStack->pop();
  }
}
