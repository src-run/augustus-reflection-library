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

use SR\Reflection\Inspector\PropertyInspector;

/**
 * Class PropertyIntrospectionTest.
 */
class PropertyIntrospectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var string
     */
    const TEST_CLASS = 'SR\Reflection\Tests\Helper\FixtureClassOne';

    /**
     * @var string
     */
    const TEST_NAME = 'propPublicOne0';

    /**
     * @var string
     */
    const TEST_NAME_PROTECTED = 'propProtectedOne0';

    /**
     * @var string
     */
    const TEST_NAME_PRIVATE = 'propPrivateOne0';

    /**
     * @var string[]
     */
    const TEST_NAMES = [
        self::TEST_NAME,
        self::TEST_NAME_PROTECTED,
        self::TEST_NAME_PRIVATE,
    ];

    public function testInvalidConstructorArguments()
    {
        $this->expectException('SR\Reflection\Exception\InvalidArgumentException');
        new PropertyInspector(self::TEST_CLASS, 'thisPropertyDoesNotExist');
    }

    public function testExport()
    {
        foreach (self::TEST_NAMES as $property) {
            $export = PropertyInspector::export(self::TEST_CLASS, $property);
            $this->assertRegExp('{Property \[ <default> (public|protected|private) \$[a-zA-Z0-9]+ \]}', $export);
        }

        $class = self::TEST_CLASS;
        $class = new $class();
        $class->dynamic_property = 'dynamic_property';
        $export = PropertyInspector::export($class, 'dynamic_property');
        $this->assertSame('Property [ <implicit> $dynamic_property ]', $export);

        $this->expectException('SR\Reflection\Exception\InvalidArgumentException');
        PropertyInspector::export(self::TEST_CLASS, 'thisPropertyDoesNotExist');
    }

    public function testDeclaringClass()
    {
        $inspect = new PropertyInspector(self::TEST_CLASS, self::TEST_NAME);
        $this->assertSame(self::TEST_CLASS, $inspect->declaringClass()->nameQualified());
        $this->assertInstanceOf('\ReflectionClass', $inspect->reflectionDeclaringClass());
    }

    public function testName()
    {
        foreach (self::TEST_NAMES as $property) {
            $inspect = new PropertyInspector(self::TEST_CLASS, $property);
            $this->assertSame(self::TEST_CLASS.'::$'.$property, $inspect->nameQualified());
            $this->assertSame(self::TEST_CLASS.'::$'.$property, $inspect->name(true));
            $this->assertSame($property, $inspect->nameUnQualified());
            $this->assertSame($property, $inspect->name());
        }
    }

    public function testValue()
    {
        foreach (self::TEST_NAMES as $property) {
            $class = self::TEST_CLASS;
            $class = new $class();
            $inspect = new PropertyInspector(self::TEST_CLASS, $property);
            $result = $inspect->value($class);
            $this->assertRegExp('{prop(Public|Protected|Private)(One|Two|Three)[0-2]}', $result);
            $inspect->setValue($class, self::TEST_CLASS);
            $this->assertSame(self::TEST_CLASS, $inspect->value($class));
        }
    }

    public function testDocBlock()
    {
        foreach (self::TEST_NAMES as $property) {
            $class = self::TEST_CLASS;
            $class = new $class();
            $inspect = new PropertyInspector(self::TEST_CLASS, $property);
            $result = $inspect->docBlock();
            $this->assertRegExp('{@var string}', $result);
        }
    }

    public function testModifiers()
    {
        foreach (self::TEST_NAMES as $property) {
            $_ = new PropertyInspector(self::TEST_CLASS, $property);
            $this->assertTrue(gettype($_->modifiers()) === 'integer');
            $this->assertFalse($_->isStatic());
            $this->assertTrue($_->isDefault());
        }
    }
}

/* EOF */
