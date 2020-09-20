<?php

namespace ClosureStackTests\Feature;

use ClosureStack\ClosureStack;
use ClosureStack\Exceptions\NoValueException;
use ClosureStackTests\TestCase;

class ClosureStackTest extends TestCase {

  public function setUp() : void
  {
    parent::setUp();
    $this->closureStack =new ClosureStack();
  }

  /**
   * @test
   **/
  public function can_call_from_closure_stack()
  {
    $ignoredValue = 5;
    $called = false;
    $closure = function() use (&$called) {
      $called = true;
    };
    $this->closureStack->callWith($closure, $ignoredValue);

    $this->assertTrue($called, 'Closure was not called.');
  }

  /**
   * @test
   **/
  public function closure_stack_value_is_called_value_during_execution()
  {
    $closure = function() {
      $this->assertEquals( 5, $this->closureStack->currentValue() );
    };
    $this->closureStack->callWith($closure, 5);
    
  }

  /**
   * @test
   **/
  public function closure_stack_value_is_empty_before_execution()
  {
    $this->expectException(NoValueException::class);
    $this->assertNull( $this->closureStack->currentValue() );
  }

  /**
   * @test
   **/
  public function closure_stack_value_is_empty_after_execution()
  {
    $this->expectException(NoValueException::class);

    $this->closureStack->callWith(function() {}, 5);

    $this->assertNull( $this->closureStack->currentValue() );
  }
}
