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
use SR\Reflection\Introspect\Type\ClassAware\MethodAwareAccessorsInterface;
use SR\Reflection\Introspect\Type\ClassAware\MethodAwareAccessorsTrait;
use SR\Reflection\Introspect\Type\ClassAware\ModifiersAwareAccessorsInterface;
use SR\Reflection\Introspect\Type\ClassAware\ModifiersAwareAccessorsTrait;
use SR\Utility\ClassInspect;

/**
 * Base introspection interface.
 */
class InterfaceIntrospect extends AbstractIntrospect implements ConstantAwareAccessorsInterface, LocationAwareAccessorsInterface, MethodAwareAccessorsInterface, ModifiersAwareAccessorsInterface, IdentityAwareAccessorsInterface
{
    use ConstantAwareAccessorsTrait;
    use IdentityAwareAccessorsTrait;
    use LocationAwareAccessorsTrait;
    use MethodAwareAccessorsTrait;
    use ModifiersAwareAccessorsTrait;

    /**
     * @param string                 $interface
     * @param null|object            $bind
     * @param null|ResolverInterface $resolver
     */
    public function __construct($interface, $bind = null, ResolverInterface $resolver = null)
    {
        try {
            ClassInspect::assertInterface($interface);
            parent::__construct(new \ReflectionClass($interface), $bind, $resolver);
        } catch (\Exception $exception) {
            throw $this->getConstructorException(['interface name string', $interface]);
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
