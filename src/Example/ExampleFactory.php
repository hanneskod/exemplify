<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Example;

use hanneskod\readmetester\Annotations;
use hanneskod\readmetester\Expectation\ExpectationFactory;
use hanneskod\readmetester\Expectation\ExpectationInterface;
use hanneskod\readmetester\Name\AnonymousName;
use hanneskod\readmetester\Name\ExampleName;
use hanneskod\readmetester\Name\NameInterface;
use hanneskod\readmetester\Parser\Annotation;
use hanneskod\readmetester\Parser\Definition;

class ExampleFactory
{
    /** @var ExpectationFactory */
    private $expectationFactory;

    /** @var ProcessorInterface */
    private $processor;

    /** @var bool */
    private $ignoreUnknownAnnotations;

    public function __construct(
        ExpectationFactory $expectationFactory,
        ProcessorInterface $processor,
        bool $ignoreUnknownAnnotations = false
    ) {
        $this->expectationFactory = $expectationFactory;
        $this->processor = $processor;
        $this->ignoreUnknownAnnotations = $ignoreUnknownAnnotations;
    }

    /**
     * Create examples from definitions
     *
     * @return ExampleInterface[]
     */
    public function createExamples(Definition ...$defs): array
    {
        $examples = [];
        $context = null;

        foreach ($defs as $index => $def) {
            $name = new AnonymousName('');
            $code = $def->getCodeBlock();
            $expectations = [];
            $active = true;

            if ($context) {
                $code = $code->prepend($context);
            }

            foreach ($def->getAnnotations() as $annotation) {
                if ($annotation->isNamed(Annotations::ANNOTATION_IGNORE)) {
                    $active = false;
                    continue;
                }

                if ($annotation->isNamed(Annotations::ANNOTATION_EXAMPLE)) {
                    if ($annotation->getArgument()) {
                        $name = new ExampleName($annotation->getArgument(), $name->getNamespaceName());
                    }
                    continue;
                }

                if ($annotation->isNamed(Annotations::ANNOTATION_INCLUDE)) {
                    $toInclude = $this->readExample($examples, new ExampleName($annotation->getArgument(), ''));

                    if (is_null($toInclude)) {
                        throw new \RuntimeException(
                            "Example '{$annotation->getArgument()}' can not be included in {$name->getShortName()}"
                        );
                    }

                    $code = $code->prepend($toInclude->getCodeBlock());
                    continue;
                }

                if ($expectation = $this->expectationFactory->createExpectation($annotation)) {
                    if ($expectation instanceof ExpectationInterface) {
                        $expectations[] = $expectation;
                        continue;
                    }
                }

                if ($annotation->isNamed(Annotations::ANNOTATION_CONTEXT)) {
                    $context = $code;
                    continue;
                }

                if (!$this->ignoreUnknownAnnotations) {
                    throw new \RuntimeException("Unknown annotation @{$annotation->getName()}");
                }
            }

            if ($this->readExample($examples, $name)) {
                throw new \RuntimeException("Example '{$name->getShortName()}' already exists");
            }

            $examples[] = $this->processor->process(
                (new Example($name, $code, $expectations))->withActive($active)
            );
        }

        return $examples;
    }

    private function readExample(array $examples, NameInterface $name): ?ExampleInterface
    {
        foreach ($examples as $example) {
            if ($example->getName()->equals($name)) {
                return $example;
            }
        }

        return null;
    }
}
