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

use SR\Reflection\Exception\InvalidArgumentException;
use SR\Reflection\Exception\RuntimeException;
use SR\Reflection\Inspect;
use SR\Reflection\InspectInterface;
use SR\Reflection\Inspector\ClassInspector;
use SR\Reflection\Inspector\ConstantInspector;
use SR\Reflection\Inspector\InterfaceInspector;
use SR\Reflection\Inspector\ObjectInspector;
use SR\Reflection\Resolver\Resolver;
use SR\Reflection\Inspector\TraitInspector;
use SR\Reflection\Tests\Helper\AbstractTestHelper;
use SR\Reflection\Tests\Helper\FixtureClassOne;
use SR\Reflection\Tests\Helper\FixtureTrait;
use SR\Reflection\Tests\Helper\FixtureTraitTwo;
use SR\Utility\StringInspect;

/**
 * Class InspectTest.
 */
class InspectTest extends AbstractTestHelper
{
    const TEST_CLASS = Inspect::class;
    const TEST_FIXTURE_CLASS = Resolver::class;
    const TEST_FIXTURE_TRAIT = FixtureTrait::class;
    const TEST_FIXTURE_INTERFACE = InspectInterface::class;

    /**
     * @var Inspect
     */
    protected static $instance = null;

    public function testReflectionOnInvalidInput()
    {
        $this->expectException(RuntimeException::class);

        $r = Inspect::using(__NAMESPACE__.'abcdef0123\ThisShouldNot\Ever\Exist');
    }

    public function testReflectionOnClassName()
    {
        $qualified = self::TEST_FIXTURE_CLASS;
        $lastSlashPosition = StringInspect::searchPositionFromRight($qualified, '\\');
        $name = substr($qualified, $lastSlashPosition + 1);
        $namespace = substr($qualified, 0, $lastSlashPosition);
        $namespaceSections = explode('\\', $namespace);

        $r = Inspect::useClass($qualified);

        $this->assertTrue($r instanceof ClassInspector);
        $this->assertSame($qualified, $r->nameQualified());
        $this->assertSame($name, $r->nameUnQualified());
        $this->assertSame($name, $r->name());
        $this->assertSame($name, $r->name(false));
        $this->assertSame($qualified, $r->name(true));
        $this->assertSame($namespace, $r->namespaceName());
        $this->assertSame($namespaceSections, $r->namespaceSections());

        $r = Inspect::using($qualified);

        $this->assertTrue($r instanceof ClassInspector);
        $this->assertSame($qualified, $r->nameQualified());
        $this->assertSame($name, $r->nameUnQualified());
        $this->assertSame($name, $r->name());
        $this->assertSame($name, $r->name(false));
        $this->assertSame($qualified, $r->name(true));
        $this->assertSame($namespace, $r->namespaceName());
        $this->assertSame($namespaceSections, $r->namespaceSections());
    }

    public function testReflectionOnInterfaceName()
    {
        $qualified = self::TEST_FIXTURE_INTERFACE;
        $lastSlashPosition = StringInspect::searchPositionFromRight($qualified, '\\');
        $name = substr($qualified, $lastSlashPosition + 1);
        $namespace = substr($qualified, 0, $lastSlashPosition);
        $namespaceSections = explode('\\', $namespace);

        $r = Inspect::useInterface($qualified);

        $this->assertTrue($r instanceof InterfaceInspector);
        $this->assertSame($qualified, $r->nameQualified());
        $this->assertSame($name, $r->nameUnQualified());
        $this->assertSame($name, $r->name());
        $this->assertSame($name, $r->name(false));
        $this->assertSame($qualified, $r->name(true));
        $this->assertSame($namespace, $r->namespaceName());
        $this->assertSame($namespaceSections, $r->namespaceSections());

        $r = Inspect::using($qualified);

        $this->assertTrue($r instanceof InterfaceInspector);
        $this->assertSame($qualified, $r->nameQualified());
        $this->assertSame($name, $r->nameUnQualified());
        $this->assertSame($name, $r->name());
        $this->assertSame($name, $r->name(false));
        $this->assertSame($qualified, $r->name(true));
        $this->assertSame($namespace, $r->namespaceName());
        $this->assertSame($namespaceSections, $r->namespaceSections());

        $this->expectException(InvalidArgumentException::class);
        Inspect::useTrait($qualified.'\InvalidTraitName');
    }

    public function testReflectionOnClassInstance()
    {
        $c = self::TEST_FIXTURE_CLASS;
        $f = new $c();
        $r = Inspect::useInstance($f);

        $this->assertTrue($r instanceof ObjectInspector);
        $this->assertSame(self::TEST_FIXTURE_CLASS, $r->nameQualified());

        $r = Inspect::using($f);

        $this->assertTrue($r instanceof ObjectInspector);
        $this->assertSame(self::TEST_FIXTURE_CLASS, $r->nameQualified());
    }

    public function testReflectionOnTraitName()
    {
        $qualified = self::TEST_FIXTURE_TRAIT;
        $lastSlashPosition = StringInspect::searchPositionFromRight($qualified, '\\');
        $name = substr($qualified, $lastSlashPosition + 1);
        $namespace = substr($qualified, 0, $lastSlashPosition);
        $namespaceSections = explode('\\', $namespace);

        $r = Inspect::useTrait($qualified);

        $this->assertTrue($r instanceof TraitInspector);
        $this->assertSame($qualified, $r->nameQualified());
        $this->assertSame($name, $r->nameUnQualified());
        $this->assertSame($name, $r->name());
        $this->assertSame($name, $r->name(false));
        $this->assertSame($qualified, $r->name(true));
        $this->assertSame($namespace, $r->namespaceName());
        $this->assertSame($namespaceSections, $r->namespaceSections());

        $r = Inspect::using($qualified);

        $this->assertTrue($r instanceof TraitInspector);
        $this->assertSame($qualified, $r->nameQualified());
        $this->assertSame($name, $r->nameUnQualified());
        $this->assertSame($name, $r->name());
        $this->assertSame($name, $r->name(false));
        $this->assertSame($qualified, $r->name(true));
        $this->assertSame($namespace, $r->namespaceName());
        $this->assertSame($namespaceSections, $r->namespaceSections());

        $trait = FixtureTraitTwo::class;
        $r = Inspect::useTrait($trait);

        $this->assertTrue($r instanceof TraitInspector);
        $this->assertSame($trait, $r->nameQualified());

        $this->expectException(InvalidArgumentException::class);
        $r = Inspect::useTrait($trait.'\InvalidTraitName');
    }

    public function testBindTo()
    {
        $object = FixtureClassOne::class;
        $method = Inspect::useClass($object, $fixture = new FixtureClassOne());

        $result = $method->visitConstants(function (ConstantInspector $const) use ($object) {
            return $this->protectedOne0($const->value()).'---'.$const->name();
        });

        $this->assertGreaterThan(3, $result);

        foreach ($result as $r) {
            $this->assertNotFalse(strpos($r, 'propProtectedOne0') !== false);
            $this->assertNotFalse(strpos($r, 'ONE_') !== false || strpos($r, 'NULL_') !== false);
        }
    }
}

/* EOF */
