<?php

/*
 * This file is part of the `src-run/augustus-reflection-library` project.
 *
 * (c) Rob Frawley 2nd <rmf@src.run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace SR\Reflection\Inspector\Aware\ScopeMethod;

trait CallableAwareTrait // implements CallableAwareInterface
{
    /**
     * @return \ReflectionMethod
     */
    abstract public function reflection();

    /**
     * @return bool
     */
    abstract public function accessible();

    /**
     * @param object $instance
     * @param mixed  ...$parameters
     *
     * @return mixed
     */
    public function invoke($instance, ...$parameters)
    {
        return $this->invokeArgs($instance, $parameters);
    }

    /**
     * @param object  $instance
     * @param mixed[] $parameters
     *
     * @return mixed
     */
    public function invokeArgs($instance, array $parameters = [])
    {
        if (!$this->accessible()) {
            $this->reflection()->setAccessible(true);
        }

        return $this->reflection()->invokeArgs($instance, $parameters);
    }
}
