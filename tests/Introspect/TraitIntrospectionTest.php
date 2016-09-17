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
use SR\Reflection\Inspector\MethodInspector;
use SR\Reflection\Inspector\TraitInspector;
use SR\Reflection\Tests\Helper\FixtureTrait;
use SR\Reflection\Tests\Helper\FixtureTraitThree;

/**
 * Class TraitIntrospectionTest.
 */
class TraitIntrospectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var string
     */
    const TEST_TRAIT = FixtureTrait::class;

    public function testInvalidConstructorArguments()
    {
        $this->expectException(InvalidArgumentException::class);
        new TraitInspector('\SR\Reflection\Tests\Does\Not\Exist\Trait');
    }

    public function testExport()
    {
        $export = TraitInspector::export(self::TEST_TRAIT);
        $this->assertRegExp('{Trait \[ <[a-z]+> trait [a-zA-Z\\\]+ \]}', $export);
    }

    public function testDocBlock()
    {
        $inspect = new TraitInspector(self::TEST_TRAIT);
        $docBlock = $inspect->docBlock();
        $this->assertRegExp('{\* Class FixtureTrait\.}', $docBlock);
    }

    public function testModifiers()
    {
        $_ = new TraitInspector(self::TEST_TRAIT);
        $this->assertTrue(gettype($_->modifiers()) === 'integer');
        if (PHP_VERSION_ID < 70000) {
            $this->assertTrue($_->isAbstract());
        } else {
            $this->assertFalse($_->isAbstract());
        }
        $this->assertTrue($_->isTrait());
        $this->assertFalse($_->isIterateable());
        $this->assertFalse($_->isAnonymous());
        $this->assertFalse($_->isClonable());
        $this->assertFalse($_->isFinal());
        $this->assertFalse($_->isInternal());
        $this->assertTrue($_->isUserDefined());
        $this->assertFalse($_->isInstantiable());
        $this->assertFalse($_->isInterface());
    }

    public function testMethodAccessors()
    {
        $inspector = new TraitInspector(FixtureTraitThree::class);
        $methodNames = $inspector->visitMethods(function (MethodInspector $method) {
            return $method->nameUnQualified();
        });

        $expectedMethods = [
            'methodIsPublic',
            'methodIsProtected',
            'methodIsPrivate',
        ];

        $this->assertSame($expectedMethods, $methodNames);
    }
}

/* EOF */
