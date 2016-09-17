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

use SR\Exception\InvalidArgumentException;
use SR\Reflection\Inspector;
use SR\Reflection\InspectorInterface;
use SR\Reflection\Introspect\ClassIntrospect;
use SR\Reflection\Introspect\ConstantIntrospect;
use SR\Reflection\Introspect\InterfaceIntrospect;
use SR\Reflection\Introspect\ObjectIntrospect;
use SR\Reflection\Introspect\Resolver\ResultResolver;
use SR\Reflection\Introspect\TraitIntrospect;
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
    const TEST_CLASS = Inspector::class;
    const TEST_FIXTURE_CLASS = ResultResolver::class;
    const TEST_FIXTURE_TRAIT = FixtureTrait::class;
    const TEST_FIXTURE_INTERFACE = InspectorInterface::class;

    /**
     * @var Inspector
     */
    protected static $instance = null;

    public function testReflectionOnInvalidInput()
    {
        $this->expectException(\RuntimeException::class);

        $r = Inspector::from(__NAMESPACE__.'abcdef0123\ThisShouldNot\Ever\Exist');
    }

    public function testReflectionOnClassName()
    {
        $qualified = self::TEST_FIXTURE_CLASS;
        $lastSlashPosition = StringInspect::searchPositionFromRight($qualified, '\\');
        $name = substr($qualified, $lastSlashPosition + 1);
        $namespace = substr($qualified, 0, $lastSlashPosition);
        $namespaceSections = explode('\\', $namespace);

        $r = Inspector::fromClass($qualified);

        $this->assertTrue($r instanceof ClassIntrospect);
        $this->assertSame($qualified, $r->nameQualified());
        $this->assertSame($name, $r->nameUnQualified());
        $this->assertSame($name, $r->name());
        $this->assertSame($name, $r->name(false));
        $this->assertSame($qualified, $r->name(true));
        $this->assertSame($namespace, $r->namespaceName());
        $this->assertSame($namespaceSections, $r->namespaceSections());

        $r = Inspector::from($qualified);

        $this->assertTrue($r instanceof ClassIntrospect);
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

        $r = Inspector::fromInterface($qualified);

        $this->assertTrue($r instanceof InterfaceIntrospect);
        $this->assertSame($qualified, $r->nameQualified());
        $this->assertSame($name, $r->nameUnQualified());
        $this->assertSame($name, $r->name());
        $this->assertSame($name, $r->name(false));
        $this->assertSame($qualified, $r->name(true));
        $this->assertSame($namespace, $r->namespaceName());
        $this->assertSame($namespaceSections, $r->namespaceSections());

        $r = Inspector::from($qualified);

        $this->assertTrue($r instanceof InterfaceIntrospect);
        $this->assertSame($qualified, $r->nameQualified());
        $this->assertSame($name, $r->nameUnQualified());
        $this->assertSame($name, $r->name());
        $this->assertSame($name, $r->name(false));
        $this->assertSame($qualified, $r->name(true));
        $this->assertSame($namespace, $r->namespaceName());
        $this->assertSame($namespaceSections, $r->namespaceSections());

        $this->expectException(InvalidArgumentException::class);
        Inspector::fromTrait($qualified.'\InvalidTraitName');
    }

    public function testReflectionOnClassInstance()
    {
        $c = self::TEST_FIXTURE_CLASS;
        $f = new $c();
        $r = Inspector::fromInstance($f);

        $this->assertTrue($r instanceof ObjectIntrospect);
        $this->assertSame(self::TEST_FIXTURE_CLASS, $r->nameQualified());

        $r = Inspector::from($f);

        $this->assertTrue($r instanceof ObjectIntrospect);
        $this->assertSame(self::TEST_FIXTURE_CLASS, $r->nameQualified());
    }

    public function testReflectionOnTraitName()
    {
        $qualified = self::TEST_FIXTURE_TRAIT;
        $lastSlashPosition = StringInspect::searchPositionFromRight($qualified, '\\');
        $name = substr($qualified, $lastSlashPosition + 1);
        $namespace = substr($qualified, 0, $lastSlashPosition);
        $namespaceSections = explode('\\', $namespace);

        $r = Inspector::fromTrait($qualified);

        $this->assertTrue($r instanceof TraitIntrospect);
        $this->assertSame($qualified, $r->nameQualified());
        $this->assertSame($name, $r->nameUnQualified());
        $this->assertSame($name, $r->name());
        $this->assertSame($name, $r->name(false));
        $this->assertSame($qualified, $r->name(true));
        $this->assertSame($namespace, $r->namespaceName());
        $this->assertSame($namespaceSections, $r->namespaceSections());

        $r = Inspector::from($qualified);

        $this->assertTrue($r instanceof TraitIntrospect);
        $this->assertSame($qualified, $r->nameQualified());
        $this->assertSame($name, $r->nameUnQualified());
        $this->assertSame($name, $r->name());
        $this->assertSame($name, $r->name(false));
        $this->assertSame($qualified, $r->name(true));
        $this->assertSame($namespace, $r->namespaceName());
        $this->assertSame($namespaceSections, $r->namespaceSections());

        $trait = FixtureTraitTwo::class;
        $r = Inspector::fromTrait($trait);

        $this->assertTrue($r instanceof TraitIntrospect);
        $this->assertSame($trait, $r->nameQualified());

        $this->expectException(InvalidArgumentException::class);
        $r = Inspector::fromTrait($trait.'\InvalidTraitName');
    }

    public function testBindTo()
    {
        $object = FixtureClassOne::class;
        $method = Inspector::fromClass($object, $fixture = new FixtureClassOne());

        $result = $method->visitConstants(function (ConstantIntrospect $const) use ($object) {
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
