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
    public function isAnonymous()
    {
        return PHP_VERSION_ID < 70000 ? false : $this->reflection()->isAnonymous();
    }

    /**
     * @return bool
     */
    public function isClonable()
    {
        return $this->reflection()->isCloneable();
    }

    /**
     * @return bool
     */
    public function isInstance($instance)
    {
        return $this->reflection()->isInstance($instance);
    }

    /**
     * @return bool
     */
    public function isInstantiable()
    {
        return $this->reflection()->isInstantiable();
    }

    /**
     * @return bool
     */
    public function isInterface()
    {
        return $this->reflection()->isInterface();
    }

    /**
     * @return bool
     */
    public function isIterateable()
    {
        return $this->reflection()->isIterateable();
    }

    /**
     * @return bool
     */
    public function isTrait()
    {
        return $this->reflection()->isTrait();
    }

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
}

/* EOF */
