<?php

declare(strict_types = 1);

namespace hanneskod\readmetester;

use hanneskod\readmetester\Example\ExampleInterface;
use hanneskod\readmetester\Expectation\ExpectationEvaluator;
use hanneskod\readmetester\Expectation\StatusInterface;
use hanneskod\readmetester\Utils\CodeBlock;
use hanneskod\readmetester\Runner\RunnerInterface;
use hanneskod\readmetester\Runner\OutcomeInterface;

class ExampleTesterTest extends \PHPUnit\Framework\TestCase
{
    public function testExampleAndFireEvents()
    {
        $codeBlock = $this->prophesize(CodeBlock::CLASS);

        $example = $this->prophesize(ExampleInterface::CLASS);
        $example->getCodeBlock()->willReturn($codeBlock);
        $example->getExpectations()->willReturn(['list-of-expectations']);
        $example->isActive()->willReturn(true);

        $outcome = $this->prophesize(OutcomeInterface::CLASS);

        $runner = $this->prophesize(RunnerInterface::CLASS);
        $runner->run($codeBlock)->willReturn($outcome);

        $status = $this->prophesize(StatusInterface::CLASS);

        $evaluator = $this->prophesize(ExpectationEvaluator::CLASS);
        $evaluator->evaluate(['list-of-expectations'], $outcome)->willReturn([$status]);

        $listener = $this->prophesize(ListenerInterface::CLASS);

        $listener->onExample($example)->shouldBeCalled();
        $listener->onExpectation($status)->shouldBeCalled();

        $tester = new ExampleTester($runner->reveal(), $evaluator->reveal());
        $tester->registerListener($listener->reveal());
        $tester->testExample($example->reveal());
    }

    public function testIgnoredExamples()
    {
        $example = $this->prophesize(ExampleInterface::CLASS);
        $example->isActive()->willReturn(false);

        $runner = $this->prophesize(RunnerInterface::CLASS);
        $evaluator = $this->prophesize(ExpectationEvaluator::CLASS);

        $listener = $this->prophesize(ListenerInterface::CLASS);

        $listener->onIgnoredExample($example)->shouldBeCalled();

        $tester = new ExampleTester($runner->reveal(), $evaluator->reveal());
        $tester->registerListener($listener->reveal());
        $tester->testExample($example->reveal());
    }
}
