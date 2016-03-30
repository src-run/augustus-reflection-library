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

namespace SR\Reflection\Introspection\Type\ClassAware;

use SR\Reflection\Inspect;

/**
 * Class IdentityAwareAccessorsTrait.
 */
trait IdentityAwareAccessorsTrait //extends IdentityAwareAccessorsInterface
{
    /**
     * @return \ReflectionClass
     */
    abstract public function reflection();

    /**
     * @return string
     */
    public function className()
    {
        return $this->reflection()->getShortName();
    }

    /**
     * @return string
     */
    public function classNamespace()
    {
        return $this->reflection()->getNamespaceName();
    }

    /**
     * @return string
     */
    public function classNameAbsolute()
    {
        return sprintf('%s\%s', $this->classNamespace(), $this->className());
    }

    /**
     * @param object|string $class
     *
     * @return bool
     */
    public function extendsClass($class)
    {
        return (bool) $this->reflection()->isSubclassOf(Inspect::this($class)->classNameAbsolute());
    }

    /**
     * @param string $interface
     *
     * @return bool
     */
    public function implementsInterface($interface)
    {

        return (bool) $this->reflection()->implementsInterface($interface);
    }

    /**
     * @param string $trait
     *
     * @return bool
     */
    public function usesTrait($trait)
    {
        $trait = substr($trait, 0, 1) === '\\' ? substr($trait, 1) : $trait;

        return (bool) in_array($trait, $this->reflection()->getTraitNames());
    }
}

/* EOF */
