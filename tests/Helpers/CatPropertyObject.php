<?php

declare(strict_types=1);

namespace NorseBlue\Optionals\Tests\Helpers;

class CatPropertyObject
{
    /** @var int */
    public $value;

    public function __construct($value = 0, CatPropertyObject $prop = null)
    {
        $this->value = $value;
    }

    public function tenfold(): self
    {
        return new self($this->value * 10);
    }
}
