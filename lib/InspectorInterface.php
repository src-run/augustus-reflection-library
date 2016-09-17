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

use SR\Exception\RuntimeException;
use SR\Reflection\Introspect\ClassIntrospect;
use SR\Reflection\Introspect\InterfaceIntrospect;
use SR\Reflection\Introspect\ObjectIntrospect;
use SR\Reflection\Introspect\TraitIntrospect;

/**
 * Base inspector factory interface.
 */
interface InspectorInterface
{
    /**
     * Trys to determine the type of passed item and proxies the call to the respective specific this[*] methods.
     *
     * @param object|string $what A class name, object instance, interface name, or trait name
     * @param object|null   $bind Alternate $this binding for internal resolver instance
     *
     * @return ClassIntrospect|ObjectIntrospect|InterfaceIntrospect|TraitIntrospect
     */
    public static function from($what, $bind = null);

    /**
     * Factory to create the respective [*]Introspection class instance.
     *
     * @param object|string $what A class name, object instance, interface name, or trait name
     * @param object|null   $bind Alternate $this binding for internal resolver instance
     *
     * @return ClassIntrospect
     */
    public static function fromClass($what, $bind = null);

    /**
     * Factory to create the respective [*]Introspection class instance.
     *
     * @param object|string $what A class name, object instance, interface name, or trait name
     * @param object|null   $bind Alternate $this binding for internal resolver instance
     *
     * @return ObjectIntrospect
     */
    public static function fromInstance($what, $bind = null);

    /**
     * Factory to create the respective [*]Introspection class instance.
     *
     * @param object|string $what A class name, object instance, interface name, or trait name
     * @param object|null   $bind Alternate $this binding for internal resolver instance
     *
     * @return InterfaceIntrospect
     */
    public static function fromInterface($what, $bind = null);

    /**
     * Factory to create the respective [*]Introspection class instance.
     *
     * @param object|string $what A class name, object instance, interface name, or trait name
     * @param object|null   $bind Alternate $this binding for internal resolver instance
     *
     * @return TraitIntrospect
     */
    public static function fromTrait($what, $bind = null);
}

/* EOF */
