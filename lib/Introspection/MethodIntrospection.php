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
use SR\Reflection\Introspection\Type\Aware\VisibilityAwareAccessorsInterface;
use SR\Reflection\Introspection\Type\Aware\VisibilityAwareAccessorsTrait;
use SR\Reflection\Introspection\Type\MethodAware\CallableAwareAccessorsInterface;
use SR\Reflection\Introspection\Type\MethodAware\CallableAwareAccessorsTrait;
use SR\Reflection\Introspection\Type\MethodAware\IdentityAwareAccessorsInterface;
use SR\Reflection\Introspection\Type\MethodAware\IdentityAwareAccessorsTrait;
use SR\Reflection\Introspection\Type\MethodAware\ModifiersAwareAccessorsInterface;
use SR\Reflection\Introspection\Type\MethodAware\ModifiersAwareAccessorsTrait;
use SR\Utility\ClassInspect;

/**
 * Class MethodIntrospection.
 */
class MethodIntrospection extends AbstractIntrospection implements CallableAwareAccessorsInterface, IdentityAwareAccessorsInterface,
                                                                   LocationAwareAccessorsInterface, ModifiersAwareAccessorsInterface,
                                                                   VisibilityAwareAccessorsInterface
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
            $this->declaringClass = new ClassIntrospection($class);
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
