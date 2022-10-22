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
use SR\Reflection\Inspector\TraitInspector;
use SR\Reflection\Resolver\Resolver;
use SR\Reflection\Tests\Helper\AbstractTestHelper;
use SR\Reflection\Tests\Helper\FixtureClassOne;
use SR\Reflection\Tests\Helper\FixtureTrait;
use SR\Reflection\Tests\Helper\FixtureTraitTwo;
use SR\Utilities\Query\StringQuery;

/**
 * Class InspectTest.
 *
 * @covers \SR\Reflection\Inspect
 * @covers \SR\Reflection\Resolver\Resolver
 */
class InspectTest extends AbstractTestHelper
{
    public const TEST_CLASS = Inspect::class;

    public const TEST_FIXTURE_CLASS = Resolver::class;

    public const TEST_FIXTURE_TRAIT = FixtureTrait::class;

    public const TEST_FIXTURE_INTERFACE = InspectInterface::class;

    /**
     * @var Inspect
     */
    protected static $instance = null;

    public function testReflectionOnInvalidInput()
    {
        $this->expectException(RuntimeException::class);

        $r = Inspect::using(__NAMESPACE__ . 'abcdef0123\ThisShouldNot\Ever\Exist');
    }

    public function testReflectionOnClassName()
    {
        $qualified = self::TEST_FIXTURE_CLASS;
        $lastSlashPosition = StringQuery::searchPositionFromRight($qualified, '\\');
        $name = mb_substr($qualified, $lastSlashPosition + 1);
        $namespace = mb_substr($qualified, 0, $lastSlashPosition);
        $namespaceSections = explode('\\', $namespace);

        $r = Inspect::useClass($qualified);

        $this->assertInstanceOf(ClassInspector::class, $r);
        $this->assertSame($qualified, $r->nameQualified());
        $this->assertSame($name, $r->nameUnQualified());
        $this->assertSame($name, $r->name());
        $this->assertSame($name, $r->name(false));
        $this->assertSame($qualified, $r->name(true));
        $this->assertSame($namespace, $r->namespaceName());
        $this->assertSame($namespaceSections, $r->namespaceSections());

        $r = Inspect::using($qualified);

        $this->assertInstanceOf(ClassInspector::class, $r);
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
        $lastSlashPosition = StringQuery::searchPositionFromRight($qualified, '\\');
        $name = mb_substr($qualified, $lastSlashPosition + 1);
        $namespace = mb_substr($qualified, 0, $lastSlashPosition);
        $namespaceSections = explode('\\', $namespace);

        $r = Inspect::useInterface($qualified);

        $this->assertInstanceOf(InterfaceInspector::class, $r);
        $this->assertSame($qualified, $r->nameQualified());
        $this->assertSame($name, $r->nameUnQualified());
        $this->assertSame($name, $r->name());
        $this->assertSame($name, $r->name(false));
        $this->assertSame($qualified, $r->name(true));
        $this->assertSame($namespace, $r->namespaceName());
        $this->assertSame($namespaceSections, $r->namespaceSections());

        $r = Inspect::using($qualified);

        $this->assertInstanceOf(InterfaceInspector::class, $r);
        $this->assertSame($qualified, $r->nameQualified());
        $this->assertSame($name, $r->nameUnQualified());
        $this->assertSame($name, $r->name());
        $this->assertSame($name, $r->name(false));
        $this->assertSame($qualified, $r->name(true));
        $this->assertSame($namespace, $r->namespaceName());
        $this->assertSame($namespaceSections, $r->namespaceSections());

        $this->expectException(InvalidArgumentException::class);
        Inspect::useTrait($qualified . '\InvalidTraitName');
    }

    public function testReflectionOnClassInstance()
    {
        $c = self::TEST_FIXTURE_CLASS;
        $f = new $c();
        $r = Inspect::useInstance($f);

        $this->assertInstanceOf(ObjectInspector::class, $r);
        $this->assertSame(self::TEST_FIXTURE_CLASS, $r->nameQualified());

        $r = Inspect::using($f);

        $this->assertInstanceOf(ObjectInspector::class, $r);
        $this->assertSame(self::TEST_FIXTURE_CLASS, $r->nameQualified());
    }

    public function testReflectionOnTraitName()
    {
        $qualified = self::TEST_FIXTURE_TRAIT;
        $lastSlashPosition = StringQuery::searchPositionFromRight($qualified, '\\');
        $name = mb_substr($qualified, $lastSlashPosition + 1);
        $namespace = mb_substr($qualified, 0, $lastSlashPosition);
        $namespaceSections = explode('\\', $namespace);

        $r = Inspect::useTrait($qualified);

        $this->assertInstanceOf(TraitInspector::class, $r);
        $this->assertSame($qualified, $r->nameQualified());
        $this->assertSame($name, $r->nameUnQualified());
        $this->assertSame($name, $r->name());
        $this->assertSame($name, $r->name(false));
        $this->assertSame($qualified, $r->name(true));
        $this->assertSame($namespace, $r->namespaceName());
        $this->assertSame($namespaceSections, $r->namespaceSections());

        $r = Inspect::using($qualified);

        $this->assertInstanceOf(TraitInspector::class, $r);
        $this->assertSame($qualified, $r->nameQualified());
        $this->assertSame($name, $r->nameUnQualified());
        $this->assertSame($name, $r->name());
        $this->assertSame($name, $r->name(false));
        $this->assertSame($qualified, $r->name(true));
        $this->assertSame($namespace, $r->namespaceName());
        $this->assertSame($namespaceSections, $r->namespaceSections());

        $trait = FixtureTraitTwo::class;
        $r = Inspect::useTrait($trait);

        $this->assertInstanceOf(TraitInspector::class, $r);
        $this->assertSame($trait, $r->nameQualified());

        $this->expectException(InvalidArgumentException::class);
        $r = Inspect::useTrait($trait . '\InvalidTraitName');
    }

    public function testBindTo()
    {
        $object = FixtureClassOne::class;
        $method = Inspect::useClass($object, $fixture = new FixtureClassOne());

        $result = $method->visitConstants(function (ConstantInspector $const) {
            return $this->protectedOne0($const->value()) . '---' . $const->name();
        });

        $this->assertGreaterThan(3, $result);

        foreach ($result as $r) {
            $this->assertNotFalse(false !== mb_strpos($r, 'propProtectedOne0'));
            $this->assertNotFalse(false !== mb_strpos($r, 'ONE_') || false !== mb_strpos($r, 'NULL_'));
        }
    }
}

/* EOF */
