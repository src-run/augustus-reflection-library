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

use SR\Reflection\Introspect\ClassIntrospect;
use SR\Reflection\Introspect\ObjectIntrospect;

/**
 * Class IdentityDeclaringClassAwareAccessorsInterface.
 */
interface IdentityDeclaringClassAwareAccessorsInterface
{
    /**
     * @return \ReflectionClass|\ReflectionObject
     */
    public function reflectionDeclaringClass();

    /**
     * @return ClassIntrospect|ObjectIntrospect
     */
    public function declaringClass();
}

/* EOF */
