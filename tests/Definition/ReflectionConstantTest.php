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
use SR\Reflection\Definition\ReflectionConstant;

/**
 * Class ReflectionConstantTest.
 *
 * @covers \SR\Reflection\Definition\ReflectionConstant
 */
class ReflectionConstantTest extends TestCase
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
        new ReflectionConstant(self::TEST_CLASS, 'CONSTANT_DOES_NOT_EXIST');
    }

    public function testExport()
    {
        foreach (self::TEST_NAMES as $constant) {
            ob_start();
            ReflectionConstant::export(self::TEST_CLASS, $constant);
            $export = ob_get_contents();
            ob_end_clean();
            $this->assertMatchesRegularExpression('{Constant \[ (string|NULL|integer|array) [A-Za-z0-9_:\\\\]+ \] \{' . "\n" . '  [^' . "\n" . ']+' . "\n" . '\}}', $export);
        }

        $this->expectException('SR\Reflection\Exception\InvalidArgumentException');
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
            $this->assertSame(constant(self::TEST_CLASS . '::' . $constant), $reflectionConstant->getValue());
        }
    }
}

/* EOF */
