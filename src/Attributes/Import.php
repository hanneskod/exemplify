<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Attributes;

use hanneskod\readmetester\Compiler\TransformationInterface;
use hanneskod\readmetester\Example\ExampleInterface;
use hanneskod\readmetester\Utils\NameObj;

#<<\PhpAttribute>>
class Import implements TransformationInterface
{
    use AttributeFactoryTrait;

    private string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function transform(ExampleInterface $example): ExampleInterface
    {
        return $example->withImport(
            NameObj::fromString($this->name, $example->getName()->getNamespaceName())
        );
    }
}
