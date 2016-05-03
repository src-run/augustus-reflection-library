<?php

/*
 * This file is part of the `augustus-reflection-library` project.
 *
 * (c) 2016 Rob Frawley 2nd(rmf) <rmf AT src DOT run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace SR\Reflection\Introspection\Type\ClassAware;

use SR\Reflection\Introspection\Type\Aware\ModifiersAwareAccessorsInterface as BaseModifiersAwareAccessorsInterface;

/**
 * Class ModifiersAwareAccessorsInterface.
 */
interface ModifiersAwareAccessorsInterface extends BaseModifiersAwareAccessorsInterface
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

/* EOF */
