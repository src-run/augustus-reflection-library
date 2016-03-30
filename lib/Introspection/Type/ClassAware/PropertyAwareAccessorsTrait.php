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
use SR\Reflection\Introspection\Resolver\ResolverInterface;

/**
 * Class PropertyAwareAccessorsTrait.
 */
trait PropertyAwareAccessorsTrait //extends PropertyAwareAccessorsInterface
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
     * @return \ReflectionProperty
     */
    public function getProperty($name)
    {
        if (! $this->hasProperty($name)) {
            throw InvalidArgumentException::create('Property %s not found.')->with($name);
        }

        return $this->reflection()->getProperty($name);
    }

    /**
     * @param null|int $mask
     *
     * @return \ReflectionProperty[]
     */
    public function properties($mask = null)
    {
        $mask = $mask ?: $this->maskPropertyDefaults();

        return (array) $this->reflection()->getProperties($mask);
    }

    /**
     * @return \ReflectionProperty[]
     */
    public function publicProperties()
    {
        return $this->properties(\ReflectionProperty::IS_PUBLIC);
    }

    /**
     * @return \ReflectionProperty[]
     */
    public function protectedProperties()
    {
        return $this->properties(\ReflectionProperty::IS_PROTECTED);
    }

    /**
     * @return \ReflectionProperty[]
     */
    public function privateProperties()
    {
        return $this->properties(\ReflectionProperty::IS_PRIVATE);
    }

    /**
     * @param \Closure  $sort
     * @param null|int  $mask
     * @param mixed,... $extra
     *
     * @return \ReflectionProperty[]
     */
    public function sortProperties(\Closure $sort, $mask = null, &...$extra)
    {
        return $this->resolver()->sort($this->properties($mask), $sort, ...$extra);
    }

    /**
     * @param \Closure  $visit
     * @param null|int  $mask
     * @param mixed,... $extra
     *
     * @return \ReflectionProperty[]|mixed[]
     */
    public function visitProperties(\Closure $visit, $mask = null, &...$extra)
    {
        return $this->resolver()->visit($this->properties($mask), $visit, ...$extra);
    }

    /**
     * @param \Closure  $predicate
     * @param null|int  $mask
     * @param mixed,... $extra
     *
     * @return \ReflectionProperty[]
     */
    public function filterProperties(\Closure $predicate, $mask = null, &...$extra)
    {
        return $this->resolver()->filter($this->properties($mask), $predicate, ...$extra);
    }

    /**
     * @param \Closure  $predicate
     * @param null|int  $mask
     * @param mixed,... $extra
     *
     * @return \ReflectionProperty|null
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
     * @return \ReflectionProperty[]
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
     * @return \ReflectionProperty|null
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
        return \ReflectionProperty::IS_PUBLIC|\ReflectionProperty::IS_PROTECTED|\ReflectionProperty::IS_PRIVATE;
    }
}

/* EOF */
