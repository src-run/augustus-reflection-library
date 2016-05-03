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

use SR\Reflection\Introspection\ClassIntrospection;
use SR\Reflection\Introspection\ObjectIntrospection;

/**
 * Class IdentityDeclaringClassAwareAccessorsTrait.
 */
trait IdentityDeclaringClassAwareAccessorsTrait // implements IdentityDeclaringClassAwareAccessorsInterface
{
    /**
     * @var ClassIntrospection|ObjectIntrospection
     */
    private $declaringClass;

    /**
     * @return \ReflectionClass|\ReflectionObject
     */
    public function reflectionDeclaringClass()
    {
        return $this->declaringClass->reflection();
    }

    /**
     * @return ClassIntrospection|ObjectIntrospection
     */
    public function declaringClass()
    {
        return $this->declaringClass;
    }
}

/* EOF */
