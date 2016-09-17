<?php

/*
 * This file is part of the `src-run/augustus-reflection-library` project.
 *
 * (c) Rob Frawley 2nd <rmf@src.run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace SR\Reflection\Tests\Helper;

trait FixtureTraitThree
{
    public function methodIsPublic()
    {
        return __FUNCTION__;
    }

    protected function methodIsProtected()
    {
        return __FUNCTION__;
    }

    private function methodIsPrivate()
    {
        return __FUNCTION__;
    }
}

/* EOF */
