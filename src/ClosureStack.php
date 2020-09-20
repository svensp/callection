<?php

namespace ClosureStack;

use ClosureStack\Exceptions\NoValueException;
use SplStack;

class ClosureStack {

  /**
   * @var SplStack
   **/
  private $stack;

  /**
   * @var TestCollection
   **/
  private $collection;

  /**
   * @var string
   **/
  private $name = '';

  public function __construct($name = null)
  {
    $name = $name ?? '';

    $this->stack = new SplStack;
    $this->name = $name;
    $this->collection = new TestCollection;
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
    if( $this->stack->isEmpty() )
      throw new NoValueException("Tried to read value from {$this->name} while it is empty");

    return $this->stack->top();
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
