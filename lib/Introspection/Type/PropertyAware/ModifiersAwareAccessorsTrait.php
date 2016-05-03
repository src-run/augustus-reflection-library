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

namespace SR\Reflection\Introspection\Type\PropertyAware;

use SR\Reflection\Introspection\Type\Aware\ModifiersAwareAccessorsTrait as BaseModifiersAwareAccessorsTrait;

/**
 * Class ModifiersAwareAccessorsTrait.
 */
trait ModifiersAwareAccessorsTrait // implements ModifiersAwareAccessorsInterface
{
    use BaseModifiersAwareAccessorsTrait;

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

/* EOF */
