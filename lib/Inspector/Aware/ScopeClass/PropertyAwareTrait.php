<?php

/*
 * This file is part of the `src-run/augustus-reflection-library` project.
 *
 * (c) Rob Frawley 2nd <rmf@src.run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace SR\Reflection\Inspector\Aware\ScopeClass;

use SR\Reflection\Exception\InvalidArgumentException;
use SR\Reflection\Inspector\PropertyInspector;
use SR\Reflection\Resolver\ResolverInterface;

/**
 * Class PropertyAwareTrait.
 */
trait PropertyAwareTrait // implements PropertyAwareInterface
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
     * @return bool
     */
    public function hasProperty($name)
    {
        return $this->reflection()->hasProperty($name);
    }

    /**
     * @param string $name
     *
     * @throws InvalidArgumentException
     *
     * @return PropertyInspector
     */
    public function getProperty($name)
    {
        if (!$this->hasProperty($name)) {
            throw InvalidArgumentException::create('Property %s not found.')->with($name);
        }

        return $this->createPropertyDefinition($this->reflection()->getName(), $name);
    }

    /**
     * @param null|int $mask
     *
     * @return PropertyInspector[]
     */
    public function properties($mask = null)
    {
        $ps = $this->reflection()->getProperties($mask ?: $this->maskPropertyDefaults());
        $_ = function (\ReflectionProperty &$m) {
            $m = $this->createPropertyDefinition($this->reflection()->getName(), $m->getName());
        };

        array_walk($ps, $_);

        return array_values($ps);
    }

    /**
     * @return PropertyInspector[]
     */
    public function publicProperties()
    {
        return $this->properties(\ReflectionProperty::IS_PUBLIC);
    }

    /**
     * @return PropertyInspector[]
     */
    public function protectedProperties()
    {
        return $this->properties(\ReflectionProperty::IS_PROTECTED);
    }

    /**
     * @return PropertyInspector[]
     */
    public function privateProperties()
    {
        return $this->properties(\ReflectionProperty::IS_PRIVATE);
    }

    /**
     * @param \Closure $sort
     * @param null|int $mask
     * @param mixed    ...$extra
     *
     * @return PropertyInspector[]
     */
    public function sortProperties(\Closure $sort, $mask = null, &...$extra)
    {
        return $this->resolver()->sort($this->properties($mask), $sort, ...$extra);
    }

    /**
     * @param \Closure $visit
     * @param null|int $mask
     * @param mixed    ...$extra
     *
     * @return PropertyInspector[]|mixed[]
     */
    public function visitProperties(\Closure $visit, $mask = null, &...$extra)
    {
        return $this->resolver()->visit($this->properties($mask), $visit, ...$extra);
    }

    /**
     * @param \Closure $predicate
     * @param null|int $mask
     * @param mixed    ...$extra
     *
     * @return PropertyInspector[]
     */
    public function filterProperties(\Closure $predicate, $mask = null, &...$extra)
    {
        return $this->resolver()->filter($this->properties($mask), $predicate, ...$extra);
    }

    /**
     * @param \Closure $predicate
     * @param null|int $mask
     * @param mixed    ...$extra
     *
     * @return PropertyInspector|null
     */
    public function filterOneProperty(\Closure $predicate, $mask = null, &...$extra)
    {
        return $this->resolver()->filterOne($this->properties($mask), $predicate, ...$extra);
    }

    /**
     * @param mixed    $match
     * @param string   $func
     * @param null|int $mask
     *
     * @return PropertyInspector[]
     */
    public function matchProperties($match, $func = '__toString', $mask = null)
    {
        return $this->resolver()->match($this->properties($mask), $match, $func);
    }

    /**
     * @param mixed    $match
     * @param string   $func
     * @param null|int $mask
     *
     * @return null|PropertyInspector
     */
    public function matchOneProperty($match, $func = '__toString', $mask = null)
    {
        return $this->resolver()->matchOne($this->properties($mask), $match, $func);
    }

    /**
     * @return int
     */
    private function maskPropertyDefaults()
    {
        return \ReflectionProperty::IS_PUBLIC | \ReflectionProperty::IS_PROTECTED | \ReflectionProperty::IS_PRIVATE;
    }

    /**
     * @param string $class
     * @param string $method
     *
     * @return PropertyInspector
     */
    private function createPropertyDefinition($class, $property)
    {
        return new PropertyInspector($class, $property);
    }
}

/* EOF */
