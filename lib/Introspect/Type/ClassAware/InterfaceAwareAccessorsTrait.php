<?php

/*
 * This file is part of the `src-run/augustus-reflection-library` project.
 *
 * (c) Rob Frawley 2nd <rmf@src.run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace SR\Reflection\Introspect\Type\ClassAware;

use SR\Exception\InvalidArgumentException;
use SR\Reflection\Introspect\InterfaceIntrospect;
use SR\Reflection\Introspect\Resolver\ResolverInterface;

/**
 * Class InterfaceAwareAccessorsTrait.
 */
trait InterfaceAwareAccessorsTrait // implements InterfaceAwareAccessorsInterface
{
    /**
     * @return \ReflectionClass
     */
    abstract public function reflection();

    /**
     * @return ResolverInterface
     */
    abstract public function resolver();

    /**
     * @param string $name
     *
     * @throws InvalidArgumentException
     *
     * @return InterfaceIntrospect
     */
    public function getInterface($name)
    {
        if (!$this->implementsInterface($name)) {
            throw InvalidArgumentException::create('Interface %s not found.')->with($name);
        }

        try {
            return $this->createInterfaceDefinition($name);
        } catch (InvalidArgumentException $e) {
            return $this->createInterfaceDefinition($this->namespaceName().'\\'.$name);
        }
    }

    /**
     * @return InterfaceIntrospect[]
     */
    public function interfaces()
    {
        $is = $this->reflection()->getInterfaces();
        $_ = function (\ReflectionClass &$i) {
            $i = $this->createInterfaceDefinition($i->getName());
        };

        array_walk($is, $_);

        return array_values($is);
    }

    /**
     * @param \Closure $sort
     * @param mixed    ...$extra
     *
     * @return InterfaceIntrospect[]
     */
    public function sortInterfaces(\Closure $sort, &...$extra)
    {
        return $this->resolver()->sort($this->interfaces(), $sort, ...$extra);
    }

    /**
     * @param \Closure $visit
     * @param mixed    ...$extra
     *
     * @return InterfaceIntrospect[]|mixed
     */
    public function visitInterfaces(\Closure $visit, &...$extra)
    {
        return $this->resolver()->visit($this->interfaces(), $visit, ...$extra);
    }

    /**
     * @param \Closure $predicate
     * @param mixed    ...$extra
     *
     * @return InterfaceIntrospect[]
     */
    public function filterInterfaces(\Closure $predicate, &...$extra)
    {
        return $this->resolver()->filter($this->interfaces(), $predicate, ...$extra);
    }

    /**
     * @param \Closure $predicate
     * @param mixed    ...$extra
     *
     * @return InterfaceIntrospect|null
     */
    public function filterOneInterface(\Closure $predicate, &...$extra)
    {
        return $this->resolver()->filterOne($this->interfaces(), $predicate, ...$extra);
    }

    /**
     * @param mixed  $match
     * @param string $func
     *
     * @return InterfaceIntrospect[]
     */
    public function matchInterfaces($match, $func = '__toString')
    {
        return $this->resolver()->match($this->interfaces(), $match, $func);
    }

    /**
     * @param mixed  $match
     * @param string $func
     *
     * @return null|InterfaceIntrospect
     */
    public function matchOneInterface($match, $func = '__toString')
    {
        return $this->resolver()->matchOne($this->interfaces(), $match, $func);
    }

    /**
     * @param string $interface
     *
     * @return InterfaceIntrospect
     */
    private function createInterfaceDefinition($interface)
    {
        return new InterfaceIntrospect($interface);
    }
}

/* EOF */
