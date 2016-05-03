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
use SR\Reflection\Introspection\Type\ClassAware\IdentityAwareAccessorsTrait;
use SR\Reflection\Introspection\Type\ClassAware\IdentityAwareAccessorsInterface;
use SR\Reflection\Introspection\Type\ClassAware\MethodAwareAccessorsInterface;
use SR\Reflection\Introspection\Type\ClassAware\MethodAwareAccessorsTrait;
use SR\Reflection\Introspection\Type\ClassAware\ModifiersAwareAccessorsInterface;
use SR\Reflection\Introspection\Type\ClassAware\ModifiersAwareAccessorsTrait;
use SR\Reflection\Introspection\Type\ClassAware\PropertyAwareAccessorsInterface;
use SR\Reflection\Introspection\Type\ClassAware\PropertyAwareAccessorsTrait;
use SR\Utility\ClassInspect;

/**
 * Class TraitIntrospection.
 */
class TraitIntrospection extends AbstractIntrospection implements IdentityAwareAccessorsInterface, LocationAwareAccessorsInterface,
                                                                  MethodAwareAccessorsInterface, ModifiersAwareAccessorsInterface,
                                                                  PropertyAwareAccessorsInterface
{
    use IdentityAwareAccessorsTrait;
    use LocationAwareAccessorsTrait;
    use MethodAwareAccessorsTrait;
    use ModifiersAwareAccessorsTrait;
    use PropertyAwareAccessorsTrait;

    /**
     * @param string                 $name
     * @param null|object            $bindTo
     * @param null|ResolverInterface $resolver
     */
    public function __construct($name, $bindTo = null, ResolverInterface $resolver = null)
    {
        try {
            ClassInspect::assertTrait($name);
            parent::__construct(new \ReflectionClass($name), $bindTo, $resolver);
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
