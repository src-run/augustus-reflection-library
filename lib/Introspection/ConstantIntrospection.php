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

use SR\Reflection\Definition\ReflectionConstant;
use SR\Reflection\Introspection\Resolver\ResolverInterface;
use SR\Reflection\Introspection\Type\ConstantAware\IdentityAwareAccessorsInterface;
use SR\Reflection\Introspection\Type\ConstantAware\IdentityAwareAccessorsTrait;
use SR\Utility\ClassInspect;

/**
 * Class ConstantIntrospection.
 */
class ConstantIntrospection extends AbstractIntrospection implements IdentityAwareAccessorsInterface
{
    use IdentityAwareAccessorsTrait;

    /**
     * @param string                 $class
     * @param string                 $constant
     * @param null|object            $bindTo
     * @param null|ResolverInterface $resolver
     */
    public function __construct($class, $constant, $bindTo = null, ResolverInterface $resolver = null)
    {
        try {
            parent::__construct(new ReflectionConstant($class, $constant), $bindTo, $resolver);

            if (ClassInspect::isInterface($class)) {
                $this->declaringClass = new InterfaceIntrospection($class);
            } elseif (ClassInspect::isClass($class)) {
                $this->declaringClass = new ClassIntrospection($class);
            }
        }
        catch (\Exception $exception) {
            throw $this->getConstructorException(['class name string', $class], ['constant name string', $constant]);
        }
    }

    /**
     * @return mixed
     */
    public function value()
    {
        return constant($this->declaringClass()->nameQualified().'::'.$this->name());
    }

    /**
     * @param object|string $context
     *
     * @return mixed|null
     */
    public function isNull()
    {
        return null === $this->value();
    }

    /**
     * @param string $class
     * @param string $name
     *
     * @return string
     */
    public static function export($class, $name)
    {
        return self::exportFor('\SR\Reflection\Definition\ReflectionConstant', $class, $name);
    }

    /**
     * @return string[]
     */
    protected function getReflectionRequirements()
    {
        return [];
    }
}

/* EOF */
