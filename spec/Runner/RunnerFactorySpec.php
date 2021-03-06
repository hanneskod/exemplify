<?php

declare(strict_types=1);

namespace spec\hanneskod\readmetester\Runner;

use hanneskod\readmetester\Runner\RunnerFactory;
use hanneskod\readmetester\Runner\RunnerInterface;
use hanneskod\readmetester\Runner\ProcessRunner;
use hanneskod\readmetester\Exception\InstantiatorException;
use hanneskod\readmetester\Exception\InvalidRunnerException;
use hanneskod\readmetester\Config\Configs;
use hanneskod\readmetester\Utils\Instantiator;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class RunnerFactorySpec extends ObjectBehavior
{
    function let(Instantiator $instantiator)
    {
        $this->beConstructedWith($instantiator);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(RunnerFactory::class);
    }

    function it_creates_from_id($instantiator, RunnerInterface $runner)
    {
        $instantiator->getNewObject(ProcessRunner::class)
            ->willReturn($runner)
            ->shouldBeCalled();

        $this->createRunner(Configs::RUNNER_ID_PROCESS)
            ->shouldReturn($runner);
    }

    function it_creates_from_classname($instantiator, RunnerInterface $runner)
    {
        $instantiator->getNewObject('compiler-factory-classname')
            ->willReturn($runner)
            ->shouldBeCalled();

        $this->createRunner('compiler-factory-classname')
            ->shouldReturn($runner);
    }

    function it_throws_on_invalid_id($instantiator)
    {
        $instantiator->getNewObject('does-not-exist')
            ->willThrow(new InstantiatorException())
            ->shouldBeCalled();

        $this->shouldThrow(InvalidRunnerException::class)->duringCreateRunner('does-not-exist');
    }

    function it_throws_on_invalid_class($instantiator)
    {
        $instantiator->getNewObject('not-a-runner-classname')
            ->willReturn((object)[])
            ->shouldBeCalled();

        $this->shouldThrow(InvalidRunnerException::class)->duringCreateRunner('not-a-runner-classname');
    }
}
