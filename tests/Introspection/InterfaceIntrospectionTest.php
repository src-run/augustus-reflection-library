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

use SR\Reflection\Introspection\InterfaceIntrospection;

/**
 * Class InterfaceIntrospectionTest.
 */
class InterfaceIntrospectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var string
     */
    const TEST_INTERFACE = 'SR\Reflection\Tests\Helper\FixtureInterface';

    public function testInvalidConstructorArguments()
    {
        $this->expectException('SR\Exception\InvalidArgumentException');
        new InterfaceIntrospection('SR\Reflection\Tests\Helper\Interface\That\Does\Not\Exist');
    }

    public function testExport()
    {
        $export = InterfaceIntrospection::export(self::TEST_INTERFACE);
        $this->assertRegExp('{Interface \[ <user> interface [^\s]+ \] \{}', $export);

        $this->expectException('SR\Exception\InvalidArgumentException');
        InterfaceIntrospection::export('SR\Reflection\Tests\Helper\Interface\That\Does\Not\Exist');
    }

    public function testName()
    {
        $inspect = new InterfaceIntrospection(self::TEST_INTERFACE);
        $this->assertSame(self::TEST_INTERFACE, $inspect->nameQualified());
        $this->assertSame(self::TEST_INTERFACE, $inspect->name(true));
        $this->assertSame(preg_replace('{.*\\\}', '', self::TEST_INTERFACE), $inspect->nameUnQualified());
        $this->assertSame(preg_replace('{.*\\\}', '', self::TEST_INTERFACE), $inspect->name());
    }

    public function testConstants()
    {
        $inspect = new InterfaceIntrospection(self::TEST_INTERFACE);
        $constants = $inspect->constants();
        $this->assertCount(1, $constants);
    }

    public function testDocBlock()
    {
        $inspect = new InterfaceIntrospection(self::TEST_INTERFACE);
        $result = $inspect->docBlock();
        $this->assertRegExp('{Class FixtureInterface}', $result);
    }

    public function testModifiers()
    {
        $_ = new InterfaceIntrospection(self::TEST_INTERFACE);
        $this->assertTrue(gettype($_->modifiers()) === 'integer');
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