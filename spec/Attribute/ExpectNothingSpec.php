<?php

declare(strict_types=1);

namespace spec\hanneskod\readmetester\Attribute;

use hanneskod\readmetester\Attribute\ExpectNothing;
use hanneskod\readmetester\Attribute\AttributeInterface;
use hanneskod\readmetester\Compiler\TransformationInterface;
use hanneskod\readmetester\Example\ExampleObj;
use hanneskod\readmetester\Expectation\VoidExpectation;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ExpectNothingSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ExpectNothing::class);
    }

    function it_is_an_attribute()
    {
        $this->shouldHaveType(AttributeInterface::class);
    }

    function it_is_a_transformation()
    {
        $this->shouldHaveType(TransformationInterface::class);
    }

    function it_transforms(ExampleObj $example)
    {
        $example->withExpectation(new VoidExpectation())->willReturn($example)->shouldBeCalled();

        $this->transform($example)->shouldReturn($example);
    }

    function it_can_create_attribute()
    {
        $this->createAttribute()->shouldReturn('#[\hanneskod\readmetester\Attribute\ExpectNothing]');
    }

    function it_can_get_as_attribute()
    {
        $this->asAttribute()->shouldReturn('#[\hanneskod\readmetester\Attribute\ExpectNothing]');
    }
}
