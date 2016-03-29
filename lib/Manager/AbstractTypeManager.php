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

namespace SR\Reflection\Manager;

use SR\Reflection\Manager\Resolver\ResultSetResolver;
use SR\Reflection\Manager\Resolver\ResolverInterface;

/**
 * Class AbstractTypeManager.
 */
abstract class AbstractTypeManager implements TypeManagerInterface
{
    /**
     * @var \ReflectionClass|\ReflectionObject|\Reflector|null
     */
    protected $reflection;

    /**
     * @var ResolverInterface
     */
    protected $resolver;

    /**
     * @param \Reflector        $reflection
     * @param object|null       $bindScope
     * @param ResultSetResolver $resolver
     */
    public function __construct(\Reflector $reflection, $bindScope = null, ResultSetResolver $resolver = null)
    {
        $this->initializeReflection($reflection);
        $this->initializeResolver($resolver, $bindScope);
    }

    /**
     * @return \ReflectionClass|\ReflectionObject|\Reflector|null
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
     * @param ResolverInterface|null $resolver
     * @param null|object            $bind
     */
    protected function initializeResolver(ResolverInterface $resolver = null, $bind = null)
    {
        $this->resolver = $resolver ?: new ResultSetResolver();
        $this->resolver->bind($bind);
    }

    /**
     * @param \Reflector $reflection
     */
    protected function initializeReflection(\Reflector $reflection)
    {
        $failedSet = array_filter($this->reflectionRequiredIsInstanceOfSet(), function ($type) use ($reflection) {
            return ! $reflection instanceof $type;
        });

        if (count($failedSet) !== 0) {
            throw new \InvalidArgumentException(sprintf('Failed instanceof checks: %s', implode(', ', (array)$failedSet)));
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
