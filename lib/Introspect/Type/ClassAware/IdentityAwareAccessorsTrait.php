<?php

/*
 * This file is part of the `src-run/augustus-reflection-library` project.
 *
 * (c) Rob Frawley 2nd <rmf@src.run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace SR\Reflection\Introspect\Type\ClassAware;

use SR\Reflection\Introspect\Type\Aware\IdentityInheritanceAwareAccessorsTrait;
use SR\Reflection\Introspect\Type\Aware\IdentityNameAwareAccessorsTrait;
use SR\Reflection\Introspect\Type\Aware\IdentityNamespaceAwareAccessorsTrait;

/**
 * Class IdentityAwareAccessorsTrait.
 */
trait IdentityAwareAccessorsTrait // implements IdentityAwareAccessorsInterface
{
    use IdentityNameAwareAccessorsTrait;
    use IdentityNamespaceAwareAccessorsTrait;
    use IdentityInheritanceAwareAccessorsTrait;

    /**
     * @return string
     */
    public function nameQualified()
    {
        return $this->reflection()->getName();
    }

    /**
     * @return string
     */
    public function nameUnQualified()
    {
        return $this->reflection()->getShortName();
    }
}

/* EOF */
