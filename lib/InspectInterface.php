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

use SR\Reflection\Inspector\ClassInspector;
use SR\Reflection\Inspector\InterfaceInspector;
use SR\Reflection\Inspector\ObjectInspector;
use SR\Reflection\Inspector\TraitInspector;

interface InspectInterface
{
    /**
     * Trys to determine the type of passed item and proxies the call to the respective specific this[*] methods.
     *
     * @param object|string $what A class name, object instance, interface name, or trait name
     * @param object|null   $bind Alternate $this binding for internal resolver instance
     *
     * @return ClassInspector|ObjectInspector|InterfaceInspector|TraitInspector
     */
    public static function using($what, $bind = null);

    /**
     * Factory to create the respective [*]Introspection class instance.
     *
     * @param object|string $what A class name, object instance, interface name, or trait name
     * @param object|null   $bind Alternate $this binding for internal resolver instance
     *
     * @return ClassInspector
     */
    public static function useClass($what, $bind = null);

    /**
     * Factory to create the respective [*]Introspection class instance.
     *
     * @param object|string $what A class name, object instance, interface name, or trait name
     * @param object|null   $bind Alternate $this binding for internal resolver instance
     *
     * @return ObjectInspector
     */
    public static function useInstance($what, $bind = null);

    /**
     * Factory to create the respective [*]Introspection class instance.
     *
     * @param object|string $what A class name, object instance, interface name, or trait name
     * @param object|null   $bind Alternate $this binding for internal resolver instance
     *
     * @return InterfaceInspector
     */
    public static function useInterface($what, $bind = null);

    /**
     * Factory to create the respective [*]Introspection class instance.
     *
     * @param object|string $what A class name, object instance, interface name, or trait name
     * @param object|null   $bind Alternate $this binding for internal resolver instance
     *
     * @return TraitInspector
     */
    public static function useTrait($what, $bind = null);
}
