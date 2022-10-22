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
use SR\Reflection\Inspector\ConstantInspector;
use SR\Reflection\Tests\Helper\FixtureInterface;

/**
 * Class ConstantIntrospectionTest.
 *
 * @covers \SR\Reflection\Inspector\AbstractInspector
 * @covers \SR\Reflection\Inspector\ConstantInspector
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
class ConstantIntrospectionTest extends TestCase
{
    /**
     * @var string
     */
    public const TEST_CLASS = 'SR\Reflection\Tests\Helper\FixtureClassConstants';

    /**
     * @var string
     */
    public const TEST_NAME_1 = 'CONSTANT_STRING';

    /**
     * @var string
     */
    public const TEST_NAME_2 = 'CONSTANT_INT';

    /**
     * @var string
     */
    public const TEST_NAME_3 = 'CONSTANT_NULL';

    /**
     * @var string
     */
    public const TEST_NAME_4 = 'CONSTANT_ARRAY';

    /**
     * @var string[]
     */
    public const TEST_NAMES = [
        self::TEST_NAME_1,
        self::TEST_NAME_2,
        self::TEST_NAME_3,
        self::TEST_NAME_4,
    ];

    public function testInvalidConstructorArguments()
    {
        $this->expectException('SR\Reflection\Exception\InvalidArgumentException');
        new ConstantInspector(self::TEST_CLASS, 'CONSTANT_DOES_NOT_EXIST');
    }

    /*
    public function testExport()
    {
        foreach (self::TEST_NAMES as $constant) {
            $export = ConstantInspector::export(self::TEST_CLASS, $constant);
            $this->assertMatchesRegularExpression('{Constant \[ (string|NULL|integer|array) [A-Za-z0-9_:\\\\]+ \] \{'."\n".'  [^'."\n".']+'."\n".'\}}', $export);
        }

        $this->expectException('SR\Reflection\Exception\InvalidArgumentException');
        ConstantInspector::export(self::TEST_CLASS, 'CONSTANT_DOES_NOT_EXIST');
    }
    */

    public function testDeclaringClass()
    {
        foreach (self::TEST_NAMES as $constant) {
            $inspect = new ConstantInspector(self::TEST_CLASS, $constant);
            $this->assertSame(self::TEST_CLASS, $inspect->declaringClass()->nameQualified());
            $this->assertInstanceOf('\ReflectionClass', $inspect->reflectionDeclaringClass());
        }
    }

    public function testValue()
    {
        foreach (self::TEST_NAMES as $constant) {
            $inspect = new ConstantInspector(self::TEST_CLASS, $constant);
            $this->assertSame(constant(self::TEST_CLASS . '::' . $constant), $inspect->value());

            if (false !== mb_strpos($constant, 'NULL')) {
                $this->assertTrue($inspect->isNull());
            } else {
                $this->assertFalse($inspect->isNull());
            }
        }
    }

    public function testInterfaceConstant()
    {
        $inspect = new ConstantInspector(FixtureInterface::class, 'CONSTANT');
        $this->assertSame('interfaceConstant', $inspect->value());
    }
}

/* EOF */
