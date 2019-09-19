<?php

declare(strict_types=1);

namespace NorseBlue\Optionals;

use Throwable;

class SchroedingerBox
{
    /** @var mixed The cat inside the Schroedinger box. */
    private $cat;

    /** @var array<string, mixed> The method or property call chain. */
    private $chain = [];

    /** @var mixed The default value to return on error. */
    private $default;

    /**
     * Create a new instance.
     *
     * @param mixed $cat
     * @param mixed $default
     */
    public function __construct($cat, $default = null)
    {
        $this->cat = $cat;
        $this->default = $default;
    }

    /**
     * Process a call in the chain.
     *
     * @param mixed $instance
     * @param string $method
     * @param array<mixed>|null $parameters
     *
     * @return mixed
     */
    private function processCall($instance, string $method, ?array $parameters)
    {
        if ($parameters === null) {
            return $instance->{$method};
        } else {
            return $instance->{$method}(...$parameters);
        }
    }

    /**
     * Dynamically add a method call to the chain.
     *
     * @param string $method
     * @param array<mixed> $parameters
     *
     * @return self
     */
    public function __call(string $method, array $parameters): self
    {
        $this->chain[$method] = $parameters;

        return $this;
    }

    /**
     * Dynamically add a property call to the chain.
     *
     * @param string $property
     *
     * @return self
     */
    public function __get(string $property): self
    {
        $this->chain[$property] = null;

        return $this;
    }

    /**
     * Unbox the Schroedinger cat applying the call chain to it.
     *
     * @param mixed $default_override
     *
     * @return mixed
     */
    public function unbox($default_override = null)
    {
        $result = $this->cat;
        foreach ($this->chain as $method => $parameters) {
            try {
                $result = $this->processCall($result, $method, $parameters);
            } catch (Throwable $exception) {
                $result = null;
                break;
            }
        }

        return $result ?? $default_override ?? $this->default;
    }
}
