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

/**
 * Class IdentityAwareAccessorsInterface.
 */
interface IdentityAwareAccessorsInterface
{
    /**
     * @return \ReflectionClass
     */
    public function reflection();

    /**
     * @return string
     */
    public function name();

    /**
     * @return string
     */
    public function namespace();

    /**
     * @return string[]
     */
    public function namespaceSections();

    /**
     * @return string
     */
    public function nameQualified();

    /**
     * @return string
     */
    public function nameUnQualified();

    /**
     * @param object|string $class
     *
     * @return bool
     */
    public function extends($class);

    /**
     * @param string $interface
     *
     * @return bool
     */
    public function implements($interface);

    /**
     * @param string $trait
     *
     * @return bool
     */
    public function uses($trait);
}

/* EOF */
