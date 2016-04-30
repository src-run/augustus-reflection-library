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

use SR\Exception\RuntimeException;
use SR\Reflection\Introspection\Type\ClassAware\ConstantAwareAccessorsTrait;
use SR\Reflection\Introspection\Type\ClassAware\ConstantAwareAccessorsInterface;
use SR\Reflection\Introspection\Resolver\ResolverInterface;
use SR\Utility\ClassInspect;

/**
 * Class ClassInstanceTypeManager.
 */
class ObjectIntrospection extends AbstractIntrospection implements ConstantAwareAccessorsInterface
{
    use ConstantAwareAccessorsTrait;

    /**
     * @var \ReflectionObject
     */
    protected $reflection;

    /**
     * @param object                 $instance
     * @param null|object            $bindScope
     * @param null|ResolverInterface $resolver
     */
    public function __construct($instance, $bindScope = null, ResolverInterface $resolver = null)
    {
        try {
            ClassInspect::assertInstance($instance);
            parent::__construct(new \ReflectionObject($instance), $bindScope, $resolver);
        } catch (\Exception $exception) {
            throw RuntimeException::create('Parameter must be an instantiated object instance');
        }
    }

    /**
     * @return string[]
     */
    protected function reflectionRequiredIsInstanceOfSet()
    {
        return array_merge(
            (array) parent::reflectionRequiredIsInstanceOfSet(),
            (array) ['\ReflectionObject']
        );
    }
}

/* EOF */
