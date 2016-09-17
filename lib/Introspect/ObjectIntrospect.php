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
use SR\Reflection\Introspect\Type\Aware\LocationAwareAccessorsInterface;
use SR\Reflection\Introspect\Type\Aware\LocationAwareAccessorsTrait;
use SR\Reflection\Introspect\Type\ClassAware\ConstantAwareAccessorsInterface;
use SR\Reflection\Introspect\Type\ClassAware\ConstantAwareAccessorsTrait;
use SR\Reflection\Introspect\Type\ClassAware\IdentityAwareAccessorsInterface;
use SR\Reflection\Introspect\Type\ClassAware\IdentityAwareAccessorsTrait;
use SR\Reflection\Introspect\Type\ClassAware\InterfaceAwareAccessorsInterface;
use SR\Reflection\Introspect\Type\ClassAware\InterfaceAwareAccessorsTrait;
use SR\Reflection\Introspect\Type\ClassAware\MethodAwareAccessorsInterface;
use SR\Reflection\Introspect\Type\ClassAware\MethodAwareAccessorsTrait;
use SR\Reflection\Introspect\Type\ClassAware\ModifiersAwareAccessorsInterface;
use SR\Reflection\Introspect\Type\ClassAware\ModifiersAwareAccessorsTrait;
use SR\Reflection\Introspect\Type\ClassAware\PropertyAwareAccessorsInterface;
use SR\Reflection\Introspect\Type\ClassAware\PropertyAwareAccessorsTrait;
use SR\Utility\ClassInspect;

/**
 * Class introspection class.
 */
class ObjectIntrospect extends AbstractIntrospect implements ConstantAwareAccessorsInterface, IdentityAwareAccessorsInterface, InterfaceAwareAccessorsInterface, LocationAwareAccessorsInterface, MethodAwareAccessorsInterface, ModifiersAwareAccessorsInterface, PropertyAwareAccessorsInterface
{
    use ConstantAwareAccessorsTrait;
    use IdentityAwareAccessorsTrait;
    use InterfaceAwareAccessorsTrait;
    use LocationAwareAccessorsTrait;
    use MethodAwareAccessorsTrait;
    use ModifiersAwareAccessorsTrait;
    use PropertyAwareAccessorsTrait;

    /**
     * @param object                 $instance
     * @param null|object            $bind
     * @param null|ResolverInterface $resolver
     */
    public function __construct($instance, $bind = null, ResolverInterface $resolver = null)
    {
        try {
            ClassInspect::assertInstance($instance);
            parent::__construct(new \ReflectionObject($instance), $bind, $resolver);
        } catch (\Exception $exception) {
            throw $this->getConstructorException(['object instance', $instance]);
        }
    }

    /**
     * @param object $instance
     *
     * @return string
     */
    public static function export($instance)
    {
        return self::exportFor('\ReflectionObject', $instance);
    }

    /**
     * @return string[]
     */
    protected function getReflectionRequirements()
    {
        return ['\ReflectionObject'];
    }
}

/* EOF */
