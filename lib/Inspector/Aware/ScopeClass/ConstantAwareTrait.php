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
use SR\Reflection\Inspector\ConstantInspector;
use SR\Reflection\Resolver\ResolverInterface;

/**
 * Class ConstantAwareTrait.
 */
trait ConstantAwareTrait // implements ConstantAwareInterface
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
     * @return ConstantInspector
     */
    public function getConstant($name)
    {
        if (!$this->hasConstant($name)) {
            throw InvalidArgumentException::create('Constant %s not found.')->with($name);
        }

        return $this->createConstantDefinition($this->reflection()->getName(), $name);
    }

    /**
     * @return ConstantInspector[]
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
     * @return ConstantInspector[]
     */
    public function sortConstants(\Closure $sort, &...$extra)
    {
        return $this->resolver()->sort($this->constants(), $sort, ...$extra);
    }

    /**
     * @param \Closure $visit
     * @param mixed    ...$extra
     *
     * @return ConstantInspector[]|mixed[]
     */
    public function visitConstants(\Closure $visit, &...$extra)
    {
        return $this->resolver()->visit($this->constants(), $visit, ...$extra);
    }

    /**
     * @param \Closure $predicate
     * @param mixed    ...$extra
     *
     * @return ConstantInspector[]
     */
    public function filterConstants(\Closure $predicate, &...$extra)
    {
        return $this->resolver()->filter($this->constants(), $predicate, ...$extra);
    }

    /**
     * @param \Closure $predicate
     * @param mixed    ...$extra
     *
     * @return null|ConstantInspector
     */
    public function filterOneConstant(\Closure $predicate, &...$extra)
    {
        return $this->resolver()->filterOne($this->constants(), $predicate, ...$extra);
    }

    /**
     * @param mixed  $match
     * @param string $func
     *
     * @return ConstantInspector[]
     */
    public function matchConstants($match, $func = '__toString')
    {
        return $this->resolver()->match($this->constants(), $match, $func);
    }

    /**
     * @param mixed  $match
     * @param string $func
     *
     * @return null|ConstantInspector
     */
    public function matchOneConstant($match, $func = '__toString')
    {
        return $this->resolver()->matchOne($this->constants(), $match, $func);
    }

    /**
     * @param string $class
     * @param string $constant
     *
     * @return ConstantInspector
     */
    protected function createConstantDefinition($class, $constant)
    {
        return new ConstantInspector($class, $constant);
    }
}

/* EOF */
