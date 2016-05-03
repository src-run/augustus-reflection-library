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

use SR\Reflection\Tests\Helper\ReflectionFixture;

/**
 * Class AbstractIntrospectionTest.
 */
class AbstractIntrospectionTest extends \PHPUnit_Framework_TestCase
{
    public function testInvalidReflectorInConstruct()
    {
        $this->expectException('\InvalidArgumentException');

        $mock = $this->getMockBuilder('SR\Reflection\Introspection\AbstractIntrospection')
            ->disableOriginalConstructor()
            ->setMethods(['getReflectionRequirements'])
            ->getMockForAbstractClass();
        $mock->method('getReflectionRequirements')
            ->willReturn(['\InvalidReflectorClassName']);

        $r = new \ReflectionClass('SR\Reflection\Introspection\AbstractIntrospection');
        $m = $r->getMethod('setReflection');
        $m->setAccessible(true);
        $m->invoke($mock, new ReflectionFixture());
    }
}

/* EOF */
