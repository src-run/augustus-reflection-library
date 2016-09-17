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

use SR\Reflection\Inspector\Aware\ScopeCore\IdentityInheritanceAwareTrait;
use SR\Reflection\Inspector\Aware\ScopeCore\IdentityNameAwareTrait;
use SR\Reflection\Inspector\Aware\ScopeCore\IdentityNamespaceAwareTrait;

/**
 * Class IdentityAwareTrait.
 */
trait IdentityAwareTrait // implements IdentityAwareInterface
{
    use IdentityNameAwareTrait;
    use IdentityNamespaceAwareTrait;
    use IdentityInheritanceAwareTrait;

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
