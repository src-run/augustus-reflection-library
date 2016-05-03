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

namespace SR\Reflection\Introspection\Type\MethodAware;

use SR\Reflection\Introspection\Type\Aware\ModifiersAwareAccessorsTrait as BaseModifiersAwareAccessorsTrait;

/**
 * Class ModifiersAwareAccessorsTrait.
 */
trait ModifiersAwareAccessorsTrait // implements ModifiersAwareAccessorsInterface
{
    use BaseModifiersAwareAccessorsTrait;

    /**
     * @return bool
     */
    public function isAbstract()
    {
        return $this->reflection()->isAbstract();
    }

    /**
     * @return bool
     */
    public function isFinal()
    {
        return $this->reflection()->isFinal();
    }

    /**
     * @return bool
     */
    public function isInternal()
    {
        return $this->reflection()->isInternal();
    }

    /**
     * @return bool
     */
    public function isUserDefined()
    {
        return $this->reflection()->isUserDefined();
    }

    /**
     * @return bool
     */
    public function isDestructor()
    {
        return $this->reflection()->isDestructor();
    }

    /**
     * @return bool
     */
    public function isConstructor()
    {
        return $this->reflection()->isConstructor();
    }

    /**
     * @return bool
     */
    public function isStatic()
    {
        return $this->reflection()->isStatic();
    }

    /**
     * @return bool
     */
    public function isClosure()
    {
        return $this->reflection()->isClosure();
    }

    /**
     * @return bool
     */
    public function isVariadic()
    {
        return $this->reflection()->isVariadic();
    }
}

/* EOF */
