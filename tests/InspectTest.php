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

use SR\Reflection\Definition\ReflectionConstant;
use SR\Reflection\Inspect;
use SR\Reflection\Introspection\ObjectIntrospection;
use SR\Reflection\Introspection\ClassIntrospection;
use SR\Reflection\Introspection\TraitIntrospection;
use SR\Reflection\Tests\Helper\AbstractTestHelper;
use SR\Utility\StringInspect;

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
    const TEST_FIXTURE_CLASS = 'SR\Reflection\Introspection\Resolver\ResultResolver';

    /**
     * @var string
     */
    const TEST_FIXTURE_TRAIT = 'SR\Reflection\Tests\Helper\FixtureTrait';

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
        $qualified = self::TEST_FIXTURE_CLASS;
        $lastSlashPosition = StringInspect::searchPositionFromRight($qualified, '\\');
        $name = substr($qualified, $lastSlashPosition + 1);
        $namespace = substr($qualified, 0, $lastSlashPosition);
        $namespaceSections = explode('\\', $namespace);

        $r = Inspect::thisClass($qualified);

        $this->assertTrue($r instanceof ClassIntrospection);
        $this->assertSame($qualified, $r->nameQualified());
        $this->assertSame($name, $r->nameUnQualified());
        $this->assertSame($name, $r->name());
        $this->assertSame($name, $r->name(false));
        $this->assertSame($qualified, $r->name(true));
        $this->assertSame($namespace, $r->namespaceName());
        $this->assertSame($namespaceSections, $r->namespaceSections());

        $r = Inspect::this($qualified);

        $this->assertTrue($r instanceof ClassIntrospection);
        $this->assertSame($qualified, $r->nameQualified());
        $this->assertSame($name, $r->nameUnQualified());
        $this->assertSame($name, $r->name());
        $this->assertSame($name, $r->name(false));
        $this->assertSame($qualified, $r->name(true));
        $this->assertSame($namespace, $r->namespaceName());
        $this->assertSame($namespaceSections, $r->namespaceSections());
    }

    public function testReflectionOnClassInstance()
    {
        $c = self::TEST_FIXTURE_CLASS;
        $f = new $c;
        $r = Inspect::thisInstance($f);

        $this->assertTrue($r instanceof ObjectIntrospection);
        $this->assertSame(self::TEST_FIXTURE_CLASS, $r->nameQualified());

        $r = Inspect::this($f);

        $this->assertTrue($r instanceof ObjectIntrospection);
        $this->assertSame(self::TEST_FIXTURE_CLASS, $r->nameQualified());
    }

    public function testReflectionOnTraitName()
    {
        $qualified = self::TEST_FIXTURE_TRAIT;
        $lastSlashPosition = StringInspect::searchPositionFromRight($qualified, '\\');
        $name = substr($qualified, $lastSlashPosition + 1);
        $namespace = substr($qualified, 0, $lastSlashPosition);
        $namespaceSections = explode('\\', $namespace);

        $r = Inspect::thisTrait($qualified);

        $this->assertTrue($r instanceof TraitIntrospection);
        $this->assertSame($qualified, $r->nameQualified());
        $this->assertSame($name, $r->nameUnQualified());
        $this->assertSame($name, $r->name());
        $this->assertSame($name, $r->name(false));
        $this->assertSame($qualified, $r->name(true));
        $this->assertSame($namespace, $r->namespaceName());
        $this->assertSame($namespaceSections, $r->namespaceSections());

        $r = Inspect::this($qualified);

        $this->assertTrue($r instanceof TraitIntrospection);
        $this->assertSame($qualified, $r->nameQualified());
        $this->assertSame($name, $r->nameUnQualified());
        $this->assertSame($name, $r->name());
        $this->assertSame($name, $r->name(false));
        $this->assertSame($qualified, $r->name(true));
        $this->assertSame($namespace, $r->namespaceName());
        $this->assertSame($namespaceSections, $r->namespaceSections());

        $trait = 'SR\Reflection\Tests\Helper\FixtureTraitTwo';
        $r = Inspect::thisTrait($trait);

        $this->assertTrue($r instanceof TraitIntrospection);
        $this->assertSame($trait, $r->nameQualified());

        $this->expectException('SR\Exception\RuntimeException');
        $r = Inspect::thisTrait($trait.'\InvalidTraitName');
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
            $this->assertNotFalse(strpos($r, 'propProtectedOne0---') !== false);
            $this->assertNotFalse(strpos($r, 'ONE_') !== false || strpos($r, 'NULL_') !== false);
        }
    }
}

/* EOF */
