<?php

/*
 * This file is part of the `src-run/augustus-reflection-library` project.
 *
 * (c) Rob Frawley 2nd <rmf@src.run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace SR\Reflection\Introspect\Type\PropertyAware;

use SR\Reflection\Introspect\Type\Aware\ModifiersAwareAccessorsInterface as BaseModifiersAwareAccessorsInterface;

/**
 * Class ModifiersAwareAccessorsInterface.
 */
interface ModifiersAwareAccessorsInterface extends BaseModifiersAwareAccessorsInterface
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

/* EOF */
