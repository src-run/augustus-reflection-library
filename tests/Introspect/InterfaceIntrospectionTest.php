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
use SR\Reflection\Inspector\InterfaceInspector;

/**
 * Class InterfaceIntrospectionTest.
 *
 * @covers \SR\Reflection\Inspector\AbstractInspector
 * @covers \SR\Reflection\Inspector\InterfaceInspector
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
class InterfaceIntrospectionTest extends TestCase
{
    /**
     * @var string
     */
    const TEST_INTERFACE = 'SR\Reflection\Tests\Helper\FixtureInterface';

    public function testInvalidConstructorArguments()
    {
        $this->expectException('SR\Reflection\Exception\InvalidArgumentException');
        new InterfaceInspector('SR\Reflection\Tests\Helper\Interface\That\Does\Not\Exist');
    }

    public function testExport()
    {
        $export = InterfaceInspector::export(self::TEST_INTERFACE);
        $this->assertRegExp('{Interface \[ <user> interface [^\s]+ \] \{}', $export);

        $this->expectException('SR\Reflection\Exception\InvalidArgumentException');
        InterfaceInspector::export('SR\Reflection\Tests\Helper\Interface\That\Does\Not\Exist');
    }

    public function testName()
    {
        $inspect = new InterfaceInspector(self::TEST_INTERFACE);
        $this->assertSame(self::TEST_INTERFACE, $inspect->nameQualified());
        $this->assertSame(self::TEST_INTERFACE, $inspect->name(true));
        $this->assertSame(preg_replace('{.*\\\}', '', self::TEST_INTERFACE), $inspect->nameUnQualified());
        $this->assertSame(preg_replace('{.*\\\}', '', self::TEST_INTERFACE), $inspect->name());
    }

    public function testConstants()
    {
        $inspect = new InterfaceInspector(self::TEST_INTERFACE);
        $constants = $inspect->constants();
        $this->assertCount(1, $constants);
    }

    public function testDocBlock()
    {
        $inspect = new InterfaceInspector(self::TEST_INTERFACE);
        $result = $inspect->docBlock();
        $this->assertRegExp('{Class FixtureInterface}', $result);
    }

    public function testModifiers()
    {
        $_ = new InterfaceInspector(self::TEST_INTERFACE);
        $this->assertTrue('integer' === gettype($_->modifiers()));
        $this->assertTrue($_->isAbstract());
        $this->assertFalse($_->isTrait());
        $this->assertFalse($_->isIterateable());
        $this->assertFalse($_->isAnonymous());
        $this->assertFalse($_->isClonable());
        $this->assertFalse($_->isFinal());
        $this->assertFalse($_->isInternal());
        $this->assertTrue($_->isUserDefined());
        $this->assertFalse($_->isInstantiable());
        $this->assertTrue($_->isInterface());
    }
}

/* EOF */
