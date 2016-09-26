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

use SR\Reflection\Inspector\Aware\ScopeCore\ModifiersAwareTrait as BaseModifiersAwareTrait;

trait ModifiersAwareTrait // implements ModifiersAwareInterface
{
    use BaseModifiersAwareTrait;

    /**
     * @return bool
     */
    public function isStatic()
    {
        return $this->reflection()->isStatic();
    }

    /**
     * @return bool
     */
    public function isDefault()
    {
        return $this->reflection()->isDefault();
    }
}
