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

use SR\Reflection\Inspector\Aware\ScopeCore\VisibilityAwareInterface;
use SR\Reflection\Inspector\Aware\ScopeCore\VisibilityAwareTrait;
use SR\Reflection\Inspector\Aware\ScopeProperty\IdentityAwareInterface;
use SR\Reflection\Inspector\Aware\ScopeProperty\IdentityAwareTrait;
use SR\Reflection\Inspector\Aware\ScopeProperty\ModifiersAwareInterface;
use SR\Reflection\Inspector\Aware\ScopeProperty\ModifiersAwareTrait;
use SR\Reflection\Inspector\Aware\ScopeProperty\ValueAwareInterface;
use SR\Reflection\Inspector\Aware\ScopeProperty\ValueAwareTrait;
use SR\Reflection\Resolver\ResolverInterface;

class PropertyInspector extends AbstractInspector implements IdentityAwareInterface, ModifiersAwareInterface, ValueAwareInterface, VisibilityAwareInterface
{
    use IdentityAwareTrait;
    use ModifiersAwareTrait;
    use ValueAwareTrait;
    use VisibilityAwareTrait;

    /**
     * @param string                 $class
     * @param string                 $property
     * @param null|object            $bindTo
     * @param null|ResolverInterface $resolver
     */
    public function __construct($class, $property, $bindTo = null, ResolverInterface $resolver = null)
    {
        try {
            parent::__construct(new \ReflectionProperty($class, $property), $bindTo, $resolver);
            $this->declaringClass = new ClassInspector($class);
        } catch (\Exception $exception) {
            throw $this->getConstructorException(['class name string', $class], ['property name string', $property]);
        }
    }

    /**
     * @param string $class
     * @param string $property
     *
     * @return string
     */
    public static function export($class, $property)
    {
        return self::exportFor('\ReflectionProperty', $class, $property);
    }

    /**
     * @return string[]
     */
    protected function getReflectionRequirements()
    {
        return ['\ReflectionProperty'];
    }
}

