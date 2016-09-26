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

use SR\Reflection\Inspector\ClassInspector;
use SR\Reflection\Inspector\ObjectInspector;

trait IdentityDeclaringClassAwareTrait // implements IdentityDeclaringClassAwareInterface
{
    /**
     * @var ClassInspector|ObjectInspector
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
     * @return ClassInspector|ObjectInspector
     */
    public function declaringClass()
    {
        return $this->declaringClass;
    }
}
