<?php

/*
 * This file is part of the `src-run/augustus-reflection-library` project.
 *
 * (c) Rob Frawley 2nd <rmf@src.run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace SR\Reflection;

use SR\Reflection\Exception\RuntimeException;
use SR\Reflection\Inspector\ClassInspector;
use SR\Reflection\Inspector\InterfaceInspector;
use SR\Reflection\Inspector\ObjectInspector;
use SR\Reflection\Inspector\TraitInspector;
use SR\Utility\ClassInspect;

/**
 * Inspector factory creates appropriate [*]Introspection class.
 */
class Inspect implements InspectInterface
{
    /**
     * Try to determine the type of passed item and proxies the call to the respective specific this[*] methods.
     *
     * @param object|string $what A class name, object instance, interface name, or trait name
     * @param object|null   $bind Alternate $this binding for internal resolver instance
     *
     * @throws RuntimeException If passed value is not an instance, class, interface or trait
     *
     * @return ClassInspector|ObjectInspector|InterfaceInspector|TraitInspector
     */
    public static function using($what, $bind = null)
    {
        if (ClassInspect::isInstance($what)) {
            return self::useInstance($what, $bind);
        }

        if (ClassInspect::isClass($what)) {
            return self::useClass($what, $bind);
        }

        if (ClassInspect::isInterface($what)) {
            return self::useInterface($what, $bind);
        }

        if (ClassInspect::isTrait($what)) {
            return self::useTrait($what);
        }

        throw RuntimeException::create('Invalid inspector argument provided (got %s)')->with(var_export($what, true));
    }

    /**
     * Factory to create the respective [*]Introspection class instance.
     *
     * @param object|string $what A class name, object instance, interface name, or trait name
     * @param object|null   $bind Alternate $this binding for internal resolver instance
     *
     * @return ClassInspector
     */
    public static function useClass($what, $bind = null)
    {
        return new ClassInspector($what, $bind);
    }

    /**
     * Factory to create the respective [*]Introspection class instance.
     *
     * @param object|string $what A class name, object instance, interface name, or trait name
     * @param object|null   $bind Alternate $this binding for internal resolver instance
     *
     * @return ObjectInspector
     */
    public static function useInstance($what, $bind = null)
    {
        return new ObjectInspector($what, $bind);
    }

    /**
     * Factory to create the respective [*]Introspection class instance.
     *
     * @param object|string $what A class name, object instance, interface name, or trait name
     * @param object|null   $bind Alternate $this binding for internal resolver instance
     *
     * @return InterfaceInspector
     */
    public static function useInterface($what, $bind = null)
    {
        return new InterfaceInspector($what, $bind);
    }

    /**
     * Factory to create the respective [*]Introspection class instance.
     *
     * @param object|string $what A class name, object instance, interface name, or trait name
     * @param object|null   $bind Alternate $this binding for internal resolver instance
     *
     * @return TraitInspector
     */
    public static function useTrait($what, $bind = null)
    {
        return new TraitInspector($what, $bind);
    }
}

/* EOF */
