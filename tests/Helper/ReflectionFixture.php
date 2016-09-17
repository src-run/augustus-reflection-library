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

/**
 * Class ReflectionFixture.
 */
class ReflectionFixture implements \Reflector
{
    public function __toString()
    {
        return __CLASS__;
    }

    public static function export()
    {
        return 'export:'.__CLASS__;
    }
}

/* EOF */
