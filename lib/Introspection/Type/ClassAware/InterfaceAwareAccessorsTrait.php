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

use SR\Exception\InvalidArgumentException;
use SR\Reflection\Introspection\InterfaceIntrospection;
use SR\Reflection\IntrospectionInterfaceIntrospection;
use SR\Reflection\Introspection\Resolver\ResolverInterface;

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
     * @return InterfaceIntrospection
     */
    public function getInterface($name)
    {
        if (!$this->implementsInterface($name)) {
            throw InvalidArgumentException::create('Interface %s not found.')->with($name);
        }

        try {
            return $this->createInterfaceDefinition($name);
        }
        catch (InvalidArgumentException $e) {
            return $this->createInterfaceDefinition($this->namespaceName().'\\'.$name);
        }
    }

    /**
     * @return InterfaceIntrospection[]
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
     * @return InterfaceIntrospection[]
     */
    public function sortInterfaces(\Closure $sort, &...$extra)
    {
        return $this->resolver()->sort($this->interfaces(), $sort, ...$extra);
    }

    /**
     * @param \Closure $visit
     * @param mixed    ...$extra
     *
     * @return InterfaceIntrospection[]|mixed
     */
    public function visitInterfaces(\Closure $visit, &...$extra)
    {
        return $this->resolver()->visit($this->interfaces(), $visit, ...$extra);
    }

    /**
     * @param \Closure $predicate
     * @param mixed    ...$extra
     *
     * @return InterfaceIntrospection[]
     */
    public function filterInterfaces(\Closure $predicate, &...$extra)
    {
        return $this->resolver()->filter($this->interfaces(), $predicate, ...$extra);
    }

    /**
     * @param \Closure $predicate
     * @param mixed    ...$extra
     *
     * @return InterfaceIntrospection|null
     */
    public function filterOneInterface(\Closure $predicate, &...$extra)
    {
        return $this->resolver()->filterOne($this->interfaces(), $predicate, ...$extra);
    }

    /**
     * @param mixed    $match
     * @param string   $func
     *
     * @return InterfaceIntrospection[]
     */
    public function matchInterfaces($match, $func = '__toString')
    {
        return $this->resolver()->match($this->interfaces(), $match, $func);
    }

    /**
     * @param mixed    $match
     * @param string   $func
     *
     * @return null|InterfaceIntrospection
     */
    public function matchOneInterface($match, $func = '__toString')
    {
        return $this->resolver()->matchOne($this->interfaces(), $match, $func);
    }

    /**
     * @param string $interface
     *
     * @return InterfaceIntrospection
     */
    private function createInterfaceDefinition($interface)
    {
        return new InterfaceIntrospection($interface);
    }
}

/* EOF */
