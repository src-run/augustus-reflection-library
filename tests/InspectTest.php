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

use SR\Reflection\Definition\ReflectionConstant;
use SR\Reflection\Inspect;
use SR\Reflection\Manager\ClassInstanceTypeManager;
use SR\Reflection\Manager\ClassGeneralTypeManager;
use SR\Reflection\Tests\Helper\AbstractTestHelper;

/**
 * Class InspectTest.
 */
class InspectTest extends AbstractTestHelper
{
    /**
     * @var string
     */
    const TEST_CLASS = '\Inspect';

    /**
     * @var string
     */
    const TEST_FIXTURE_CLASS = 'SR\Reflection\Manager\Resolver\ResultSetResolver';

    /**
     * @var Inspect
     */
    protected static $instance = null;

    public function testReflectionOnInvalidInput()
    {
        $this->expectException('\RuntimeException');
        
        $r = Inspect::this(__NAMESPACE__.'abcdef0123\ThisShouldNot\Ever\Exist');
    }

    public function testReflectionOnClassName()
    {
        $r = Inspect::thisClass(self::TEST_FIXTURE_CLASS);

        $this->assertTrue($r instanceof ClassGeneralTypeManager);
        $this->assertSame(self::TEST_FIXTURE_CLASS, $r->classNameAbsolute());

        $r = Inspect::this(self::TEST_FIXTURE_CLASS);

        $this->assertTrue($r instanceof ClassGeneralTypeManager);
        $this->assertSame(self::TEST_FIXTURE_CLASS, $r->classNameAbsolute());
    }

    public function testReflectionOnClassInstance()
    {
        $c = self::TEST_FIXTURE_CLASS;
        $f = new $c;
        $r = Inspect::thisInstance($f);

        $this->assertTrue($r instanceof ClassInstanceTypeManager);
        $this->assertSame(self::TEST_FIXTURE_CLASS, $r->classNameAbsolute());

        $r = Inspect::this($f);

        $this->assertTrue($r instanceof ClassInstanceTypeManager);
        $this->assertSame(self::TEST_FIXTURE_CLASS, $r->classNameAbsolute());
    }

    public function testBoundScope()
    {
        $c = '\SR\Reflection\Tests\Helper\FixtureClassOne';
        $s = new \SR\Reflection\Tests\Helper\FixtureClassOne();
        $m = Inspect::thisClass($c, $s);

        $results = $m->visitConstants(function(ReflectionConstant &$c) {
            return $this->protectedOne0($c->getValue()).'---'.$c->getName();
        });

        $this->assertGreaterThan(3, $results);

        foreach ($results as $r) {
            $this->assertNotFalse(strpos($r, 'propProtectedOne0---'));
        }
    }
}

/* EOF */