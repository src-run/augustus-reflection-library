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
 * Class MethodAwareAccessorsTrait.
 */
trait MethodAwareAccessorsTrait //extends MethodAwareAccessorsInterface
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
    public function hasMethod($name)
    {
        return $this->reflection()->hasMethod($name);
    }

    /**
     * @param string $name
     *
     * @throws InvalidArgumentException
     *
     * @return \ReflectionMethod
     */
    public function getMethod($name)
    {
        if (!$this->hasMethod($name)) {
            throw InvalidArgumentException::create('Method %s not found.')->with($name);
        }

        return $this->reflection()->getMethod($name);
    }

    /**
     * @param null|int $mask
     *
     * @return \ReflectionMethod[]
     */
    public function methods($mask = null)
    {
        $mask = $mask ?: $this->maskMethodDefaults();

        return (array) $this->reflection()->getMethods($mask);
    }

    /**
     * @return \ReflectionMethod[]
     */
    public function publicMethods()
    {
        return $this->methods(\ReflectionMethod::IS_PUBLIC);
    }

    /**
     * @return \ReflectionMethod[]
     */
    public function protectedMethods()
    {
        return $this->methods(\ReflectionMethod::IS_PROTECTED);
    }

    /**
     * @return \ReflectionMethod[]
     */
    public function privateMethods()
    {
        return $this->methods(\ReflectionMethod::IS_PRIVATE);
    }

    /**
     * @param \Closure $sort
     * @param null|int $mask
     * @param mixed    ...$extra
     *
     * @return \ReflectionMethod[]
     */
    public function sortMethods(\Closure $sort, $mask = null, &...$extra)
    {
        return $this->resolver()->sort($this->methods($mask), $sort, ...$extra);
    }

    /**
     * @param \Closure $visit
     * @param null|int $mask
     * @param mixed    ...$extra
     *
     * @return \ReflectionMethod[]|mixed
     */
    public function visitMethods(\Closure $visit, $mask = null, &...$extra)
    {
        return $this->resolver()->visit($this->methods($mask), $visit, ...$extra);
    }

    /**
     * @param \Closure $predicate
     * @param null|int $mask
     * @param mixed    ...$extra
     *
     * @return \ReflectionMethod[]
     */
    public function filterMethods(\Closure $predicate, $mask = null, &...$extra)
    {
        return $this->resolver()->filter($this->methods($mask), $predicate, ...$extra);
    }

    /**
     * @param \Closure $predicate
     * @param null|int $mask
     * @param mixed    ...$extra
     *
     * @return \ReflectionMethod|null
     */
    public function filterOneMethod(\Closure $predicate, $mask = null, &...$extra)
    {
        return $this->resolver()->filterOne($this->methods($mask), $predicate, ...$extra);
    }

    /**
     * @param mixed    $match
     * @param string   $func
     * @param null|int $mask
     *
     * @return \ReflectionMethod[]
     */
    public function matchMethods($match, $func = '__toString', $mask = null)
    {
        return $this->resolver()->match($this->methods($mask), $match, $func);
    }

    /**
     * @param mixed    $match
     * @param string   $func
     * @param null|int $mask
     *
     * @return null|\ReflectionMethod
     */
    public function matchOneMethod($match, $func = '__toString', $mask = null)
    {
        return $this->resolver()->matchOne($this->methods($mask), $match, $func);
    }

    /**
     * @return int
     */
    private function maskMethodDefaults()
    {
        return \ReflectionMethod::IS_PUBLIC | \ReflectionMethod::IS_PROTECTED | \ReflectionMethod::IS_PRIVATE;
    }
}

/* EOF */
