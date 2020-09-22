<?php

namespace Callection;

class TestCollection
{

  /**
   * @var mixed[]
   **/
    private $values = [];

  /**
   * @var callable
   **/
    private $valueToNameMapper;

    public function __construct()
    {
        $this->valueToNameMapper = function () {
        };
    }

    public function setValueToNameMapper(callable $valueMapper)
    {
        $this->valueToNameMapper = $valueMapper;
    }

    public function get($name)
    {
        return $this->values[$name];
    }

    public function push($value)
    {
        $name = $this->mapValueToName($value);
        $this->rememberValueAs($value, $name);
    }

    private function mapValueToName($value)
    {
        $valueToNameMapper = $this->valueToNameMapper;
        return $valueToNameMapper($value);
    }

    private function rememberValueAs($value, $name)
    {
        if ($name === null) {
            $this->values[] = $value;
            return;
        }

        $this->values[$name] = $value;
    }
}
