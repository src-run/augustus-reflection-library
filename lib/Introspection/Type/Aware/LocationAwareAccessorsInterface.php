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

namespace SR\Reflection\Introspection\Type\Aware;

/**
 * Class DocBlockAwareAccessorsInterface.
 */
interface LocationAwareAccessorsInterface
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
