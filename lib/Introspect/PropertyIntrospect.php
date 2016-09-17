<?php

/*
 * This file is part of the `src-run/augustus-reflection-library` project.
 *
 * (c) Rob Frawley 2nd <rmf@src.run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace SR\Reflection\Introspect;

use SR\Reflection\Introspect\Resolver\ResolverInterface;
use SR\Reflection\Introspect\Type\Aware\VisibilityAwareAccessorsInterface;
use SR\Reflection\Introspect\Type\Aware\VisibilityAwareAccessorsTrait;
use SR\Reflection\Introspect\Type\PropertyAware\IdentityAwareAccessorsInterface;
use SR\Reflection\Introspect\Type\PropertyAware\IdentityAwareAccessorsTrait;
use SR\Reflection\Introspect\Type\PropertyAware\ModifiersAwareAccessorsInterface;
use SR\Reflection\Introspect\Type\PropertyAware\ModifiersAwareAccessorsTrait;
use SR\Reflection\Introspect\Type\PropertyAware\ValueAwareAccessorsInterface;
use SR\Reflection\Introspect\Type\PropertyAware\ValueAwareAccessorsTrait;

/**
 * Property introspection class.
 */
class PropertyIntrospect extends AbstractIntrospect implements IdentityAwareAccessorsInterface, ModifiersAwareAccessorsInterface, ValueAwareAccessorsInterface, VisibilityAwareAccessorsInterface
{
    use IdentityAwareAccessorsTrait;
    use ModifiersAwareAccessorsTrait;
    use ValueAwareAccessorsTrait;
    use VisibilityAwareAccessorsTrait;

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
            $this->declaringClass = new ClassIntrospect($class);
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

/* EOF */
