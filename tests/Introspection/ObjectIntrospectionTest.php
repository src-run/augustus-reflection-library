<?php

/*
 * This file is part of the `src-run/augustus-reflection-library` project.
 *
 * (c) Rob Frawley 2nd <rmf@src.run>
 * (c) Scribe Inc      <scr@src.run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace SR\Reflection\Tests\Introspection;

use SR\Reflection\Introspection\ObjectIntrospection;
use SR\Reflection\Tests\Helper\AbstractTestHelper;

/**
 * Class ObjectIntrospectionTest.
 */
class ObjectIntrospectionTest extends AbstractTestHelper
{
    /**
     * @var string
     */
    const TEST_CLASS = '\Introspection\ObjectIntrospection';

    /**
     * @var ObjectIntrospection
     */
    protected static $instance = null;

    /**
     * @return ObjectIntrospection[]
     */
    protected function getFixtureInstances($one = null, $two = null, $three = null)
    {
        $testClass = $this->getClassnameQualified();
        $_ = $this->getFixtureClassNamesAbsolute();

        array_walk($_, function (&$className) {
            $className = new $className;
        });

        return [
            new $testClass($one ?: $_[0]),
            new $testClass($two ?: $_[1]),
            new $testClass($three ?: $_[2]),
        ];
    }

    public function testInvalidConstructorArguments()
    {
        $this->expectException('\RuntimeException');
        $this->getFixtureInstances('/AN/INVALID/NAME/SPACE/I/REALLY/HOPE');
    }
}

/* EOF */
