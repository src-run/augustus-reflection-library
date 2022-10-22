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
use SR\Reflection\Inspector\Aware\ScopeCore\LocationAwareInterface;
use SR\Reflection\Inspector\Aware\ScopeCore\LocationAwareTrait;
use SR\Reflection\Inspector\Aware\ScopeCore\VisibilityAwareInterface;
use SR\Reflection\Inspector\Aware\ScopeCore\VisibilityAwareTrait;
use SR\Reflection\Inspector\Aware\ScopeMethod\CallableAwareInterface;
use SR\Reflection\Inspector\Aware\ScopeMethod\CallableAwareTrait;
use SR\Reflection\Inspector\Aware\ScopeMethod\IdentityAwareInterface;
use SR\Reflection\Inspector\Aware\ScopeMethod\IdentityAwareTrait;
use SR\Reflection\Inspector\Aware\ScopeMethod\ModifiersAwareInterface;
use SR\Reflection\Inspector\Aware\ScopeMethod\ModifiersAwareTrait;
use SR\Reflection\Resolver\ResolverInterface;
use SR\Utilities\Query\ClassQuery;

class MethodInspector extends AbstractInspector implements CallableAwareInterface, IdentityAwareInterface, LocationAwareInterface, ModifiersAwareInterface, VisibilityAwareInterface
{
    use CallableAwareTrait;
    use IdentityAwareTrait;
    use LocationAwareTrait;
    use ModifiersAwareTrait;
    use VisibilityAwareTrait;

    /**
     * @param string      $class
     * @param string      $method
     * @param object|null $bindTo
     *
     * @throws InvalidArgumentException
     */
    public function __construct($class, $method, $bindTo = null, ResolverInterface $resolver = null)
    {
        try {
            parent::__construct(new \ReflectionMethod($class, $method), $bindTo, $resolver);

            if (ClassQuery::isTrait($class)) {
                $this->declaringClass = new TraitInspector($class);
            }

            if (!ClassQuery::isTrait($class) && ClassQuery::isClass($class)) {
                $this->declaringClass = new ClassInspector($class);
            }
        } catch (\Exception $exception) {
            throw $this->getConstructorException(['class name string', $class], ['method name string', $method]);
        }
    }

    /**
     * @return string[]
     */
    protected function getReflectionRequirements()
    {
        return ['\ReflectionMethod'];
    }
}
