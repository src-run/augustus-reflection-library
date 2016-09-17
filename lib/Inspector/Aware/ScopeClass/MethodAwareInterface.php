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
use SR\Reflection\Inspector\MethodInspector;
use SR\Reflection\Resolver\ResolverInterface;

/**
 * Class MethodAwareInterface.
 */
interface MethodAwareInterface
{
    /**
     * @return \ReflectionClass|\ReflectionObject
     */
    public function reflection();

    /**
     * @return ResolverInterface
     */
    public function resolver();

    /**
     * Returns true if the method exists.
     *
     * @param string $method
     *
     * @return bool
     */
    public function hasMethod($method);

    /**
     * Returns a method introspection instance.
     *
     * @param string $method
     *
     * @throws InvalidArgumentException
     *
     * @return MethodInspector
     */
    public function getMethod($method);

    /**
     * Returns set of methods using mask.
     *
     * @param null|int $mask
     *
     * @return MethodInspector[]
     */
    public function getMethods($mask = null);

    /**
     * Returns set of public methods.
     *
     * @return MethodInspector[]
     */
    public function getMethodsPublic();

    /**
     * Returns set of protected methods.
     *
     * @return MethodInspector[]
     */
    public function getMethodsProtected();

    /**
     * Returns set of private methods.
     *
     * @return MethodInspector[]
     */
    public function getMethodsPrivate();

    /**
     * Sort methods using closure.
     *
     * @param \Closure $sorter
     * @param null|int $mask
     * @param mixed    ...$parameters
     *
     * @return MethodInspector[]|\Reflector[]
     */
    public function sortMethods(\Closure $sorter, $mask = null, &...$parameters);

    /**
     * Visit methods using closure and return result.
     *
     * @param \Closure $visitor
     * @param null|int $mask
     * @param mixed    ...$parameters
     *
     * @return MethodInspector[]|\Reflector[]|mixed[]
     */
    public function visitMethods(\Closure $visitor, $mask = null, &...$parameters);

    /**
     * Filter methods using closure.
     *
     * @param \Closure $filter
     * @param null|int $mask
     * @param mixed    ...$parameters
     *
     * @return MethodInspector[]|\Reflector[]
     */
    public function filterMethods(\Closure $filter, $mask = null, &...$parameters);

    /**
     * Filter methods using closure, expecting a single result.
     *
     * @param \Closure $filter
     * @param null|int $mask
     * @param mixed    ...$parameters
     *
     * @return MethodInspector|\Reflector|null
     */
    public function filterOneMethod(\Closure $filter, $mask = null, &...$parameters);

    /**
     * Filter methods against provided value and result of calling method on the method introspection instance.
     *
     * @param mixed    $against
     * @param string   $method
     * @param null|int $mask
     *
     * @return MethodInspector[]|\Reflector[]
     */
    public function matchMethods($against, $method = '__toString', $mask = null);

    /**
     * Perform same operations as {@see matchMethods()} but expect a single value to be returned.
     *
     * @param mixed    $match
     * @param string   $method
     * @param null|int $mask
     *
     * @return MethodInspector|\Reflector[]|null
     */
    public function matchOneMethod($match, $method = '__toString', $mask = null);
}

/* EOF */
