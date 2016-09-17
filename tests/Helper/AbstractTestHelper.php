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

use SR\Reflection\Introspect\ClassIntrospect;
use SR\Reflection\Introspect\ObjectIntrospect;

/**
 * Class AbstractTestHelper.
 */
abstract class AbstractTestHelper extends \PHPUnit_Framework_TestCase
{
    /**
     * @var string|null
     */
    const TEST_CLASS = null;

    /**
     * @var string
     */
    const TEST_NAMESPACE = 'SR\Reflection';

    /**
     * @var null
     */
    protected static $instance = null;

    /**
     * @param null|string $className
     *
     * @return string
     */
    protected function getClassNameQualified($className = null)
    {
        if (static::TEST_CLASS === null) {
            $this->fail(sprintf('%s::TEST_CLASS must be set to the testing class name.', static::TEST_NAMESPACE));
        }

        if ($className === null) {
            $className = static::TEST_CLASS;
        }

        if (strpos($className, self::TEST_NAMESPACE) !== false) {
            return $className;
        }

        return static::TEST_NAMESPACE.$className;
    }

    /**
     * @param array $parameters
     *
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
     * @return ClassIntrospect[]|ObjectIntrospect[]
     */
    protected function getFixtureInstances($one = null, $two = null, $three = null)
    {
        $_ = $this->getClassNameQualified();
        list($_1, $_2, $_3) = $this->getFixtureClassNamesAbsolute();

        return [
            new $_($one ?: $_1),
            new $_($two ?: $_2),
            new $_($three ?: $_3),
        ];
    }
}

/* EOF */
