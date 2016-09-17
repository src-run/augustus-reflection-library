<?php

/*
 * This file is part of the `src-run/augustus-reflection-library` project.
 *
 * (c) Rob Frawley 2nd <rmf@src.run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace SR\Reflection\Introspect\Type\Aware;

/**
 * Class VisibilityAwareAccessorsTrait.
 */
trait VisibilityAwareAccessorsTrait // implements VisibilityAwareAccessorsInterface
{
    /**
     * @return \ReflectionMethod|\ReflectionProperty
     */
    abstract public function reflection();

    /**
     * @string
     */
    public function visibility()
    {
        if ($this->visibilityPrivate()) {
            return 'private';
        } elseif ($this->visibilityProtected()) {
            return 'protected';
        }

        return 'public';
    }

    /**
     * @return bool
     */
    public function accessible()
    {
        return $this->visibilityPublic();
    }

    /**
     * @return bool
     */
    public function visibilityPrivate()
    {
        return $this->reflection()->isPrivate();
    }

    /**
     * @return bool
     */
    public function visibilityProtected()
    {
        return $this->reflection()->isProtected();
    }

    /**
     * @return bool
     */
    public function visibilityPublic()
    {
        return $this->reflection()->isPublic();
    }
}

/* EOF */
