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
use SR\Reflection\Definition\ReflectionConstant;
use SR\Reflection\Introspection\Resolver\ResolverInterface;

/**
 * Class ConstantAwareAccessorsTrait.
 */
trait ConstantAwareAccessorsTrait //extends ConstantAwareAccessorsInterface
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
     * @return ReflectionConstant
     */
    public function getConstant($name)
    {
        if (!$this->hasConstant($name)) {
            throw InvalidArgumentException::create('Constant %s not found.')->with($name);
        }

        $value = $this->reflection()->getConstant($name);

        return $this->createConstantDefinition($name, $value);
    }

    /**
     * @return ReflectionConstant[]
     */
    public function constants()
    {
        $cs = $this->reflection()->getConstants();
        $_ = function (&$value, $name) {
            $value = $this->createConstantDefinition($name, $value);
        };

        array_walk($cs, $_);

        return array_values($cs);
    }

    /**
     * @param \Closure $sort
     * @param mixed    ...$extra
     *
     * @return ReflectionConstant[]
     */
    public function sortConstants(\Closure $sort, &...$extra)
    {
        return $this->resolver()->sort($this->constants(), $sort, ...$extra);
    }

    /**
     * @param \Closure $visit
     * @param mixed    ...$extra
     *
     * @return ReflectionConstant[]|mixed[]
     */
    public function visitConstants(\Closure $visit, &...$extra)
    {
        return $this->resolver()->visit($this->constants(), $visit, ...$extra);
    }

    /**
     * @param \Closure $predicate
     * @param mixed    ...$extra
     *
     * @return ReflectionConstant[]
     */
    public function filterConstants(\Closure $predicate, &...$extra)
    {
        return $this->resolver()->filter($this->constants(), $predicate, ...$extra);
    }

    /**
     * @param \Closure $predicate
     * @param mixed    ...$extra
     *
     * @return null|ReflectionConstant
     */
    public function filterOneConstant(\Closure $predicate, &...$extra)
    {
        return $this->resolver()->filterOne($this->constants(), $predicate, ...$extra);
    }

    /**
     * @param mixed  $match
     * @param string $func
     *
     * @return ReflectionConstant[]
     */
    public function matchConstants($match, $func = '__toString')
    {
        return $this->resolver()->match($this->constants(), $match, $func);
    }

    /**
     * @param mixed  $match
     * @param string $func
     *
     * @return null|ReflectionConstant
     */
    public function matchOneConstant($match, $func = '__toString')
    {
        return $this->resolver()->matchOne($this->constants(), $match, $func);
    }

    /**
     * @param string     $name
     * @param null|mixed $value
     *
     * @return ReflectionConstant
     */
    public function createConstantDefinition($name, $value = null)
    {
        return new ReflectionConstant($name, $value);
    }
}

/* EOF */
