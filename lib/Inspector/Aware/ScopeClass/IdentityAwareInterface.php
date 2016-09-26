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

use SR\Reflection\Inspector\Aware\ScopeCore\IdentityInheritanceAwareInterface;
use SR\Reflection\Inspector\Aware\ScopeCore\IdentityNameAwareInterface;
use SR\Reflection\Inspector\Aware\ScopeCore\IdentityNamespaceAwareInterface;

interface IdentityAwareInterface extends IdentityNameAwareInterface, IdentityNamespaceAwareInterface, IdentityInheritanceAwareInterface
{
}
