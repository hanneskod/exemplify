<?php

namespace hanneskod\readmetester;

use hanneskod\readmetester\Expectation\ExpectationFactory;

/**
 * Create examples from definitions created by Parser
 */
class ExampleFactory
{
    /**
     * @var ExpectationFactory
     */
    private $expectationFactory;

    public function __construct(ExpectationFactory $expectationFactory = null)
    {
        $this->expectationFactory = $expectationFactory ?: new ExpectationFactory;
    }

    /**
     * Create examples from definitions
     *
     * @param  array $defenitions Example definitions as created by Parser
     * @return Example[]
     */
    public function createExamples(array $defenitions)
    {
        $examples = [];

        foreach ($defenitions as $index => $def) {
            if ($this->shouldIgnoreExample($def['annotations'])) {
                continue;
            }

            $name = $this->readAnnotation('example', $def['annotations']) ?: (string)($index + 1);

            if (isset($examples[$name])) {
                throw new \RuntimeException("Example '$name' already exists in definition ".($index + 1));
            }

            if ($extends = $this->readAnnotation('extends', $def['annotations'])) {
                if (!isset($examples[$extends])) {
                    throw new \RuntimeException(
                        "Example '$extends' does not exist and can not be extended in definition ".($index + 1)
                    );
                }

                $def['code'] = sprintf(
                    "%s\n%s%s\n%s",
                    'ob_start();',
                    $examples[$extends]->getCodeBlock()->getCode(),
                    'ob_end_clean();',
                    $def['code']
                );
            }

            $expectations = $this->createExpectations($def['annotations']);

            if (empty($expectations)) {
                $expectations[] = $this->expectationFactory->createExpectation('expectnothing', []);
            }

            $examples[$name] = new Example(
                $name,
                new CodeBlock($def['code']),
                $expectations
            );
        }

        return $examples;
    }

    /**
     * Read the first argument from annotation $needle
     *
     * @return string
     */
    private function readAnnotation($needle, array $annotations)
    {
        foreach ($annotations as list($name, $args)) {
            if (strcasecmp($name, $needle) == 0) {
                return isset($args[0]) ? $args[0] : '';
            }
        }

        return '';
    }

    /**
     * Check if this example is marked as ignored
     *
     * @return boolean
     */
    private function shouldIgnoreExample(array $annotations)
    {
        foreach ($annotations as list($name, $args)) {
            if (strcasecmp($name, 'ignore') == 0) {
                return true;
            }
        }

        return false;
    }

    /**
     * Create expectation from definition data
     *
     * @return Expectation\ExpectationInterface[]
     */
    private function createExpectations(array $annotations)
    {
        $expectations = [];

        foreach ($annotations as list($name, $args)) {
            $expectations[] = $this->expectationFactory->createExpectation($name, $args);
        }

        return array_filter($expectations);
    }
}
