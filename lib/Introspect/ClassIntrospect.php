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
 * Class/object introspection class.
 */
class ClassIntrospect extends AbstractIntrospect implements ConstantAwareAccessorsInterface, IdentityAwareAccessorsInterface, InterfaceAwareAccessorsInterface, LocationAwareAccessorsInterface, MethodAwareAccessorsInterface, ModifiersAwareAccessorsInterface, PropertyAwareAccessorsInterface
{
    use ConstantAwareAccessorsTrait;
    use IdentityAwareAccessorsTrait;
    use InterfaceAwareAccessorsTrait;
    use LocationAwareAccessorsTrait;
    use ModifiersAwareAccessorsTrait;
    use MethodAwareAccessorsTrait;
    use PropertyAwareAccessorsTrait;

    /**
     * @param string                 $class
     * @param null|object            $bind
     * @param null|ResolverInterface $resolver
     */
    public function __construct($class, $bind = null, ResolverInterface $resolver = null)
    {
        try {
            ClassInspect::assertClass($class);
            parent::__construct(new \ReflectionClass($class), $bind, $resolver);
        } catch (\Exception $exception) {
            throw $this->getConstructorException(['class name string', $class]);
        }
    }

    /**
     * @param string $class
     *
     * @return string
     */
    public static function export($class)
    {
        return self::exportFor('\ReflectionClass', $class);
    }

    /**
     * @return string[]
     */
    protected function getReflectionRequirements()
    {
        return ['\ReflectionClass'];
    }
}

/* EOF */
