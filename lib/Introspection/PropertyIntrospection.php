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

use SR\Reflection\Introspection\Resolver\ResolverInterface;
use SR\Reflection\Introspection\Type\Aware\VisibilityAwareAccessorsInterface;
use SR\Reflection\Introspection\Type\Aware\VisibilityAwareAccessorsTrait;
use SR\Reflection\Introspection\Type\PropertyAware\IdentityAwareAccessorsInterface;
use SR\Reflection\Introspection\Type\PropertyAware\IdentityAwareAccessorsTrait;
use SR\Reflection\Introspection\Type\PropertyAware\ModifiersAwareAccessorsInterface;
use SR\Reflection\Introspection\Type\PropertyAware\ModifiersAwareAccessorsTrait;
use SR\Reflection\Introspection\Type\PropertyAware\ValueAwareAccessorsInterface;
use SR\Reflection\Introspection\Type\PropertyAware\ValueAwareAccessorsTrait;
use SR\Utility\ClassInspect;

/**
 * Class PropertyIntrospection.
 */
class PropertyIntrospection extends AbstractIntrospection implements IdentityAwareAccessorsInterface, ModifiersAwareAccessorsInterface,
                                                                     ValueAwareAccessorsInterface, VisibilityAwareAccessorsInterface
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
            $this->declaringClass = new ClassIntrospection($class);
        }
        catch (\Exception $exception) {
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
