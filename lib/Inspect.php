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
use SR\Reflection\Introspection\InterfaceIntrospection;
use SR\Reflection\Introspection\ObjectIntrospection;
use SR\Reflection\Introspection\TraitIntrospection;
use SR\Utility\ClassInspect;

/**
 * Class Inspect.
 */
class Inspect implements InspectInterface
{
    /**
     * @param string|object $what
     * @param null|object   $bindTo
     *
     * @throws RuntimeException
     *
     * @return ClassIntrospection|ObjectIntrospection|InterfaceIntrospection|TraitIntrospection
     */
    public static function this($what, $bindTo = null)
    {
        if (ClassInspect::isInstance($what)) {
            return self::thisInstance($what, $bindTo);
        }

        if (ClassInspect::isClass($what)) {
            return self::thisClass($what, $bindTo);
        }

        if (ClassInspect::isInterface($what)) {
            return self::thisInterface($what, $bindTo);
        }

        if (ClassInspect::isTrait($what)) {
            return self::thisTrait($what);
        }

        throw RuntimeException::create('Invalid inspector argument provided (got %s)')->with(var_export($what, true));
    }

    /**
     * @param string $what
     * @param null|object $bindTo
     *
     * @return ClassIntrospection
     */
    public static function thisClass($what, $bindTo = null)
    {
        return new ClassIntrospection($what, $bindTo);
    }

    /**
     * @param object      $what
     * @param null|object $bindTo
     *
     * @return ObjectIntrospection
     */
    public static function thisInstance($what, $bindTo = null)
    {
        return new ObjectIntrospection($what, $bindTo);
    }

    /**
     * @param string      $what
     * @param null|object $bindTo
     *
     * @return InterfaceIntrospection
     */
    public static function thisInterface($what, $bindTo = null)
    {
        return new InterfaceIntrospection($what, $bindTo);
    }

    /**
     * @param string      $what
     * @param null|object $bindTo
     *
     * @return TraitIntrospection
     */
    public static function thisTrait($what, $bindTo = null)
    {
        return new TraitIntrospection($what, $bindTo);
    }
}

/* EOF */
