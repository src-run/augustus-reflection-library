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

namespace SR\Reflection;

use SR\Reflection\Manager\ClassGeneralTypeManager;
use SR\Reflection\Manager\ClassInstanceTypeManager;
use SR\Reflection\Utility\ClassChecker;

/**
 * Class Inspect.
 */
class Inspect implements InspectInterface
{
    /**
     * @param string|object $nameOrInstance
     * @param object|null   $closureScope
     *
     * @throws \RuntimeException
     *
     * @return ClassGeneralTypeManager|ClassInstanceTypeManager
     */
    public static function this($nameOrInstance, $closureScope = null)
    {
        if (ClassChecker::isInstance($nameOrInstance)) {
            return self::thisInstance($nameOrInstance, $closureScope);
        }

        if (ClassChecker::isClass($nameOrInstance)) {
            return self::thisClass($nameOrInstance, $closureScope);
        }

        throw new \RuntimeException('Invalid class name or instance provided to inspector.');
    }

    /**
     * @param string      $name
     * @param object|null $closureScope
     *
     * @return ClassGeneralTypeManager
     */
    public static function thisClass($name, $closureScope = null)
    {
        return new ClassGeneralTypeManager($name, $closureScope);
    }

    /**
     * @param object      $instance
     * @param object|null $closureScope
     *
     * @return ClassInstanceTypeManager
     */
    public static function thisInstance($instance, $closureScope = null)
    {
        return new ClassInstanceTypeManager($instance, $closureScope);
    }
}

/* EOF */
