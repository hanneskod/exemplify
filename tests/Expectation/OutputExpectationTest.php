<?php

namespace hanneskod\readmetester\Expectation;

use hanneskod\readmetester\Result;

class OutputExpectationTest extends \PHPUnit_Framework_TestCase
{
    public function testNoMatch()
    {
        $expectation = new OutputExpectation(new Regexp('/foo/'));
        $this->assertInstanceOf(
            'hanneskod\readmetester\Expectation\ReturnObj\Failure',
            $expectation->validate(new Result('', 'bar'))
        );
    }

    public function testMatch()
    {
        $expectation = new OutputExpectation(new Regexp('/foo/'));
        $this->assertInstanceOf(
            'hanneskod\readmetester\Expectation\ReturnObj\Success',
            $expectation->validate(new Result('', 'foo'))
        );
    }
}
