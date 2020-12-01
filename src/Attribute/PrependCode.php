<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Attribute;

use hanneskod\readmetester\Compiler\TransformationInterface;
use hanneskod\readmetester\Example\ExampleObj;
use hanneskod\readmetester\Utils\CodeBlock;

#[\Attribute(\Attribute::IS_REPEATABLE|\Attribute::TARGET_ALL)]
class PrependCode implements AttributeInterface, TransformationInterface
{
    use AttributeFactoryTrait;

    private string $line;

    public function __construct(string $line)
    {
        $this->line = $line;
    }

    public function transform(ExampleObj $example): ExampleObj
    {
        return $example->withCodeBlock(
            $example->getCodeBlock()->prepend(
                new CodeBlock($this->line)
            )
        );
    }
}