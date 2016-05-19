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

/**
 * Class InspectInterface.
 */
interface InspectInterface
{
    /**
     * @param string|object $what
     * @param null|object   $bindTo
     *
     * @throws RuntimeException
     *
     * @return ClassIntrospection|ObjectIntrospection|InterfaceIntrospection|TraitIntrospection
     */
    public static function this($what, $bindTo = null);

    /**
     * @param string      $what
     * @param null|object $bindTo
     *
     * @return ClassIntrospection
     */
    public static function thisClass($what, $bindTo = null);

    /**
     * @param object      $what
     * @param null|object $bindTo
     *
     * @return ObjectIntrospection
     */
    public static function thisInstance($what, $bindTo = null);

    /**
     * @param string      $what
     * @param null|object $bindTo
     *
     * @return InterfaceIntrospection
     */
    public static function thisInterface($what, $bindTo = null);

    /**
     * @param string      $what
     * @param null|object $bindTo
     *
     * @return TraitIntrospection
     */
    public static function thisTrait($what, $bindTo = null);
}

/* EOF */
