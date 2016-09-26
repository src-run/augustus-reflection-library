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

use SR\Reflection\Inspector\Aware\ScopeCore\ModifiersAwareInterface as BaseModifiersAwareInterface;

interface ModifiersAwareInterface extends BaseModifiersAwareInterface
{
    /**
     * @return bool
     */
    public function isStatic();

    /**
     * @return bool
     */
    public function isDefault();
}
