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
 * Class VisibilityAwareAccessorsInterface.
 */
interface VisibilityAwareAccessorsInterface
{
    /**
     * @string
     */
    public function visibility();

    /**
     * @return bool
     */
    public function accessible();

    /**
     * @return bool
     */
    public function visibilityPrivate();

    /**
     * @return bool
     */
    public function visibilityProtected();

    /**
     * @return bool
     */
    public function visibilityPublic();
}

/* EOF */
