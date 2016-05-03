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

use SR\Reflection\Introspection\InterfaceIntrospection;

/**
 * Class InterfaceAwareAccessorsInterface.
 */
interface InterfaceAwareAccessorsInterface
{
    /**
     * @param string $name
     *
     * @return InterfaceIntrospection
     */
    public function getInterface($name);

    /**
     * @param string $name
     *
     * @return InterfaceIntrospection[]
     */
    public function interfaces();

    /**
     * @param \Closure $sort
     * @param mixed ...$extra
     *
     * @return InterfaceIntrospection[]
     */
    public function sortInterfaces(\Closure $sort, &...$extra);
    /**
     * @param \Closure $visit
     * @param mixed ...$extra
     *
     * @return InterfaceIntrospection[]|mixed
     */
    public function visitInterfaces(\Closure $visit, &...$extra);

    /**
     * @param \Closure $predicate
     * @param mixed ...$extra
     *
     * @return InterfaceIntrospection[]
     */
    public function filterInterfaces(\Closure $predicate, &...$extra);

    /**
     * @param \Closure $predicate
     * @param mixed ...$extra
     *
     * @return InterfaceIntrospection|null
     */
    public function filterOneInterface(\Closure $predicate, &...$extra);

    /**
     * @param mixed $match
     * @param string $func
     *
     * @return InterfaceIntrospection[]
     */
    public function matchInterfaces($match, $func = '__toString');

    /**
     * @param mixed $match
     * @param string $func
     *
     * @return null|InterfaceIntrospection
     */
    public function matchOneInterface($match, $func = '__toString');
}

/* EOF */
