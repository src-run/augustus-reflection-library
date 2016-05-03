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

use SR\Reflection\Introspection\TraitIntrospection;

/**
 * Class TraitIntrospectionTest.
 */
class TraitIntrospectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var string
     */
    const TEST_TRAIT = '\SR\Reflection\Tests\Helper\FixtureTrait';

    public function testInvalidConstructorArguments()
    {
        $this->expectException('SR\Exception\InvalidArgumentException');
        new TraitIntrospection('\SR\Reflection\Tests\Does\Not\Exist\Trait');
    }

    public function testExport()
    {
        $export = TraitIntrospection::export(self::TEST_TRAIT);
        $this->assertRegExp('{Trait \[ <[a-z]+> trait [a-zA-Z\\\]+ \]}', $export);
    }

    public function testDocBlock()
    {
        $inspect = new TraitIntrospection(self::TEST_TRAIT);
        $docBlock = $inspect->docBlock();
        $this->assertRegExp('{\* Class FixtureTrait\.}', $docBlock);
    }

    public function testModifiers()
    {
        $_ = new TraitIntrospection(self::TEST_TRAIT);
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
}

/* EOF */
