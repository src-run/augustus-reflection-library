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

use SR\Exception\RuntimeException;
use SR\Reflection\Introspection\ClassIntrospection;
use SR\Reflection\Introspection\ObjectIntrospection;
use SR\Reflection\Introspection\TraitIntrospection;
use SR\Utility\ClassInspect;

/**
 * Class Inspect.
 */
class Inspect implements InspectInterface
{
    /**
     * @param string|object $nameOrInstance
     * @param null|object   $closureScope
     *
     * @throws RuntimeException
     *
     * @return ClassIntrospection|ObjectIntrospection
     */
    public static function this($nameOrInstance, $closureScope = null)
    {
        if (ClassInspect::isInstance($nameOrInstance)) {
            return self::thisInstance($nameOrInstance, $closureScope);
        }

        if (ClassInspect::isClass($nameOrInstance)) {
            return self::thisClass($nameOrInstance, $closureScope);
        }

        if (ClassInspect::isTrait($nameOrInstance)) {
            return self::thisTrait($nameOrInstance);
        }

        throw RuntimeException::create('Invalid class name or instance (%s) provided to inspector.')->with(var_export($nameOrInstance, true));
    }

    /**
     * @param string      $name
     * @param null|object $closureScope
     *
     * @return ClassIntrospection
     */
    public static function thisClass($name, $closureScope = null)
    {
        return new ClassIntrospection($name, $closureScope);
    }

    /**
     * @param object      $instance
     * @param null|object $closureScope
     *
     * @return ObjectIntrospection
     */
    public static function thisInstance($instance, $closureScope = null)
    {
        return new ObjectIntrospection($instance, $closureScope);
    }

    /**
     * @param string      $name
     * @param null|object $closureScope
     *
     * @return ObjectIntrospection
     */
    public static function thisTrait($name, $closureScope = null)
    {
        return new TraitIntrospection($name, $closureScope);
    }
}

/* EOF */
