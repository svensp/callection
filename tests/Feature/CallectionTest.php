<?php

namespace CallectionTests\Feature;

use Callection\Callection;
use Callection\Exceptions\NoValueException;
use CallectionTests\TestCase;
use CallectionTests\TestClosure;
use stdClass;

class CallectionTest extends TestCase
{

  /**
   * @var Callection
   **/
    private $callection;

    public function setUp() : void
    {
        parent::setUp();
        $this->callection = new callection();
    }

  /**
   * @test
   **/
    public function can_call_from_closure_stack()
    {
        $testClosure = new TestClosure;
        $this->callection->callWith($testClosure, 5);

        $testClosure->assertWasCalled($this);
    }

  /**
   * @test
   **/
    public function closure_stack_value_is_called_value_during_execution()
    {
        $closure = function () {
            $this->assertEquals(5, $this->callection->current());
        };
        $this->callection->callWith($closure, 5);
    }

  /**
   * @test
   **/
    public function closure_stack_value_is_empty_before_execution()
    {
        $this->expectException(NoValueException::class);
        $this->assertNull($this->callection->current());
    }

  /**
   * @test
   **/
    public function closure_stack_value_is_empty_after_execution()
    {
        $this->expectException(NoValueException::class);

        $this->callWithAnyValue();

        $this->assertNull($this->callection->current());
    }

  /**
   * @test
   **/
    public function stacked_calls_always_have_correct_current_value()
    {
        $innerClosure = function () {
            $this->assertEquals(10, $this->callection->current());
        };
        $outerClosure = function () use ($innerClosure) {
            $this->assertEquals(5, $this->callection->current());

            $this->callection->callWith($innerClosure, 10);

            $this->assertEquals(5, $this->callection->current());
        };

        $this->callection->callWith($outerClosure, 5);
    }

  /**
   * @test
   **/
    public function stores_values_by_index_by_default()
    {
        $this->callWithValue(5);
        $this->callWithValue(10);

        $this->assertStackValueIs(5, 0);
        $this->assertStackValueIs(10, 1);
    }

  /**
   * @test
   **/
    public function can_store_by_custom_name()
    {
        $this->callection->setNameMapper(function (stdClass $value) {
            return $value->name;
        });

        $first = $this->stdClassWithName('first');
        $this->callWithValue($first);
        $second = $this->stdClassWithName('second');
        $this->callWithValue($second);

        $this->assertStackValueIs($first, 'first');
        $this->assertStackValueIs($second, 'second');
    }

    private function stdClassWithName($name)
    {
        $instance = new stdClass;
        $instance->name = $name;
        return $instance;
    }

    private function callWithValue($value)
    {
        $this->callection->callWith(function () {
        }, $value);
    }

    private function callWithAnyValue()
    {
        $this->callection->callWith(function () {
        }, 5);
    }

    private function assertStackValueIs($value, $name)
    {
        $this->assertEquals($value, $this->callection->get($name));
    }
}
