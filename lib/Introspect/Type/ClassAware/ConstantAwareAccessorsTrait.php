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
use SR\Reflection\Introspect\ConstantIntrospect;
use SR\Reflection\Introspect\Resolver\ResolverInterface;

/**
 * Class ConstantAwareAccessorsTrait.
 */
trait ConstantAwareAccessorsTrait // implements ConstantAwareAccessorsInterface
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
    public function hasConstant($name)
    {
        return $this->reflection()->hasConstant($name);
    }

    /**
     * @param string $name
     *
     * @throws InvalidArgumentException
     *
     * @return ConstantIntrospect
     */
    public function getConstant($name)
    {
        if (!$this->hasConstant($name)) {
            throw InvalidArgumentException::create('Constant %s not found.')->with($name);
        }

        return $this->createConstantDefinition($this->reflection()->getName(), $name);
    }

    /**
     * @return ConstantIntrospect[]
     */
    public function constants()
    {
        $cs = $this->reflection()->getConstants();
        $_ = function (&$value, $name) {
            $value = $this->createConstantDefinition($this->reflection()->getName(), $name);
        };

        array_walk($cs, $_);

        return array_values($cs);
    }

    /**
     * @param \Closure $sort
     * @param mixed    ...$extra
     *
     * @return ConstantIntrospect[]
     */
    public function sortConstants(\Closure $sort, &...$extra)
    {
        return $this->resolver()->sort($this->constants(), $sort, ...$extra);
    }

    /**
     * @param \Closure $visit
     * @param mixed    ...$extra
     *
     * @return ConstantIntrospect[]|mixed[]
     */
    public function visitConstants(\Closure $visit, &...$extra)
    {
        return $this->resolver()->visit($this->constants(), $visit, ...$extra);
    }

    /**
     * @param \Closure $predicate
     * @param mixed    ...$extra
     *
     * @return ConstantIntrospect[]
     */
    public function filterConstants(\Closure $predicate, &...$extra)
    {
        return $this->resolver()->filter($this->constants(), $predicate, ...$extra);
    }

    /**
     * @param \Closure $predicate
     * @param mixed    ...$extra
     *
     * @return null|ConstantIntrospect
     */
    public function filterOneConstant(\Closure $predicate, &...$extra)
    {
        return $this->resolver()->filterOne($this->constants(), $predicate, ...$extra);
    }

    /**
     * @param mixed  $match
     * @param string $func
     *
     * @return ConstantIntrospect[]
     */
    public function matchConstants($match, $func = '__toString')
    {
        return $this->resolver()->match($this->constants(), $match, $func);
    }

    /**
     * @param mixed  $match
     * @param string $func
     *
     * @return null|ConstantIntrospect
     */
    public function matchOneConstant($match, $func = '__toString')
    {
        return $this->resolver()->matchOne($this->constants(), $match, $func);
    }

    /**
     * @param string $class
     * @param string $constant
     *
     * @return ConstantIntrospect
     */
    protected function createConstantDefinition($class, $constant)
    {
        return new ConstantIntrospect($class, $constant);
    }
}

/* EOF */
