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
    public function className();

    /**
     * @return string
     */
    public function classNamespace();

    /**
     * @return string
     */
    public function classNameAbsolute();

    /**
     * @param object|string $class
     *
     * @return bool
     */
    public function extendsClass($class);

    /**
     * @param string $interface
     *
     * @return bool
     */
    public function implementsInterface($interface);

    /**
     * @param string $trait
     *
     * @return bool
     */
    public function usesTrait($trait);
}

/* EOF */
