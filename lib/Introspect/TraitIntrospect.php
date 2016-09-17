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
use SR\Reflection\Introspect\Type\ClassAware\IdentityAwareAccessorsInterface;
use SR\Reflection\Introspect\Type\ClassAware\IdentityAwareAccessorsTrait;
use SR\Reflection\Introspect\Type\ClassAware\MethodAwareAccessorsInterface;
use SR\Reflection\Introspect\Type\ClassAware\MethodAwareAccessorsTrait;
use SR\Reflection\Introspect\Type\ClassAware\ModifiersAwareAccessorsInterface;
use SR\Reflection\Introspect\Type\ClassAware\ModifiersAwareAccessorsTrait;
use SR\Reflection\Introspect\Type\ClassAware\PropertyAwareAccessorsInterface;
use SR\Reflection\Introspect\Type\ClassAware\PropertyAwareAccessorsTrait;
use SR\Utility\ClassInspect;

/**
 * Trait introspection class.
 */
class TraitIntrospect extends AbstractIntrospect implements IdentityAwareAccessorsInterface, LocationAwareAccessorsInterface, MethodAwareAccessorsInterface, ModifiersAwareAccessorsInterface, PropertyAwareAccessorsInterface
{
    use IdentityAwareAccessorsTrait;
    use LocationAwareAccessorsTrait;
    use MethodAwareAccessorsTrait;
    use ModifiersAwareAccessorsTrait;
    use PropertyAwareAccessorsTrait;

    /**
     * @param string                 $name
     * @param null|object            $bind
     * @param null|ResolverInterface $resolver
     */
    public function __construct($name, $bind = null, ResolverInterface $resolver = null)
    {
        try {
            ClassInspect::assertTrait($name);
            parent::__construct(new \ReflectionClass($name), $bind, $resolver);
        } catch (\Exception $exception) {
            throw $this->getConstructorException(['trait name string', $name]);
        }
    }

    /**
     * @param string $trait
     *
     * @return string
     */
    public static function export($trait)
    {
        return self::exportFor('\ReflectionClass', $trait);
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
