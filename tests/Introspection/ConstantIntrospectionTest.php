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

use SR\Reflection\Introspection\ConstantIntrospection;

/**
 * Class ConstantIntrospectionTest.
 */
class ConstantIntrospectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var string
     */
    const TEST_CLASS = 'SR\Reflection\Tests\Helper\FixtureClassConstants';

    /**
     * @var string
     */
    const TEST_NAME_1 = 'CONSTANT_STRING';

    /**
     * @var string
     */
    const TEST_NAME_2 = 'CONSTANT_INT';

    /**
     * @var string
     */
    const TEST_NAME_3 = 'CONSTANT_NULL';

    /**
     * @var string
     */
    const TEST_NAME_4 = 'CONSTANT_ARRAY';

    /**
     * @var string[]
     */
    const TEST_NAMES = [
        self::TEST_NAME_1,
        self::TEST_NAME_2,
        self::TEST_NAME_3,
        self::TEST_NAME_4,
    ];

    public function testInvalidConstructorArguments()
    {
        $this->expectException('SR\Exception\InvalidArgumentException');
        new ConstantIntrospection(self::TEST_CLASS, 'CONSTANT_DOES_NOT_EXIST');
    }

    public function testExport()
    {
        foreach (self::TEST_NAMES as $constant) {
            $export = ConstantIntrospection::export(self::TEST_CLASS, $constant);
            $this->assertRegExp('{Constant \[ (string|NULL|integer|array) [A-Za-z0-9_:\\\\]+ \] \{'."\n".'  [^'."\n".']+'."\n".'\}}', $export);
        }

        $this->expectException('SR\Exception\InvalidArgumentException');
        ConstantIntrospection::export(self::TEST_CLASS, 'CONSTANT_DOES_NOT_EXIST');
    }

    public function testDeclaringClass()
    {
        foreach (self::TEST_NAMES as $constant) {
            $inspect = new ConstantIntrospection(self::TEST_CLASS, $constant);
            $this->assertSame(self::TEST_CLASS, $inspect->declaringClass()->nameQualified());
            $this->assertInstanceOf('\ReflectionClass', $inspect->reflectionDeclaringClass());
        }
    }
}

/* EOF */
