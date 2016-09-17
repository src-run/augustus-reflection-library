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
use SR\Reflection\Inspector\MethodInspector;
use SR\Reflection\Resolver\ResolverInterface;

/**
 * Class aware contextual, method aware accessors trait.
 */
trait MethodAwareTrait // implements MethodAwareInterface
{
    /**
     * @return \ReflectionClass|\ReflectionObject
     */
    abstract public function reflection();

    /**
     * @return ResolverInterface
     */
    abstract public function resolver();

    /**
     * Returns true if the method exists.
     *
     * @param string $method
     *
     * @return bool
     */
    public function hasMethod($method)
    {
        return $this->reflection()->hasMethod($method);
    }

    /**
     * Returns a method introspection instance.
     *
     * @param string $method
     *
     * @throws InvalidArgumentException
     *
     * @return MethodInspector
     */
    public function getMethod($method)
    {
        if (!$this->hasMethod($method)) {
            throw InvalidArgumentException::create('Method %s not found.', $method);
        }

        return $this->createMethodDefinition($this->reflection()->getName(), $method);
    }

    /**
     * Returns set of methods using mask.
     *
     * @param null|int $mask
     *
     * @return MethodInspector[]
     */
    public function getMethods($mask = null)
    {
        $methods = $this->reflection()->getMethods($mask ?: $this->maskMethodDefaults());
        $closure = function (\ReflectionMethod &$method) {
            $method = $this->createMethodDefinition($this->reflection()->getName(), $method->getName());
        };

        array_walk($methods, $closure);

        return array_values($methods);
    }

    /**
     * Returns set of public methods.
     *
     * @return MethodInspector[]
     */
    public function getMethodsPublic()
    {
        return $this->getMethods(\ReflectionMethod::IS_PUBLIC);
    }

    /**
     * Returns set of protected methods.
     *
     * @return MethodInspector[]
     */
    public function getMethodsProtected()
    {
        return $this->getMethods(\ReflectionMethod::IS_PROTECTED);
    }

    /**
     * Returns set of private methods.
     *
     * @return MethodInspector[]
     */
    public function getMethodsPrivate()
    {
        return $this->getMethods(\ReflectionMethod::IS_PRIVATE);
    }

    /**
     * Sort methods using closure.
     *
     * @param \Closure $sorter
     * @param null|int $mask
     * @param mixed    ...$parameters
     *
     * @return MethodInspector[]|\Reflector[]
     */
    public function sortMethods(\Closure $sorter, $mask = null, &...$parameters)
    {
        return $this->resolver()->sort($this->getMethods($mask), $sorter, ...$parameters);
    }

    /**
     * Visit methods using closure and return result.
     *
     * @param \Closure $visitor
     * @param null|int $mask
     * @param mixed    ...$parameters
     *
     * @return MethodInspector[]|\Reflector[]|mixed[]
     */
    public function visitMethods(\Closure $visitor, $mask = null, &...$parameters)
    {
        return $this->resolver()->visit($this->getMethods($mask), $visitor, ...$parameters);
    }

    /**
     * Filter methods using closure.
     *
     * @param \Closure $filter
     * @param null|int $mask
     * @param mixed    ...$parameters
     *
     * @return MethodInspector[]|\Reflector[]
     */
    public function filterMethods(\Closure $filter, $mask = null, &...$parameters)
    {
        return $this->resolver()->filter($this->getMethods($mask), $filter, ...$parameters);
    }

    /**
     * Filter methods using closure, expecting a single result.
     *
     * @param \Closure $filter
     * @param null|int $mask
     * @param mixed    ...$parameters
     *
     * @return MethodInspector|\Reflector|null
     */
    public function filterOneMethod(\Closure $filter, $mask = null, &...$parameters)
    {
        return $this->resolver()->filterOne($this->getMethods($mask), $filter, ...$parameters);
    }

    /**
     * Filter methods against provided value and result of calling method on the method introspection instance.
     *
     * @param mixed    $against
     * @param string   $method
     * @param null|int $mask
     *
     * @return MethodInspector[]|\Reflector[]
     */
    public function matchMethods($against, $method = '__toString', $mask = null)
    {
        return $this->resolver()->match($this->getMethods($mask), $against, $method);
    }

    /**
     * Perform same operations as {@see matchMethods()} but expect a single value to be returned.
     *
     * @param mixed    $match
     * @param string   $method
     * @param null|int $mask
     *
     * @return MethodInspector|\Reflector[]|null
     */
    public function matchOneMethod($match, $method = '__toString', $mask = null)
    {
        return $this->resolver()->matchOne($this->getMethods($mask), $match, $method);
    }

    /**
     * @return int
     */
    private function maskMethodDefaults()
    {
        return \ReflectionMethod::IS_PUBLIC | \ReflectionMethod::IS_PROTECTED | \ReflectionMethod::IS_PRIVATE;
    }

    /**
     * @param string $className
     * @param string $methodName
     *
     * @return MethodInspector
     */
    private function createMethodDefinition($className, $methodName)
    {
        return new MethodInspector($className, $methodName);
    }
}

/* EOF */
