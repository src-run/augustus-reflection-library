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

use SR\Reflection\Definition\ReflectionConstant;

/**
 * Class ReflectionConstantTest.
 */
class ReflectionConstantTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var string
     */
    const TEST_CLASS = 'SR\Reflection\Tests\Helper\FixtureClassOne';

    /**
     * @var string
     */
    const TEST_NAME_1 = 'ONE_0';

    /**
     * @var string
     */
    const TEST_NAME_2 = 'ONE_1';

    /**
     * @var string
     */
    const TEST_NAME_3 = 'ONE_2';

    /**
     * @var string
     */
    const TEST_NAME_4 = 'NULL_CONST';

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
        new ReflectionConstant(self::TEST_CLASS, 'CONSTANT_DOES_NOT_EXIST');
    }

    public function testExport()
    {
        foreach (self::TEST_NAMES as $constant) {
            ob_start();
            ReflectionConstant::export(self::TEST_CLASS, $constant);
            $export = ob_get_contents();
            ob_end_clean();
            $this->assertRegExp('{Constant \[ (string|NULL|integer|array) [A-Za-z0-9_:\\\\]+ \] \{'."\n".'  [^'."\n".']+'."\n".'\}}', $export);
        }

        $this->expectException('SR\Exception\InvalidArgumentException');
        ReflectionConstant::export(self::TEST_CLASS, 'CONSTANT_DOES_NOT_EXIST');
    }

    public function testDeclaringContext()
    {
        foreach (self::TEST_NAMES as $constant) {
            $reflectionConstant = new ReflectionConstant(self::TEST_CLASS, $constant);
            $this->assertSame(self::TEST_CLASS, $reflectionConstant->getDeclaringContext());
        }
    }

    public function testToString()
    {
        foreach (self::TEST_NAMES as $constant) {
            $reflectionConstant = new ReflectionConstant(self::TEST_CLASS, $constant);
            $this->assertSame($constant, (string) $reflectionConstant);
        }
    }

    public function testGetValue()
    {
        foreach (self::TEST_NAMES as $constant) {
            $reflectionConstant = new ReflectionConstant(self::TEST_CLASS, $constant);
            $this->assertSame(constant(self::TEST_CLASS.'::'.$constant), $reflectionConstant->getValue());
        }
    }
}

/* EOF */
