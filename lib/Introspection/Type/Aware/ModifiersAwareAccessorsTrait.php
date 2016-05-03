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

namespace SR\Reflection\Introspection\Type\Aware;

/**
 * Class ModifiersAwareAccessorsTrait.
 */
trait ModifiersAwareAccessorsTrait // implements ModifiersAwareAccessorsInterface
{
    /**
     * @return \ReflectionMethod|\ReflectionProperty|\ReflectionObject|\ReflectionClass
     */
    abstract public function reflection();

    /**
     * @return int
     */
    public function modifiers()
    {
        return $this->reflection()->getModifiers();
    }

    
}

/* EOF */
