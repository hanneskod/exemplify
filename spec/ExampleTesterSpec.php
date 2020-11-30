<?php
declare(strict_types = 1);

namespace spec\hanneskod\readmetester;

use hanneskod\readmetester\ExampleTester;
use hanneskod\readmetester\Event;
use hanneskod\readmetester\Example\ExampleStoreInterface;
use hanneskod\readmetester\Example\ExampleObj;
use hanneskod\readmetester\Runner\OutcomeInterface;
use hanneskod\readmetester\Runner\RunnerInterface;
use hanneskod\readmetester\Runner\SkippedOutcome;
use hanneskod\readmetester\Expectation\ExpectationEvaluator;
use hanneskod\readmetester\Expectation\StatusInterface;
use hanneskod\readmetester\Utils\NameObj;
use Psr\EventDispatcher\EventDispatcherInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ExampleTesterSpec extends ObjectBehavior
{
    function let(ExpectationEvaluator $evaluator, EventDispatcherInterface $dispatcher)
    {
        $this->beConstructedWith($evaluator, $dispatcher);
    }

    function it_fires_on_test_passed(
        $evaluator,
        $dispatcher,
        ExampleStoreInterface $exampleStore,
        ExampleObj $example,
        OutcomeInterface $outcome,
        RunnerInterface $runner,
        StatusInterface $status,
        NameObj $name
    ) {
        $name->getFullName()->willReturn('');

        $example->getExpectations()->willReturn(['list-of-expectations']);
        $example->isActive()->willReturn(true);
        $example->getName()->willReturn($name);

        $runner->run($example)->willReturn($outcome);

        $status->isSuccess()->willReturn(true);
        $status->getDescription()->willReturn('');

        $evaluator->evaluate(['list-of-expectations'], $outcome)->willReturn([$status]);

        $dispatcher->dispatch(Argument::type(Event\ExampleEntered::class))->shouldBeCalled();
        $dispatcher->dispatch(Argument::type(Event\TestPassed::class))->shouldBeCalled();
        $dispatcher->dispatch(Argument::type(Event\ExampleExited::class))->shouldBeCalled();

        $exampleStore->getExamples()->willReturn([$example]);

        $this->test($exampleStore, $runner, false);
    }

    function it_fires_on_test_failed(
        $evaluator,
        $dispatcher,
        ExampleStoreInterface $exampleStore,
        ExampleObj $example,
        OutcomeInterface $outcome,
        RunnerInterface $runner,
        StatusInterface $status,
        NameObj $name
    ) {
        $name->getFullName()->willReturn('');

        $example->getExpectations()->willReturn(['list-of-expectations']);
        $example->isActive()->willReturn(true);
        $example->getName()->willReturn($name);

        $runner->run($example)->willReturn($outcome);

        $status->isSuccess()->willReturn(false);
        $status->getDescription()->willReturn('');

        $evaluator->evaluate(['list-of-expectations'], $outcome)->willReturn([$status]);

        $dispatcher->dispatch(Argument::type(Event\ExampleEntered::class))->shouldBeCalled();
        $dispatcher->dispatch(Argument::type(Event\TestFailed::class))->shouldBeCalled();
        $dispatcher->dispatch(Argument::type(Event\ExampleExited::class))->shouldBeCalled();

        $exampleStore->getExamples()->willReturn([$example]);

        $this->test($exampleStore, $runner, false);
    }

    function it_can_abort_after_failed_test(
        $evaluator,
        $dispatcher,
        ExampleStoreInterface $exampleStore,
        ExampleObj $example,
        OutcomeInterface $outcome,
        RunnerInterface $runner,
        StatusInterface $status,
        NameObj $name
    ) {
        $name->getFullName()->willReturn('');

        $example->getExpectations()->willReturn(['list-of-expectations']);
        $example->isActive()->willReturn(true);
        $example->getName()->willReturn($name);

        $runner->run($example)->willReturn($outcome);

        $status->isSuccess()->willReturn(false);
        $status->getDescription()->willReturn('');

        $evaluator->evaluate(['list-of-expectations'], $outcome)->willReturn([$status]);

        $dispatcher->dispatch(Argument::type(Event\ExampleEntered::class))->shouldBeCalled();
        $dispatcher->dispatch(Argument::type(Event\TestFailed::class))->shouldBeCalled();
        $dispatcher->dispatch(Argument::type(Event\TestingAborted::class))->shouldBeCalled();

        $exampleStore->getExamples()->willReturn([$example]);

        $this->test($exampleStore, $runner, true);
    }

    function it_ignores_examples(
        $evaluator,
        $dispatcher,
        ExampleStoreInterface $exampleStore,
        ExampleObj $example,
        RunnerInterface $runner,
        NameObj $name
    ) {
        $name->getFullName()->willReturn('');

        $example->isActive()->willReturn(false);
        $example->getName()->willReturn($name);

        $dispatcher->dispatch(Argument::type(Event\ExampleIgnored::class))->shouldBeCalled();

        $exampleStore->getExamples()->willReturn([$example]);

        $this->test($exampleStore, $runner, false);
    }

    function it_ignores_skipped_examples(
        $evaluator,
        $dispatcher,
        ExampleStoreInterface $exampleStore,
        ExampleObj $example,
        RunnerInterface $runner,
        NameObj $name
    ) {
        $name->getFullName()->willReturn('');

        $example->isActive()->willReturn(true);
        $example->getName()->willReturn($name);

        $runner->run($example)->willReturn(new SkippedOutcome(''));

        $dispatcher->dispatch(Argument::type(Event\ExampleSkipped::class))->shouldBeCalled();

        $exampleStore->getExamples()->willReturn([$example]);

        $this->test($exampleStore, $runner, false);
    }
}
