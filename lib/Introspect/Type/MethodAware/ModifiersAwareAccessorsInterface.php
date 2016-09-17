<?php

/*
 * This file is part of the `src-run/augustus-reflection-library` project.
 *
 * (c) Rob Frawley 2nd <rmf@src.run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace SR\Reflection\Introspect\Type\MethodAware;

use SR\Reflection\Introspect\Type\Aware\ModifiersAwareAccessorsInterface as BaseModifiersAwareAccessorsInterface;

/**
 * Class ModifiersAwareAccessorsInterface.
 */
interface ModifiersAwareAccessorsInterface extends BaseModifiersAwareAccessorsInterface
{
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

    /**
     * @return bool
     */
    public function isDestructor();

    /**
     * @return bool
     */
    public function isConstructor();

    /**
     * @return bool
     */
    public function isStatic();

    /**
     * @return bool
     */
    public function isClosure();

    /**
     * @return bool
     */
    public function isVariadic();
}

/* EOF */
