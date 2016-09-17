<?php

/*
 * This file is part of the `src-run/augustus-reflection-library` project.
 *
 * (c) Rob Frawley 2nd <rmf@src.run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace SR\Reflection\Inspector\Aware\ScopeCore;

use SR\Reflection\Definition\ReflectionConstant;

/**
 * Class IdentityNamespaceAwareTrait.
 */
trait IdentityNamespaceAwareTrait // implements IdentityNamespaceAwareInterface
{
    /**
     * @return \ReflectionMethod|\ReflectionProperty|ReflectionConstant|\ReflectionClass|\ReflectionObject
     */
    abstract public function reflection();

    /**
     * @return string
     */
    public function namespaceName()
    {
        return $this->reflection()->getNamespaceName();
    }

    /**
     * @return string[]
     */
    public function namespaceSections()
    {
        return (array) explode('\\', $this->namespaceName());
    }
}

/* EOF */
