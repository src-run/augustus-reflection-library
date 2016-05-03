<?php

/*
 * This file is part of the `src-run/augustus-reflection-library` project.
 *
 * (c) Rob Frawley 2nd <rmf@src.run>
 * (c) Scribe Inc      <scr@src.run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace SR\Reflection\Tests\Helper;

/**
 * Class FixtureInterface.
 */
interface FixtureInterface
{
    const CONSTANT = 'interfaceConstant';
    
    public function interfaceMethod();
}

/* EOF */
