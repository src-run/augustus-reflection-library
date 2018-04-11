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

use PHPUnit\Framework\TestCase;
use SR\Reflection\Inspector\MethodInspector;

/**
 * Class MethodIntrospectionTest.
 *
 * @covers \SR\Reflection\Inspector\AbstractInspector
 * @covers \SR\Reflection\Inspector\MethodInspector
 * @covers \SR\Reflection\Inspector\Aware\ScopeClass\ConstantAwareTrait
 * @covers \SR\Reflection\Inspector\Aware\ScopeClass\IdentityAwareTrait
 * @covers \SR\Reflection\Inspector\Aware\ScopeClass\InterfaceAwareTrait
 * @covers \SR\Reflection\Inspector\Aware\ScopeClass\ConstantAwareTrait
 * @covers \SR\Reflection\Inspector\Aware\ScopeClass\MethodAwareTrait
 * @covers \SR\Reflection\Inspector\Aware\ScopeClass\ModifiersAwareTrait
 * @covers \SR\Reflection\Inspector\Aware\ScopeClass\PropertyAwareTrait
 * @covers \SR\Reflection\Inspector\Aware\ScopeConstant\IdentityAwareTrait
 * @covers \SR\Reflection\Inspector\Aware\ScopeCore\DocBlockAwareTrait
 * @covers \SR\Reflection\Inspector\Aware\ScopeCore\IdentityDeclaringClassAwareTrait
 * @covers \SR\Reflection\Inspector\Aware\ScopeCore\IdentityInheritanceAwareTrait
 * @covers \SR\Reflection\Inspector\Aware\ScopeCore\IdentityNameAwareTrait
 * @covers \SR\Reflection\Inspector\Aware\ScopeCore\IdentityNamespaceAwareTrait
 * @covers \SR\Reflection\Inspector\Aware\ScopeCore\LocationAwareTrait
 * @covers \SR\Reflection\Inspector\Aware\ScopeCore\ModifiersAwareTrait
 * @covers \SR\Reflection\Inspector\Aware\ScopeCore\VisibilityAwareTrait
 * @covers \SR\Reflection\Inspector\Aware\ScopeMethod\CallableAwareTrait
 * @covers \SR\Reflection\Inspector\Aware\ScopeMethod\IdentityAwareTrait
 * @covers \SR\Reflection\Inspector\Aware\ScopeMethod\ModifiersAwareTrait
 * @covers \SR\Reflection\Inspector\Aware\ScopeProperty\IdentityAwareTrait
 * @covers \SR\Reflection\Inspector\Aware\ScopeProperty\ModifiersAwareTrait
 * @covers \SR\Reflection\Inspector\Aware\ScopeProperty\ValueAwareTrait
 * @covers \SR\Reflection\Resolver\Resolver
 */
class MethodIntrospectionTest extends TestCase
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
        $this->expectException('SR\Reflection\Exception\InvalidArgumentException');
        new MethodInspector(self::TEST_CLASS, 'thisMethodDoesNotExist');
    }

    public function testExport()
    {
        foreach (self::TEST_NAMES as $method) {
            $export = MethodInspector::export(self::TEST_CLASS, $method);
            $this->assertRegExp('{Method \[ <user> (public|protected|private) method [a-zA-Z0-9]+ \]}', $export);
        }

        $this->expectException('SR\Reflection\Exception\InvalidArgumentException');
        MethodInspector::export(self::TEST_CLASS, 'thisMethodDoesNotExist');
    }

    public function testDeclaringClass()
    {
        $inspect = new MethodInspector(self::TEST_CLASS, self::TEST_NAME);
        $this->assertSame(self::TEST_CLASS, $inspect->declaringClass()->nameQualified());
        $this->assertInstanceOf('\ReflectionClass', $inspect->reflectionDeclaringClass());
    }

    public function testName()
    {
        foreach (self::TEST_NAMES as $method) {
            $inspect = new MethodInspector(self::TEST_CLASS, $method);
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
            $inspect = new MethodInspector(self::TEST_CLASS, $method);
            $result = $inspect->invoke($class, 'Invoked');
            $this->assertRegExp('{prop(Public|Protected|Private)(One|Two|Three)[0-2]Invoked}', $result);
        }
    }

    public function testDocBlock()
    {
        foreach (self::TEST_NAMES as $method) {
            $inspect = new MethodInspector(self::TEST_CLASS, $method);
            $result = $inspect->docBlock();
            $this->assertRegExp('{@param string \$param}', $result);
            $this->assertRegExp('{@return string}', $result);
        }
    }

    public function testModifiers()
    {
        foreach (self::TEST_NAMES as $method) {
            $_ = new MethodInspector(self::TEST_CLASS, $method);
            $this->assertTrue('integer' === gettype($_->modifiers()));
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
