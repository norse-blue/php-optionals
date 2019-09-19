<?php

declare(strict_types=1);

namespace NorseBlue\Optionals\Tests\Helpers;

use Exception;

class CatObject
{
    /** @var \NorseBlue\Optionals\Tests\Helpers\CatPropertyObject */
    private $prop;

    /** @var int */
    private $value;

    public function __construct($value = 0)
    {
        $this->value = $value;
        $this->prop = new CatPropertyObject($this->value);
    }

    public function __get(string $name)
    {
        if ($name === 'prop') {
            return $this->prop;
        }

        throw new Exception('Property not found');
    }

    public function double()
    {
        return $this->multiply(2);
    }

    public function getValue()
    {
        return $this->value;
    }

    public function multiply(int $num)
    {
        return new self($this->value * $num);
    }

    public function power(int $exponent)
    {
        return new self($this->value ^ $exponent);
    }

    public function sum(int $num)
    {
        return new self($this->value + $num);
    }
}
