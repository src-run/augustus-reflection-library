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
use SR\Reflection\Introspection\ConstantIntrospection;
use SR\Reflection\Introspection\Resolver\ResolverInterface;

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
     * @return ConstantIntrospection
     */
    public function getConstant($name);

    /**
     * @return ConstantIntrospection[]
     */
    public function constants();

    /**
     * @param \Closure $sort
     * @param mixed    ...$extra
     *
     * @return ConstantIntrospection[]
     */
    public function sortConstants(\Closure $sort, &...$extra);

    /**
     * @param \Closure $visit
     * @param mixed    ...$extra
     *
     * @return ConstantIntrospection[]|mixed[]
     */
    public function visitConstants(\Closure $visit, &...$extra);

    /**
     * @param \Closure $predicate
     * @param mixed    ...$extra
     *
     * @return ConstantIntrospection[]
     */
    public function filterConstants(\Closure $predicate, &...$extra);

    /**
     * @param \Closure $predicate
     * @param mixed      ...$extra
     *
     * @return null|ConstantIntrospection
     */
    public function filterOneConstant(\Closure $predicate, &...$extra);

    /**
     * @param mixed  $match
     * @param string $func
     *
     * @return ConstantIntrospection[]
     */
    public function matchConstants($match, $func = '__toString');

    /**
     * @param mixed  $match
     * @param string $func
     *
     * @return null|ConstantIntrospection
     */
    public function matchOneConstant($match, $func = '__toString');
}

/* EOF */
