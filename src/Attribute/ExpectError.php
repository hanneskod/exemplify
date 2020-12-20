<?php

// phpcs:disable PSR1.Files.SideEffects

declare(strict_types=1);

namespace hanneskod\readmetester\Attribute;

use hanneskod\readmetester\Compiler\TransformationInterface;
use hanneskod\readmetester\Example\ExampleObj;
use hanneskod\readmetester\Expectation\ErrorExpectation;
use hanneskod\readmetester\Utils\Regexp;

#[\Attribute(\Attribute::IS_REPEATABLE | \Attribute::TARGET_ALL)]
class ExpectError extends AbstractAttribute implements TransformationInterface
{
    private string $regexp;

    public function __construct(string $regexp)
    {
        $this->regexp = $regexp;
    }

    public function asAttribute(): string
    {
        return self::createAttribute($this->regexp);
    }

    public function transform(ExampleObj $example): ExampleObj
    {
        return $example->withExpectation(
            new ErrorExpectation(new Regexp($this->regexp))
        );
    }
}
