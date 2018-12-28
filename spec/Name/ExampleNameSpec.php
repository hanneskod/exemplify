<?php

declare(strict_types = 1);

namespace spec\hanneskod\readmetester\Name;

use hanneskod\readmetester\Name\ExampleName;
use hanneskod\readmetester\Name\NameInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ExampleNameSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('foo', 'bar');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ExampleName::CLASS);
    }

    function it_is_a_name()
    {
        $this->shouldHaveType(NameInterface::CLASS);
    }

    function it_contains_a_short_name()
    {
        $this->getShortName()->shouldReturn('foo');
    }

    function it_contains_a_namespace()
    {
        $this->getNamespaceName()->shouldReturn('bar');
    }

    function it_contains_a_complete_name()
    {
        $this->getName()->shouldReturn('bar:foo');
    }
}