<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Console;

use hanneskod\readmetester\ListenerInterface;
use hanneskod\readmetester\Example\ExampleObj;
use hanneskod\readmetester\Expectation\StatusInterface;

/**
 * Capture exit status
 */
class ExitStatusListener implements ListenerInterface
{
    /**
     * @var int
     */
    private $exitStatus = 0;

    public function onExample(ExampleObj $example): void
    {
    }

    public function onIgnoredExample(ExampleObj $example): void
    {
    }

    public function onExpectation(StatusInterface $status): void
    {
        if (!$status->isSuccess()) {
            $this->exitStatus = 1;
        }
    }

    public function getStatusCode(): int
    {
        return $this->exitStatus;
    }
}
