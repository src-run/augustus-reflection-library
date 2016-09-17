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
use SR\Reflection\Introspect\Type\Aware\VisibilityAwareAccessorsInterface;
use SR\Reflection\Introspect\Type\Aware\VisibilityAwareAccessorsTrait;
use SR\Reflection\Introspect\Type\MethodAware\CallableAwareAccessorsInterface;
use SR\Reflection\Introspect\Type\MethodAware\CallableAwareAccessorsTrait;
use SR\Reflection\Introspect\Type\MethodAware\IdentityAwareAccessorsInterface;
use SR\Reflection\Introspect\Type\MethodAware\IdentityAwareAccessorsTrait;
use SR\Reflection\Introspect\Type\MethodAware\ModifiersAwareAccessorsInterface;
use SR\Reflection\Introspect\Type\MethodAware\ModifiersAwareAccessorsTrait;
use SR\Utility\ClassInspect;

/**
 * Method introspection class.
 */
class MethodIntrospect extends AbstractIntrospect implements CallableAwareAccessorsInterface, IdentityAwareAccessorsInterface, LocationAwareAccessorsInterface, ModifiersAwareAccessorsInterface, VisibilityAwareAccessorsInterface
{
    use CallableAwareAccessorsTrait;
    use IdentityAwareAccessorsTrait;
    use LocationAwareAccessorsTrait;
    use ModifiersAwareAccessorsTrait;
    use VisibilityAwareAccessorsTrait;

    /**
     * @param string                 $class
     * @param string                 $method
     * @param null|object            $bindTo
     * @param null|ResolverInterface $resolver
     */
    public function __construct($class, $method, $bindTo = null, ResolverInterface $resolver = null)
    {
        try {
            parent::__construct(new \ReflectionMethod($class, $method), $bindTo, $resolver);

            if (ClassInspect::isTrait($class)) {
                $this->declaringClass = new TraitIntrospect($class);
            }

            if (!ClassInspect::isTrait($class) && ClassInspect::isClass($class)) {
                $this->declaringClass = new ClassIntrospect($class);
            }
        }
        catch (\Exception $exception) {
            throw $this->getConstructorException(['class name string', $class], ['method name string', $method]);
        }
    }

    /**
     * @param string $class
     * @param string $method
     *
     * @return string
     */
    public static function export($class, $method)
    {
        return self::exportFor('\ReflectionMethod', $class, $method);
    }

    /**
     * @return string[]
     */
    protected function getReflectionRequirements()
    {
        return ['\ReflectionMethod'];
    }
}

/* EOF */
