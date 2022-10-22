<?php

/*
 * This file is part of the `src-run/augustus-reflection-library` project.
 *
 * (c) Rob Frawley 2nd <rmf@src.run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace SR\Reflection\Inspector\Aware\ScopeClass;

use SR\Reflection\Exception\InvalidArgumentException;
use SR\Reflection\Resolver\ResolverInterface;

interface PropertyAwareInterface
{
    /**
     * @return \ReflectionClass
     */
    public function reflection();

    /**
     * @return ResolverInterface
     */
    public function resolver();

    /**
     * @param string $name
     *
     * @return bool
     */
    public function hasProperty($name);

    /**
     * @param string $name
     *
     * @throws InvalidArgumentException
     *
     * @return \ReflectionProperty
     */
    public function getProperty($name);

    /**
     * @param int|null $mask
     *
     * @return \ReflectionProperty[]
     */
    public function properties($mask = null);

    /**
     * @return \ReflectionProperty[]
     */
    public function publicProperties();

    /**
     * @return \ReflectionProperty[]
     */
    public function protectedProperties();

    /**
     * @return \ReflectionProperty[]
     */
    public function privateProperties();

    /**
     * @param int|null $mask
     * @param mixed    ...$extra
     *
     * @return \ReflectionProperty[]
     */
    public function sortProperties(\Closure $sort, $mask = null, &...$extra);

    /**
     * @param int|null $mask
     * @param mixed    ...$extra
     *
     * @return \ReflectionProperty[]|mixed[]
     */
    public function visitProperties(\Closure $visit, $mask = null, &...$extra);

    /**
     * @param int|null $mask
     * @param mixed    ...$extra
     *
     * @return \ReflectionProperty[]
     */
    public function filterProperties(\Closure $predicate, $mask = null, &...$extra);

    /**
     * @param int|null $mask
     * @param mixed    ...$extra
     *
     * @return \ReflectionProperty|null
     */
    public function filterOneProperty(\Closure $predicate, $mask = null, &...$extra);

    /**
     * @param mixed    $match
     * @param string   $func
     * @param int|null $mask
     *
     * @return \ReflectionProperty[]
     */
    public function matchProperties($match, $func = '__toString', $mask = null);

    /**
     * @param mixed    $match
     * @param string   $func
     * @param int|null $mask
     *
     * @return \ReflectionProperty|null
     */
    public function matchOneProperty($match, $func = '__toString', $mask = null);
}
