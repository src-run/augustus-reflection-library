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

namespace SR\Reflection\Utility;

/**
 * Class ClassChecker.
 */
class ClassChecker
{
    /**
     * @param mixed $class
     *
     * @return bool
     */
    public static function isClass($class)
    {
        try {
            return static::assertClass($class);
        } catch (\InvalidArgumentException $exception) {
            return false;
        }
    }

    /**
     * @param mixed $instance
     *
     * @return bool
     */
    public static function isInstance($instance)
    {
        try {
            return static::assertInstance($instance);
        } catch (\InvalidArgumentException $exception) {
            return false;
        }
    }

    /**
     * @param mixed $class
     *
     * @throws \InvalidArgumentException
     *
     * @return bool
     */
    public static function assertClass($class)
    {
        if (is_string($class) && class_exists((string) $class)) {
            return true;
        }

        throw new \InvalidArgumentException('Failed asserting passed value is valid class name.');
    }

    /**
     * @param mixed $instance
     *
     * @throws \InvalidArgumentException
     *
     * @return bool
     */
    public static function assertInstance($instance)
    {
        if (is_object($instance)) {
            return true;
        }

        throw new \InvalidArgumentException('Failed asserting passed value is an object instance.');
    }
}

/* EOF */
