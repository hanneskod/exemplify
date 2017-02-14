<?php

namespace hanneskod\readmetester;

class CodeBlockTest extends \PHPUnit\Framework\TestCase
{
    function testGetCode()
    {
        $this->assertSame(
            'foobar',
            (new CodeBlock('foobar'))->getCode()
        );
    }

    function testOutput()
    {
        $codeBlock = new CodeBlock('echo "foo"; return "bar";');
        $this->assertSame(
            'foo',
            $codeBlock->execute()->getOutput()
        );
    }

    function testReturnValue()
    {
        $codeBlock = new CodeBlock('echo "foo"; return 1234;');
        $this->assertSame(
            1234,
            $codeBlock->execute()->getReturnValue()
        );
    }

    function testException()
    {
        $codeBlock = new CodeBlock('throw new Exception;');
        $this->assertInstanceOf(
            'Exception',
            $codeBlock->execute()->getException()
        );
    }

    function testVoid()
    {
        $codeBlock = new CodeBlock('$a = 1 + 2;');
        $this->assertInstanceOf(
            Result::CLASS,
            $codeBlock->execute()
        );
    }
}
