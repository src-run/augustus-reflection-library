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

/**
 * Class DocBlockAwareInterface.
 */
interface LocationAwareInterface
{
    /**
     * @return \SplFileInfo
     */
    public function file();

    /**
     * @return int
     */
    public function lineStart();

    /**
     * @return int
     */
    public function lineEnd();
}

/* EOF */
