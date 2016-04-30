<?php

/*
 * This file is part of the `src-run/wonka-library` project.
 *
 * (c) Rob Frawley 2nd <rmf@src.run>
 * (c) Scribe Inc      <scr@src.run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace SR\Reflection\Introspection\Type\ClassAware;

use SR\Exception\InvalidArgumentException;
use SR\Reflection\Introspection\Resolver\ResolverInterface;

/**
 * Class MethodAwareAccessorsInterface.
 */
interface MethodAwareAccessorsInterface
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
    public function hasMethod($name);

    /**
     * @param string $name
     *
     * @throws InvalidArgumentException
     *
     * @return \ReflectionMethod
     */
    public function getMethod($name);

    /**
     * @param null|int $mask
     *
     * @return \ReflectionMethod[]
     */
    public function methods($mask = null);

    /**
     * @return \ReflectionMethod[]
     */
    public function publicMethods();

    /**
     * @return \ReflectionMethod[]
     */
    public function protectedMethods();

    /**
     * @return \ReflectionMethod[]
     */
    public function privateMethods();

    /**
     * @param \Closure $sort
     * @param null|int $mask
     * @param mixed    ...$extra
     *
     * @return \ReflectionMethod[]
     */
    public function sortMethods(\Closure $sort, $mask = null, &...$extra);

    /**
     * @param \Closure $visit
     * @param null|int $mask
     * @param mixed    ...$extra
     *
     * @return \ReflectionMethod[]|mixed
     */
    public function visitMethods(\Closure $visit, $mask = null, &...$extra);

    /**
     * @param \Closure $predicate
     * @param null|int $mask
     * @param mixed    ...$extra
     *
     * @return \ReflectionMethod[]
     */
    public function filterMethods(\Closure $predicate, $mask = null, &...$extra);

    /**
     * @param \Closure $predicate
     * @param null|int $mask
     * @param mixed    ...$extra
     *
     * @return \ReflectionMethod|null
     */
    public function filterOneMethod(\Closure $predicate, $mask = null, &...$extra);

    /**
     * @param mixed    $match
     * @param string   $func
     * @param null|int $mask
     *
     * @return \ReflectionMethod[]
     */
    public function matchMethods($match, $func = '__toString', $mask = null);

    /**
     * @param mixed    $match
     * @param string   $func
     * @param null|int $mask
     *
     * @return null|\ReflectionMethod
     */
    public function matchOneMethod($match, $func = '__toString', $mask = null);
}

/* EOF */
