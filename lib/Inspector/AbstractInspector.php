<?php

/*
 * This file is part of the `src-run/augustus-reflection-library` project.
 *
 * (c) Rob Frawley 2nd <rmf@src.run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace SR\Reflection\Inspector;

use SR\Reflection\Exception\InvalidArgumentException;
use SR\Reflection\Inspector\Aware\ScopeCore\DocBlockAwareInterface;
use SR\Reflection\Inspector\Aware\ScopeCore\DocBlockAwareTrait;
use SR\Reflection\Resolver\Resolver;
use SR\Reflection\Resolver\ResolverInterface;

abstract class AbstractInspector implements \Reflector, DocBlockAwareInterface
{
    use DocBlockAwareTrait;

    protected null|\ReflectionClass|\ReflectionObject|\Reflector $reflection;

    protected ResolverInterface $resolver;

    /**
     * @param object|null $bind
     * @param Resolver    $resolver
     */
    public function __construct(\Reflector $reflection, $bind = null, Resolver $resolver = null)
    {
        $this->setReflection($reflection);
        $this->setResolver($resolver, $bind);
    }

    /**
     * @return string
     */
    final public function __toString()
    {
        return $this->nameQualified();
    }

    /**
     * @return \ReflectionMethod|\ReflectionProperty|\ReflectionClass|\ReflectionObject|\Reflector
     */
    final public function reflection()
    {
        return $this->reflection;
    }

    /**
     * @return ResolverInterface
     */
    final public function resolver()
    {
        return $this->resolver;
    }

    /**
     * @return string
     */
    abstract public function nameQualified();

    /**
     * @param object|null $bind
     *
     * @return $this
     */
    protected function setResolver(ResolverInterface $resolver = null, $bind = null)
    {
        $this->resolver = $resolver ?: new Resolver();
        $this->resolver->bind($bind);

        return $this;
    }

    /**
     * @return string[]
     */
    abstract protected function getReflectionRequirements();

    /**
     * @return $this
     */
    final protected function setReflection(\Reflector $reflection)
    {
        $failedChecks = array_filter($this->getReflectionRequirements(), function ($type) use ($reflection) {
            return !$reflection instanceof $type;
        });

        if (0 !== count($failedChecks)) {
            throw InvalidArgumentException::create('Failed required instanceof checks against: %s', implode(', ', $failedChecks));
        }

        $this->reflection = $reflection;

        return $this;
    }

    /**
     * @param mixed ...$for
     *
     * @return InvalidArgumentException
     */
    final protected function getConstructorException(...$for)
    {
        $message = [];

        foreach ($for as $i => $f) {
            $message[] = sprintf(
                'parameter "%d" must be valid %s, got type "%s" containing "%s"',
                $i + 1,
                $f[0],
                gettype($f[1]),
                $f[1]
            );
        }

        return InvalidArgumentException::create('Invalid constructor parameters provided: %s', implode('; ', $message));
    }
}
