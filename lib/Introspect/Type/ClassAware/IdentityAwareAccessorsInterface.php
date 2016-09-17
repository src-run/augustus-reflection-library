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

use SR\Reflection\Introspect\Type\Aware\IdentityInheritanceAwareAccessorsInterface;
use SR\Reflection\Introspect\Type\Aware\IdentityNameAwareAccessorsInterface;
use SR\Reflection\Introspect\Type\Aware\IdentityNamespaceAwareAccessorsInterface;

/**
 * Class IdentityAwareAccessorsInterface.
 */
interface IdentityAwareAccessorsInterface extends
IdentityNameAwareAccessorsInterface,
IdentityNamespaceAwareAccessorsInterface,
                                                  IdentityInheritanceAwareAccessorsInterface
{
}

/* EOF */
