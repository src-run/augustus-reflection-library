<?php

/*
 * This file is part of the `src-run/augustus-reflection-library` project.
 *
 * (c) Rob Frawley 2nd <rmf@src.run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace SR\Reflection\Resolver;

interface ResolverInterface
{
    /**
     * @param \Reflector[] $items
     * @param mixed        ...$extra
     *
     * @return \Reflector[]
     */
    public function sort(array $items, \Closure $sort, &...$extra);

    /**
     * @param \Reflector[] $items
     * @param mixed        ....$extra
     *
     * @return mixed[]
     */
    public function visit(array $items, \Closure $visit, &...$extra);

    /**
     * @param \Reflector[] $items
     * @param mixed        ...$extra
     *
     * @return \Reflector[]
     */
    public function filter(array $items, \Closure $predicate, &...$extra);

    /**
     * @param \Reflector[] $items
     * @param mixed        ...$extra
     *
     * @return \Reflector
     */
    public function filterOne(array $items, \Closure $predicate, &...$extra);

    /**
     * @param \Reflector[] $items
     * @param mixed        $match
     * @param string       $method
     *
     * @return \Reflector[]
     */
    public function match(array $items, $match, $method = '__toString');

    /**
     * @param \Reflector[] $items
     * @param mixed        $match
     * @param string       $method
     *
     * @return \Reflector[]
     */
    public function matchOne(array $items, $match, $method = '__toString');

    /**
     * @param object|null $scope
     *
     * @return $this
     */
    public function bind($scope = null);
}
