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
use SR\Reflection\Inspector\Aware\ScopeClass\IdentityAwareInterface;
use SR\Reflection\Inspector\Aware\ScopeClass\IdentityAwareTrait;
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

class TraitInspector extends AbstractInspector implements IdentityAwareInterface, LocationAwareInterface, MethodAwareInterface, ModifiersAwareInterface, PropertyAwareInterface
{
    use IdentityAwareTrait;
    use LocationAwareTrait;
    use MethodAwareTrait;
    use ModifiersAwareTrait;
    use PropertyAwareTrait;

    /**
     * @param string      $name
     * @param object|null $bind
     *
     * @throws InvalidArgumentException
     */
    public function __construct($name, $bind = null, ResolverInterface $resolver = null)
    {
        try {
            ClassQuery::assertTrait($name);
            parent::__construct(new \ReflectionClass($name), $bind, $resolver);
        } catch (\Exception $exception) {
            throw $this->getConstructorException(['trait name string', $name]);
        }
    }

    /**
     * @return string[]
     */
    protected function getReflectionRequirements()
    {
        return ['\ReflectionClass'];
    }
}
