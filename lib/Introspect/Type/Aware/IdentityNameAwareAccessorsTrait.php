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
 * Class IdentityNameAwareAccessorsTrait.
 */
trait IdentityNameAwareAccessorsTrait // implements IdentityNameAwareAccessorsInterface
{
    /**
     * @return \ReflectionClass
     */
    abstract public function reflection();

    /**
     * @return string
     */
    abstract public function nameQualified();

    /**
     * @return string
     */
    abstract public function nameUnQualified();

    /**
     * @param bool $qualified
     *
     * @return string
     */
    public function name($qualified = false)
    {
        return $qualified ? $this->nameQualified() : $this->nameUnQualified();
    }
}

/* EOF */
