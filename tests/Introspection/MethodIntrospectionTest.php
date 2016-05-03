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

use SR\Reflection\Introspection\MethodIntrospection;

/**
 * Class MethodIntrospectionTest.
 */
class MethodIntrospectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var string
     */
    const TEST_CLASS = 'SR\Reflection\Tests\Helper\FixtureClassOne';

    /**
     * @var string
     */
    const TEST_NAME = 'publicOne0';

    /**
     * @var string
     */
    const TEST_NAME_PROTECTED = 'protectedOne0';

    /**
     * @var string
     */
    const TEST_NAME_PRIVATE = 'privateOne0';

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
        $this->expectException('SR\Exception\InvalidArgumentException');
        new MethodIntrospection(self::TEST_CLASS, 'thisMethodDoesNotExist');
    }

    public function testExport()
    {
        foreach (self::TEST_NAMES as $method) {
            $export = MethodIntrospection::export(self::TEST_CLASS, $method);
            $this->assertRegExp('{Method \[ <user> (public|protected|private) method [a-zA-Z0-9]+ \]}', $export);
        }

        $this->expectException('SR\Exception\InvalidArgumentException');
        MethodIntrospection::export(self::TEST_CLASS, 'thisMethodDoesNotExist');
    }

    public function testDeclaringClass()
    {
        $inspect = new MethodIntrospection(self::TEST_CLASS, self::TEST_NAME);
        $this->assertSame(self::TEST_CLASS, $inspect->declaringClass()->nameQualified());
        $this->assertInstanceOf('\ReflectionClass', $inspect->reflectionDeclaringClass());
    }

    public function testName()
    {
        foreach (self::TEST_NAMES as $method) {
            $inspect = new MethodIntrospection(self::TEST_CLASS, $method);
            $this->assertSame(self::TEST_CLASS.'::'.$method, $inspect->nameQualified());
            $this->assertSame(self::TEST_CLASS.'::'.$method, $inspect->name(true));
            $this->assertSame($method, $inspect->nameUnQualified());
            $this->assertSame($method, $inspect->name());
        }
    }

    public function testInvoke()
    {
        foreach (self::TEST_NAMES as $method) {
            $class = self::TEST_CLASS;
            $class = new $class();
            $inspect = new MethodIntrospection(self::TEST_CLASS, $method);
            $result = $inspect->invoke($class, 'Invoked');
            $this->assertRegExp('{prop(Public|Protected|Private)(One|Two|Three)[0-2]Invoked}', $result);
        }
    }

    public function testDocBlock()
    {
        foreach (self::TEST_NAMES as $method) {
            $inspect = new MethodIntrospection(self::TEST_CLASS, $method);
            $result = $inspect->docBlock();
            $this->assertRegExp('{@param string \$param}', $result);
            $this->assertRegExp('{@return string}', $result);
        }
    }

    public function testModifiers()
    {
        foreach (self::TEST_NAMES as $method) {
            $_ = new MethodIntrospection(self::TEST_CLASS, $method);
            $this->assertTrue(gettype($_->modifiers()) === 'integer');
            $this->assertFalse($_->isAbstract());
            $this->assertFalse($_->isFinal());
            $this->assertFalse($_->isInternal());
            $this->assertTrue($_->isUserDefined());
            $this->assertFalse($_->isStatic());
            $this->assertFalse($_->isClosure());
            $this->assertFalse($_->isConstructor());
            $this->assertFalse($_->isDestructor());
            $this->assertFalse($_->isVariadic());
        }
    }
}

/* EOF */
