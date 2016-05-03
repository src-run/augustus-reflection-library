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
use SR\Reflection\Introspection\Type\Aware\LocationAwareAccessorsInterface;
use SR\Reflection\Introspection\Type\Aware\LocationAwareAccessorsTrait;
use SR\Reflection\Introspection\Type\ClassAware\ConstantAwareAccessorsTrait;
use SR\Reflection\Introspection\Type\ClassAware\ConstantAwareAccessorsInterface;
use SR\Reflection\Introspection\Type\ClassAware\IdentityAwareAccessorsTrait;
use SR\Reflection\Introspection\Type\ClassAware\IdentityAwareAccessorsInterface;
use SR\Reflection\Introspection\Type\ClassAware\InterfaceAwareAccessorsInterface;
use SR\Reflection\Introspection\Type\ClassAware\InterfaceAwareAccessorsTrait;
use SR\Reflection\Introspection\Type\ClassAware\MethodAwareAccessorsInterface;
use SR\Reflection\Introspection\Type\ClassAware\MethodAwareAccessorsTrait;
use SR\Reflection\Introspection\Type\ClassAware\ModifiersAwareAccessorsInterface;
use SR\Reflection\Introspection\Type\ClassAware\ModifiersAwareAccessorsTrait;
use SR\Reflection\Introspection\Type\ClassAware\PropertyAwareAccessorsInterface;
use SR\Reflection\Introspection\Type\ClassAware\PropertyAwareAccessorsTrait;
use SR\Utility\ClassInspect;

/**
 * Class ObjectIntrospection.
 */
class ObjectIntrospection extends AbstractIntrospection implements ConstantAwareAccessorsInterface, IdentityAwareAccessorsInterface,
                                                                   InterfaceAwareAccessorsInterface, LocationAwareAccessorsInterface,
                                                                   MethodAwareAccessorsInterface, ModifiersAwareAccessorsInterface,
                                                                   PropertyAwareAccessorsInterface
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
     * @param null|object            $bindTo
     * @param null|ResolverInterface $resolver
     */
    public function __construct($instance, $bindTo = null, ResolverInterface $resolver = null)
    {
        try {
            ClassInspect::assertInstance($instance);
            parent::__construct(new \ReflectionObject($instance), $bindTo, $resolver);
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
