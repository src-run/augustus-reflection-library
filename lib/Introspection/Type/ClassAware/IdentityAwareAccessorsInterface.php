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

namespace SR\Reflection\Introspection\Type\ClassAware;

use SR\Reflection\Introspection\Type\Aware\IdentityInheritanceAwareAccessorsInterface;
use SR\Reflection\Introspection\Type\Aware\IdentityNameAwareAccessorsInterface;
use SR\Reflection\Introspection\Type\Aware\IdentityNamespaceAwareAccessorsInterface;

/**
 * Class IdentityAwareAccessorsInterface.
 */
interface IdentityAwareAccessorsInterface extends IdentityNameAwareAccessorsInterface, IdentityNamespaceAwareAccessorsInterface,
                                                  IdentityInheritanceAwareAccessorsInterface
{
}

/* EOF */
