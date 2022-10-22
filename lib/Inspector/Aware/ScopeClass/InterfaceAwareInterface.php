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

use SR\Reflection\Inspector\InterfaceInspector;

interface InterfaceAwareInterface
{
    /**
     * @param string $name
     *
     * @return InterfaceInspector
     */
    public function getInterface($name);

    /**
     * @param string $name
     *
     * @return InterfaceInspector[]
     */
    public function interfaces();

    /**
     * @param mixed ...$extra
     *
     * @return InterfaceInspector[]
     */
    public function sortInterfaces(\Closure $sort, &...$extra);

    /**
     * @param mixed ...$extra
     *
     * @return InterfaceInspector[]|mixed
     */
    public function visitInterfaces(\Closure $visit, &...$extra);

    /**
     * @param mixed ...$extra
     *
     * @return InterfaceInspector[]
     */
    public function filterInterfaces(\Closure $predicate, &...$extra);

    /**
     * @param mixed ...$extra
     *
     * @return InterfaceInspector|null
     */
    public function filterOneInterface(\Closure $predicate, &...$extra);

    /**
     * @param mixed  $match
     * @param string $func
     *
     * @return InterfaceInspector[]
     */
    public function matchInterfaces($match, $func = '__toString');

    /**
     * @param mixed  $match
     * @param string $func
     *
     * @return InterfaceInspector|null
     */
    public function matchOneInterface($match, $func = '__toString');
}
