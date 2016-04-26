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
     * @param bool $qualified
     *
     * @return string
     */
    public function name($qualified = false)
    {
        return $qualified ? $this->nameQualified() : $this->nameUnQualified();
    }

    /**
     * @return string
     */
    public function nameQualified()
    {
        return $this->reflection()->getName();
    }

    /**
     * @return string
     */
    public function nameUnQualified()
    {
        return $this->reflection()->getShortName();
    }

    /**
     * @return string
     */
    public function namespace()
    {
        return $this->reflection()->getNamespaceName();
    }

    /**
     * @param object|string $class
     *
     * @return bool
     */
    public function extends($class)
    {
        $namespace = static::normalizeNamespace(Inspect::this($class)->nameQualified());

        return (bool) $this->reflection()->isSubclassOf($namespace);
    }

    /**
     * @param string $interface
     *
     * @return bool
     */
    public function implements($interface)
    {
        $interface = static::normalizeNamespace($interface);

        return (bool) $this->reflection()->implementsInterface($interface);
    }

    /**
     * @param string $trait
     *
     * @return bool
     */
    public function uses($trait)
    {
        $trait = static::normalizeNamespace(Inspect::this($trait)->nameQualified());

        return (bool) in_array($trait, $this->reflection()->getTraitNames());
    }

    /**
     * @param string $namespace
     *
     * @return string
     */
    public static function normalizeNamespace($namespace)
    {
        $namespace = str_replace('\\\\', '\\', $namespace);

        if (substr($namespace, 0, 1) === '\\') {
            return substr($namespace, 1);
        }

        return $namespace;
    }
}

/* EOF */
