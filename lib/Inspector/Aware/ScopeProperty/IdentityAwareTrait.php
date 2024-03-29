<?php

/*
 * This file is part of the `src-run/augustus-reflection-library` project.
 *
 * (c) Rob Frawley 2nd <rmf@src.run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace SR\Reflection\Inspector\Aware\ScopeProperty;

use SR\Reflection\Inspector\Aware\ScopeCore\IdentityDeclaringClassAwareTrait;
use SR\Reflection\Inspector\Aware\ScopeCore\IdentityNameAwareTrait;
use SR\Reflection\Inspector\Aware\ScopeCore\IdentityNamespaceAwareTrait;

trait IdentityAwareTrait // implements IdentityAwareInterface
{
    use IdentityDeclaringClassAwareTrait;
    use IdentityNameAwareTrait;
    use IdentityNamespaceAwareTrait;

    /**
     * @return string
     */
    public function nameQualified()
    {
        return $this->declaringClass()->nameQualified() . '::$' . $this->nameUnQualified();
    }

    /**
     * @return string
     */
    public function nameUnQualified()
    {
        return $this->reflection()->getName();
    }
}
