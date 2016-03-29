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

namespace SR\Reflection\Tests\Manager;

use SR\Reflection\Tests\Helper\ReflectionFixture;

/**
 * Class AbstractClassTypeManagerTest.
 */
class AbstractClassTypeManagerTest extends \PHPUnit_Framework_TestCase
{
    public function testInvalidReflectorInConstruct()
    {
        $this->expectException('\InvalidArgumentException');

        $mock = $this->getMockBuilder('SR\Reflection\Manager\AbstractTypeManager')
            ->disableOriginalConstructor()
            ->setMethods(['reflectionRequiredIsInstanceOfSet'])
            ->getMockForAbstractClass();
        $mock->method('reflectionRequiredIsInstanceOfSet')
            ->willReturn(['\InvalidReflectorClassReferenceChecked']);

        $r = new \ReflectionClass('SR\Reflection\Manager\AbstractTypeManager');
        $m = $r->getMethod('initializeReflection');
        $m->setAccessible(true);
        $m->invoke($mock, new ReflectionFixture());
    }
}

/* EOF */
