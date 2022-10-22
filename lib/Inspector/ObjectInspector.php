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
use SR\Reflection\Inspector\Aware\ScopeClass\ConstantAwareInterface;
use SR\Reflection\Inspector\Aware\ScopeClass\ConstantAwareTrait;
use SR\Reflection\Inspector\Aware\ScopeClass\IdentityAwareInterface;
use SR\Reflection\Inspector\Aware\ScopeClass\IdentityAwareTrait;
use SR\Reflection\Inspector\Aware\ScopeClass\InterfaceAwareInterface;
use SR\Reflection\Inspector\Aware\ScopeClass\InterfaceAwareTrait;
use SR\Reflection\Inspector\Aware\ScopeClass\MethodAwareInterface;
use SR\Reflection\Inspector\Aware\ScopeClass\MethodAwareTrait;
use SR\Reflection\Inspector\Aware\ScopeClass\ModifiersAwareInterface;
use SR\Reflection\Inspector\Aware\ScopeClass\ModifiersAwareTrait;
use SR\Reflection\Inspector\Aware\ScopeClass\PropertyAwareInterface;
use SR\Reflection\Inspector\Aware\ScopeClass\PropertyAwareTrait;
use SR\Reflection\Inspector\Aware\ScopeCore\LocationAwareInterface;
use SR\Reflection\Inspector\Aware\ScopeCore\LocationAwareTrait;
use SR\Reflection\Resolver\ResolverInterface;
use SR\Utilities\Query\ClassQuery;

class ObjectInspector extends AbstractInspector implements ConstantAwareInterface, IdentityAwareInterface, InterfaceAwareInterface, LocationAwareInterface, MethodAwareInterface, ModifiersAwareInterface, PropertyAwareInterface
{
    use ConstantAwareTrait;
    use IdentityAwareTrait;
    use InterfaceAwareTrait;
    use LocationAwareTrait;
    use MethodAwareTrait;
    use ModifiersAwareTrait;
    use PropertyAwareTrait;

    /**
     * @param object      $instance
     * @param object|null $bind
     *
     * @throws InvalidArgumentException
     */
    public function __construct($instance, $bind = null, ResolverInterface $resolver = null)
    {
        try {
            ClassQuery::assertInstance($instance);
            parent::__construct(new \ReflectionObject($instance), $bind, $resolver);
        } catch (\Exception $exception) {
            throw $this->getConstructorException(['object instance', $instance]);
        }
    }

    /**
     * @return string[]
     */
    protected function getReflectionRequirements()
    {
        return ['\ReflectionObject'];
    }
}
