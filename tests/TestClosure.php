<?php

namespace ClosureStackTests;

class TestClosure {
  /**
   * @var bool
   **/
  private $called = false;

  public function __invoke()
  {
    $this->called = true;
  }

  public function assertWasCalled($testCase)
  {
    $testCase->assertEquals(true, $this->called, 'TestClosure was not called.');
  }
}
