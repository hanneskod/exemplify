<?php

namespace hanneskod\readmetester\Runner;

use hanneskod\readmetester\Example\ExampleObj;
use hanneskod\readmetester\Utils\CodeBlock;

/**
 * Defines object that are able to execute example code
 */
interface RunnerInterface
{
    public function run(ExampleObj $example): OutcomeInterface;

    public function setBootstrap(CodeBlock $bootstrap): void;
}
