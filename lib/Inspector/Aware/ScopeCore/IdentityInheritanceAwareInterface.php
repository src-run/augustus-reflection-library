<?php

/*
 * This file is part of the `src-run/augustus-reflection-library` project.
 *
 * (c) Rob Frawley 2nd <rmf@src.run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace SR\Reflection\Inspector\Aware\ScopeCore;

interface IdentityInheritanceAwareInterface
{
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
