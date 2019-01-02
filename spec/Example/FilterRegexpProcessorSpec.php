<?php

declare(strict_types = 1);

namespace spec\hanneskod\readmetester\Example;

use hanneskod\readmetester\Example\FilterRegexpProcessor;
use hanneskod\readmetester\Example\ProcessorInterface;
use hanneskod\readmetester\Example\ExampleInterface;
use hanneskod\readmetester\Expectation\Regexp;
use hanneskod\readmetester\Name\NameInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FilterRegexpProcessorSpec extends ObjectBehavior
{
    function let(Regexp $regexp) {
        $this->beConstructedWith($regexp);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(FilterRegexpProcessor::CLASS);
    }

    function it_is_a_processor()
    {
        $this->shouldHaveType(ProcessorInterface::CLASS);
    }

    function it_filters_on_no_match($regexp, ExampleInterface $example, NameInterface $name)
    {
        $example->getName()->willReturn($name);
        $name->getShortName()->willReturn('foobar');
        $regexp->isMatch('foobar')->willReturn(false);

        $example->withActive(false)->willReturn($example)->shouldBeCalled();
        $this->process($example)->shouldReturn($example);
    }

    function it_ignores_matching($regexp, ExampleInterface $example, NameInterface $name)
    {
        $example->getName()->willReturn($name);
        $name->getShortName()->willReturn('foobar');
        $regexp->isMatch('foobar')->willReturn(true);

        $this->process($example)->shouldReturn($example);
    }
}