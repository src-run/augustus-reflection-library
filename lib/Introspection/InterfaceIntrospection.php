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
use SR\Reflection\Introspection\Type\ClassAware\MethodAwareAccessorsInterface;
use SR\Reflection\Introspection\Type\ClassAware\MethodAwareAccessorsTrait;
use SR\Reflection\Introspection\Type\ClassAware\ModifiersAwareAccessorsInterface;
use SR\Reflection\Introspection\Type\ClassAware\ModifiersAwareAccessorsTrait;
use SR\Utility\ClassInspect;

/**
 * Class InterfaceIntrospection.
 */
class InterfaceIntrospection extends AbstractIntrospection implements ConstantAwareAccessorsInterface, LocationAwareAccessorsInterface,
                                                                      MethodAwareAccessorsInterface, ModifiersAwareAccessorsInterface,
                                                                      IdentityAwareAccessorsInterface
{
    use ConstantAwareAccessorsTrait;
    use IdentityAwareAccessorsTrait;
    use LocationAwareAccessorsTrait;
    use MethodAwareAccessorsTrait;
    use ModifiersAwareAccessorsTrait;

    /**
     * @param string                 $interface
     * @param null|object            $bindTo
     * @param null|ResolverInterface $resolver
     */
    public function __construct($interface, $bindTo = null, ResolverInterface $resolver = null)
    {
        try {
            ClassInspect::assertInterface($interface);
            parent::__construct(new \ReflectionClass($interface), $bindTo, $resolver);
        }
        catch (\Exception $exception) {
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
