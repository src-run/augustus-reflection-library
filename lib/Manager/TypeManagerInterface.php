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

namespace SR\Reflection\Manager;

use SR\Reflection\Manager\Resolver\ResolverInterface;

/**
 * Class ManagerInterface.
 */
interface TypeManagerInterface
{
    /**
     * @return \ReflectionClass|\ReflectionObject|\Reflector|null
     */
    public function reflection();

    /**
     * @return ResolverInterface
     */
    public function resolver();
}

/* EOF */
