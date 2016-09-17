<?php

/*
 * This file is part of the `src-run/augustus-reflection-library` project.
 *
 * (c) Rob Frawley 2nd <rmf@src.run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace SR\Reflection\Introspect\Type\ClassAware;

use SR\Exception\InvalidArgumentException;
use SR\Reflection\Introspect\ConstantIntrospect;
use SR\Reflection\Introspect\Resolver\ResolverInterface;

/**
 * Class ConstantAwareAccessorsInterface.
 */
interface ConstantAwareAccessorsInterface
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
    public function hasConstant($name);

    /**
     * @param string $name
     *
     * @throws InvalidArgumentException
     *
     * @return ConstantIntrospect
     */
    public function getConstant($name);

    /**
     * @return ConstantIntrospect[]
     */
    public function constants();

    /**
     * @param \Closure $sort
     * @param mixed    ...$extra
     *
     * @return ConstantIntrospect[]
     */
    public function sortConstants(\Closure $sort, &...$extra);

    /**
     * @param \Closure $visit
     * @param mixed    ...$extra
     *
     * @return ConstantIntrospect[]|mixed[]
     */
    public function visitConstants(\Closure $visit, &...$extra);

    /**
     * @param \Closure $predicate
     * @param mixed    ...$extra
     *
     * @return ConstantIntrospect[]
     */
    public function filterConstants(\Closure $predicate, &...$extra);

    /**
     * @param \Closure $predicate
     * @param mixed      ...$extra
     *
     * @return null|ConstantIntrospect
     */
    public function filterOneConstant(\Closure $predicate, &...$extra);

    /**
     * @param mixed  $match
     * @param string $func
     *
     * @return ConstantIntrospect[]
     */
    public function matchConstants($match, $func = '__toString');

    /**
     * @param mixed  $match
     * @param string $func
     *
     * @return null|ConstantIntrospect
     */
    public function matchOneConstant($match, $func = '__toString');
}

/* EOF */
