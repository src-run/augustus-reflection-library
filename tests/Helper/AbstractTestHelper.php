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

namespace SR\Reflection\Tests\Helper;

use SR\Reflection\Introspection\ClassIntrospection;
use SR\Reflection\Introspection\ObjectIntrospection;

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
    protected function getClassnameQualified($className = null)
    {
        if (static::TEST_CLASS === null) {
            $this->fail(sprintf('%s::TEST_CLASS must be set to the testing class name.', static::TEST_NAMESPACE));
        }

        return static::TEST_NAMESPACE.($className !== null ? $className : static::TEST_CLASS);
    }

    /**
     * @param array $parameters
     *
     * @return object
     */
    protected function setUpInstance(array $parameters = [])
    {
        $_fqcn = $this->getClassnameQualified();

        self::$instance = $_fqcn(...$parameters);

        return self::$instance;
    }

    protected function getFixtureClassNamesAbsolute()
    {
        return [
            $this->getClassnameQualified('\Tests\Helper\FixtureClassOne'),
            $this->getClassnameQualified('\Tests\Helper\FixtureClassTwo'),
            $this->getClassnameQualified('\Tests\Helper\FixtureClassThree'),
        ];
    }

    /**
     * @return ClassIntrospection[]|ObjectIntrospection[]
     */
    protected function getFixtureInstances($one = null, $two = null, $three = null)
    {
        $_ = $this->getClassnameQualified();
        list($_1, $_2, $_3) = $this->getFixtureClassNamesAbsolute();

        return [
            new $_($one ?: $_1),
            new $_($two ?: $_2),
            new $_($three ?: $_3),
        ];
    }
}

/* EOF */
