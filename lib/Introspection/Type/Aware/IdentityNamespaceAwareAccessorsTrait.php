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

namespace SR\Reflection\Introspection\Type\Aware;

use SR\Reflection\Definition\ReflectionConstant;

/**
 * Class IdentityNamespaceAwareAccessorsTrait.
 */
trait IdentityNamespaceAwareAccessorsTrait // implements IdentityNamespaceAwareAccessorsInterface
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
