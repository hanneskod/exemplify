<?php
/**
 * This program is free software. It comes without any warranty, to
 * the extent permitted by applicable law. You can redistribute it
 * and/or modify it under the terms of the Do What The Fuck You Want
 * To Public License, Version 2, as published by Sam Hocevar. See
 * http://www.wtfpl.net/ for more details.
 */

namespace hanneskod\exemplify;

use PHPUnit_Framework_TestCase;
use ReflectionClass;
use phpDocumentor\Reflection\DocBlock;
use hanneskod\exemplify\Content\Container;
use hanneskod\exemplify\Content\Header;
use hanneskod\exemplify\Content\TextContent;

/**
 * The exemplify test case base class
 *
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
class TestCase extends PHPUnit_Framework_TestCase
{
    /**
     * Regular expression to identify example methods
     */
    const EXAMPLE_METHOD_REGEXP = '/^example/';

    /**
     * Get exemplify examples in test case
     *
     * @return array
     */
    public function getexemplifyExamples()
    {
        $examples = array();
        $class = new ReflectionClass($this);
        foreach ($class->getMethods() as $method) {
            if (preg_match(self::EXAMPLE_METHOD_REGEXP, $method->getName())) {
                $examples[] = new Example($method, $this);
            }
        }
        return $examples;
    }

    /**
     * Run all examples as test cases
     *
     * @return void
     */
    public function testexemplifyExamples()
    {
        foreach ($this->getexemplifyExamples() as $method) {
            $method->runTest();
        }
    }

    /**
     * Generate exemplify content
     *
     * @return ContentInterface
     */
    public function exemplify()
    {
        $container = new Container();

        $class = new ReflectionClass($this);
        $docblock = new DocBlock($class->getDocComment());

        if ($short = $docblock->getShortDescription()) {
            $container->addContent(new Header($short));
        };

        if ($long = $docblock->getLongDescription()->getContents()) {
            $container->addContent(new TextContent($long));
        };

        foreach ($this->getexemplifyExamples() as $example) {
            $container->addContent($example->getContainer());
        }

        return $container;
    }
}
