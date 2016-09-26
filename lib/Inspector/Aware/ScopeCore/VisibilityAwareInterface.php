<?php

/*
 * This file is part of the `src-run/augustus-reflection-library` project.
 *
 * (c) Rob Frawley 2nd <rmf@src.run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace SR\Reflection\Inspector\Aware\ScopeCore;

interface VisibilityAwareInterface
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
