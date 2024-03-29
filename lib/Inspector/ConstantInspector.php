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

use SR\Exception\ExceptionInterface;
use SR\Reflection\Definition\ReflectionConstant;
use SR\Reflection\Exception\InvalidArgumentException;
use SR\Reflection\Inspector\Aware\ScopeConstant\IdentityAwareInterface;
use SR\Reflection\Inspector\Aware\ScopeConstant\IdentityAwareTrait;
use SR\Reflection\Resolver\ResolverInterface;
use SR\Utilities\Query\ClassQuery;

class ConstantInspector extends AbstractInspector implements IdentityAwareInterface
{
    use IdentityAwareTrait;

    /**
     * @param string      $class
     * @param string      $constant
     * @param object|null $bindTo
     *
     * @throws InvalidArgumentException|ExceptionInterface
     */
    public function __construct($class, $constant, $bindTo = null, ResolverInterface $resolver = null)
    {
        try {
            parent::__construct(new ReflectionConstant($class, $constant), $bindTo, $resolver);

            if (ClassQuery::isInterface($class)) {
                $this->declaringClass = new InterfaceInspector($class);
            } elseif (ClassQuery::isClass($class)) {
                $this->declaringClass = new ClassInspector($class);
            }
        } catch (\Exception $exception) {
            throw $this->getConstructorException(['class name string', $class], ['constant name string', $constant]);
        }
    }

    /**
     * @return mixed
     */
    public function value()
    {
        return constant($this->declaringClass()->nameQualified() . '::' . $this->name());
    }

    /**
     * @param object|string $context
     *
     * @return mixed|null
     */
    public function isNull()
    {
        return null === $this->value();
    }

    /**
     * @return string[]
     */
    protected function getReflectionRequirements()
    {
        return [];
    }
}
