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

use SR\Reflection\Inspector\Aware\ScopeCore\ModifiersAwareInterface as BaseModifiersAwareInterface;

interface ModifiersAwareInterface extends BaseModifiersAwareInterface
{
    /**
     * @return bool
     */
    public function isAnonymous();

    /**
     * @return bool
     */
    public function isClonable();

    /**
     * @return bool
     */
    public function isInstance($instance);

    /**
     * @return bool
     */
    public function isInstantiable();

    /**
     * @return bool
     */
    public function isInterface();

    /**
     * @return bool
     */
    public function isIterateable();

    /**
     * @return bool
     */
    public function isTrait();

    /**
     * @return bool
     */
    public function isAbstract();

    /**
     * @return bool
     */
    public function isFinal();

    /**
     * @return bool
     */
    public function isInternal();

    /**
     * @return bool
     */
    public function isUserDefined();
}
