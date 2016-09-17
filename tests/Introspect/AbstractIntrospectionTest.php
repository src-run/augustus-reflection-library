<?php

/*
 * This file is part of the `src-run/augustus-reflection-library` project.
 *
 * (c) Rob Frawley 2nd <rmf@src.run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace SR\Reflection\Tests\Introspect;

use SR\Reflection\Introspect\AbstractIntrospect;
use SR\Reflection\Tests\Helper\ReflectionFixture;

/**
 * Class AbstractIntrospectionTest.
 */
class AbstractIntrospectionTest extends \PHPUnit_Framework_TestCase
{
    public function testInvalidReflectorInConstruct()
    {
        $this->expectException(\InvalidArgumentException::class);

        $mock = $this->getMockBuilder(AbstractIntrospect::class)
            ->disableOriginalConstructor()
            ->setMethods(['getReflectionRequirements'])
            ->getMockForAbstractClass();
        $mock->method('getReflectionRequirements')
            ->willReturn(['\InvalidReflectorClassName']);

        $r = new \ReflectionClass(AbstractIntrospect::class);
        $m = $r->getMethod('setReflection');
        $m->setAccessible(true);
        $m->invoke($mock, new ReflectionFixture());
    }
}

/* EOF */
