<?php

/*
 * This file is part of the `src-run/augustus-reflection-library` project.
 *
 * (c) Rob Frawley 2nd <rmf@src.run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace SR\Reflection\Inspector\Aware\ScopeCore;

trait IdentityInheritanceAwareTrait // implements IdentityInheritanceAwareInterface
{
    /**
     * @return \ReflectionClass|\ReflectionObject
     */
    abstract public function reflection();

    /**
     * @param object|string $class
     *
     * @return bool
     */
    public function extendsClass($class)
    {
        try {
            return $this->reflection()->isSubclassOf(static::normalizeNamespace($this->namespaceName().'\\'.$class));
        } catch (\ReflectionException $e) {
        }

        try {
            return $this->reflection()->isSubclassOf(static::normalizeNamespace($class));
        } catch (\ReflectionException $e) {
            return false;
        }
    }

    /**
     * @param string $interface
     *
     * @return bool
     */
    public function implementsInterface($interface)
    {
        try {
            return $this->reflection()->implementsInterface(static::normalizeNamespace($this->namespaceName().'\\'.$interface));
        } catch (\ReflectionException $e) {
        }

        try {
            return $this->reflection()->implementsInterface(static::normalizeNamespace($interface));
        } catch (\ReflectionException $e) {
            return false;
        }
    }

    /**
     * @param string $trait
     *
     * @return bool
     */
    public function usesTrait($trait)
    {
        return in_array(static::normalizeNamespace($this->namespaceName().'\\'.$trait), $this->reflection()->getTraitNames(), true) ||
            in_array(static::normalizeNamespace($trait), $this->reflection()->getTraitNames(), true);
    }

    /**
     * @param string $namespace
     *
     * @return string
     */
    private static function normalizeNamespace($namespace)
    {
        $namespace = str_replace('\\\\', '\\', $namespace);

        if ('\\' === mb_substr($namespace, 0, 1)) {
            return mb_substr($namespace, 1);
        }

        return $namespace;
    }
}
