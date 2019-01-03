<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Expectation;

/**
 * Represents a falure to evaluate an expectation
 */
final class Failure implements StatusInterface
{
    /** @var string */
    private $desc;

    public function __construct(string $desc)
    {
        $this->desc = $desc;
    }

    public function getDescription(): string
    {
        return $this->desc;
    }

    public function isSuccess(): bool
    {
        return false;
    }
}
