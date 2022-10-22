<?php

/*
 * This file is part of the `src-run/augustus-reflection-library` project.
 *
 * (c) Rob Frawley 2nd <rmf@src.run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace SR\Reflection\Tests\Helper;

use PHPUnit\Framework\TestCase;
use SR\Reflection\Inspector\ClassInspector;
use SR\Reflection\Inspector\ObjectInspector;

/**
 * Class AbstractTestHelper.
 */
abstract class AbstractTestHelper extends TestCase
{
    /**
     * @var string|null
     */
    public const TEST_CLASS = null;

    /**
     * @var string
     */
    public const TEST_NAMESPACE = 'SR\Reflection';

    /**
     * @var null
     */
    protected static $instance = null;

    /**
     * @param string|null $className
     *
     * @return string
     */
    protected function getClassNameQualified($className = null)
    {
        if (null === static::TEST_CLASS) {
            $this->fail(sprintf('%s::TEST_CLASS must be set to the testing class name.', static::TEST_NAMESPACE));
        }

        if (null === $className) {
            $className = static::TEST_CLASS;
        }

        if (false !== mb_strpos($className, self::TEST_NAMESPACE)) {
            return $className;
        }

        return static::TEST_NAMESPACE . $className;
    }

    /**
     * @return object
     */
    protected function setUpInstance(array $parameters = [])
    {
        $_fqcn = $this->getClassNameQualified();

        return self::$instance = $_fqcn(...$parameters);
    }

    protected function getFixtureClassNamesAbsolute()
    {
        return [
            FixtureClassOne::class,
            FixtureClassTwo::class,
            FixtureClassThree::class,
        ];
    }

    /**
     * @return ClassInspector[]|ObjectInspector[]
     */
    protected function getFixtureInstances($one = null, $two = null, $three = null)
    {
        $_ = $this->getClassNameQualified();
        [$_1, $_2, $_3] = $this->getFixtureClassNamesAbsolute();

        return [
            new $_($one ?: $_1),
            new $_($two ?: $_2),
            new $_($three ?: $_3),
        ];
    }
}

/* EOF */
