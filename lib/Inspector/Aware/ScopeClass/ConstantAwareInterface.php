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
use SR\Reflection\Inspector\ConstantInspector;
use SR\Reflection\Resolver\ResolverInterface;

interface ConstantAwareInterface
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
     * @return ConstantInspector
     */
    public function getConstant($name);

    /**
     * @return ConstantInspector[]
     */
    public function constants();

    /**
     * @param \Closure $sort
     * @param mixed    ...$extra
     *
     * @return ConstantInspector[]
     */
    public function sortConstants(\Closure $sort, &...$extra);

    /**
     * @param \Closure $visit
     * @param mixed    ...$extra
     *
     * @return ConstantInspector[]|mixed[]
     */
    public function visitConstants(\Closure $visit, &...$extra);

    /**
     * @param \Closure $predicate
     * @param mixed    ...$extra
     *
     * @return ConstantInspector[]
     */
    public function filterConstants(\Closure $predicate, &...$extra);

    /**
     * @param \Closure $predicate
     * @param mixed    ...$extra
     *
     * @return null|ConstantInspector
     */
    public function filterOneConstant(\Closure $predicate, &...$extra);

    /**
     * @param mixed  $match
     * @param string $func
     *
     * @return ConstantInspector[]
     */
    public function matchConstants($match, $func = '__toString');

    /**
     * @param mixed  $match
     * @param string $func
     *
     * @return null|ConstantInspector
     */
    public function matchOneConstant($match, $func = '__toString');
}
