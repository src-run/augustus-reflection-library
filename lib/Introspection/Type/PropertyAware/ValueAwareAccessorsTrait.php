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

namespace SR\Reflection\Introspection\Type\PropertyAware;

/**
 * Class ValueAwareAccessorsTrait.
 */
trait ValueAwareAccessorsTrait // implements ValueAwareAccessorsInterface
{
    /**
     * @return \ReflectionProperty
     */
    abstract public function reflection();

    /**
     * @return bool
     */
    abstract public function accessible();

    /**
     * @param object $instance
     *
     * @return mixed
     */
    public function value($instance)
    {
        if (!$this->accessible()) {
            $this->reflection()->setAccessible(true);
        }

        return $this->reflection()->getValue($instance);
    }

    /**
     * @param object $instance
     * @param mixed  $value
     */
    public function setValue($instance, $value)
    {
        if (!$this->accessible()) {
            $this->reflection()->setAccessible(true);
        }

        $this->reflection()->setValue($instance, $value);
    }
}

/* EOF */
