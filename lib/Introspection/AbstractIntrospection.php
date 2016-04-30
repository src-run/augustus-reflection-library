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

namespace SR\Reflection\Introspection;

use SR\Exception\InvalidArgumentException;
use SR\Reflection\Introspection\Resolver\ResultResolver;
use SR\Reflection\Introspection\Resolver\ResolverInterface;
use SR\Reflection\Introspection\Type\ClassAware\IdentityAwareAccessorsTrait;
use SR\Reflection\Introspection\Type\ClassAware\MethodAwareAccessorsTrait;
use SR\Reflection\Introspection\Type\ClassAware\PropertyAwareAccessorsTrait;
use SR\Reflection\Introspection\Type\ClassAware\IdentityAwareAccessorsInterface;
use SR\Reflection\Introspection\Type\ClassAware\MethodAwareAccessorsInterface;
use SR\Reflection\Introspection\Type\ClassAware\PropertyAwareAccessorsInterface;

/**
 * Class AbstractIntrospection.
 */
abstract class AbstractIntrospection implements IdentityAwareAccessorsInterface, MethodAwareAccessorsInterface,
                                                PropertyAwareAccessorsInterface
{
    use IdentityAwareAccessorsTrait;
    use MethodAwareAccessorsTrait;
    use PropertyAwareAccessorsTrait;

    /**
     * @var null|\ReflectionClass|\ReflectionObject|\Reflector
     */
    protected $reflection;

    /**
     * @var ResolverInterface
     */
    protected $resolver;

    /**
     * @param \Reflector     $reflection
     * @param null|object    $bindScope
     * @param ResultResolver $resolver
     */
    public function __construct(\Reflector $reflection, $bindScope = null, ResultResolver $resolver = null)
    {
        $this->initializeReflection($reflection);
        $this->initializeResolver($resolver, $bindScope);
    }

    /**
     * @return null|\ReflectionClass|\ReflectionObject|\Reflector
     */
    public function reflection()
    {
        return $this->reflection;
    }

    /**
     * @return ResolverInterface
     */
    public function resolver()
    {
        return $this->resolver;
    }

    /**
     * @param null|ResolverInterface $resolver
     * @param null|object            $bind
     */
    protected function initializeResolver(ResolverInterface $resolver = null, $bind = null)
    {
        $this->resolver = $resolver ?: new ResultResolver();
        $this->resolver->bind($bind);
    }

    /**
     * @param \Reflector $reflection
     */
    protected function initializeReflection(\Reflector $reflection)
    {
        $failedSet = array_filter($this->reflectionRequiredIsInstanceOfSet(), function ($type) use ($reflection) {
            return !$reflection instanceof $type;
        });

        if (count($failedSet) !== 0) {
            throw InvalidArgumentException::create('Failed instanceof checks: %s')
                ->with(implode(', ', (array) $failedSet));
        }

        $this->reflection = $reflection;
    }

    /**
     * @return string[]
     */
    protected function reflectionRequiredIsInstanceOfSet()
    {
        return ['\Reflector'];
    }
}

/* EOF */
