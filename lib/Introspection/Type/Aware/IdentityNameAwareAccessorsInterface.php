<?php

/*
 * This file is part of the `augustus-reflection-library` project.
 *
 * (c) 2016 Rob Frawley 2nd(rmf) <rmf AT src DOT run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace SR\Reflection\Introspection\Type\Aware;

/**
 * Class IdentityNameAwareAccessorsTrait.
 */
interface IdentityNameAwareAccessorsInterface
{
    /**
     * @return string
     */
    public function nameQualified();

    /**
     * @return string
     */
    public function nameUnQualified();

    /**
     * @param bool $qualified
     *
     * @return string
     */
    public function name($qualified = false);
}

/* EOF */
