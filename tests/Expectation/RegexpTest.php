<?php

namespace hanneskod\readmetester\Expectation;

class RegexpTest extends \PHPUnit_Framework_TestCase
{
    public function regexpProvider()
    {
        return [
            ['/test/', 'a test'],
            ['#delimiter#', 'a different delimiter'],
            ['foobar', 'foobar']
        ];
    }

    /**
     * @dataProvider regexpProvider
     */
    public function testMatch($regexpStr, $subject)
    {
        $regexp = new Regexp($regexpStr);
        $this->assertTrue(
            $regexp->isMatch($subject)
        );
    }

    public function testNoMatch()
    {
        $regexp = new Regexp('foo');
        $this->assertFalse(
            $regexp->isMatch('bar')
        );
    }

    public function testToString()
    {
        $regexp = new Regexp('foo');
        $this->assertSame(
            '/^foo$/',
            (string)$regexp
        );
    }
}
