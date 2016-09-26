<?php

/*
 * This file is part of the `src-run/augustus-reflection-library` project.
 *
 * (c) Rob Frawley 2nd <rmf@src.run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace SR\Reflection\Inspector\Aware\ScopeProperty;

interface ValueAwareInterface
{
    /**
     * @param object $instance
     *
     * @return mixed
     */
    public function value($instance);

    /**
     * @param object $instance
     * @param mixed  $value
     */
    public function setValue($instance, $value);
}
