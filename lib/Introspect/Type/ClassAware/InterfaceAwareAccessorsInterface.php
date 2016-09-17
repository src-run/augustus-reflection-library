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

use SR\Reflection\Introspect\InterfaceIntrospect;

/**
 * Class InterfaceAwareAccessorsInterface.
 */
interface InterfaceAwareAccessorsInterface
{
    /**
     * @param string $name
     *
     * @return InterfaceIntrospect
     */
    public function getInterface($name);

    /**
     * @param string $name
     *
     * @return InterfaceIntrospect[]
     */
    public function interfaces();

    /**
     * @param \Closure $sort
     * @param mixed ...$extra
     *
     * @return InterfaceIntrospect[]
     */
    public function sortInterfaces(\Closure $sort, &...$extra);

    /**
     * @param \Closure $visit
     * @param mixed ...$extra
     *
     * @return InterfaceIntrospect[]|mixed
     */
    public function visitInterfaces(\Closure $visit, &...$extra);

    /**
     * @param \Closure $predicate
     * @param mixed ...$extra
     *
     * @return InterfaceIntrospect[]
     */
    public function filterInterfaces(\Closure $predicate, &...$extra);

    /**
     * @param \Closure $predicate
     * @param mixed ...$extra
     *
     * @return InterfaceIntrospect|null
     */
    public function filterOneInterface(\Closure $predicate, &...$extra);

    /**
     * @param mixed  $match
     * @param string $func
     *
     * @return InterfaceIntrospect[]
     */
    public function matchInterfaces($match, $func = '__toString');

    /**
     * @param mixed  $match
     * @param string $func
     *
     * @return null|InterfaceIntrospect
     */
    public function matchOneInterface($match, $func = '__toString');
}

/* EOF */
