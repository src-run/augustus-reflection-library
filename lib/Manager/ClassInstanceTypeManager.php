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

namespace SR\Reflection\Manager;

use SR\Reflection\Manager\Accessor\ConstantAccessorsTrait;
use SR\Reflection\Manager\Accessor\MethodAccessorsTrait;
use SR\Reflection\Manager\Accessor\PropertyAccessorsTrait;
use SR\Reflection\Manager\Accessor\ClassAccessorsTrait;
use SR\Reflection\Manager\Resolver\ResolverInterface;
use SR\Reflection\Utility\ClassChecker;

/**
 * Class ClassInstanceTypeManager.
 */
class ClassInstanceTypeManager extends AbstractTypeManager
{
    use ConstantAccessorsTrait;
    use ClassAccessorsTrait;
    use MethodAccessorsTrait;
    use PropertyAccessorsTrait;

    /**
     * @var \ReflectionObject
     */
    protected $reflection;

    /**
     * @param object                 $instance
     * @param object|null            $bindScope
     * @param ResolverInterface|null $resolver
     */
    public function __construct($instance, $bindScope = null, ResolverInterface $resolver = null)
    {
        try {
            ClassChecker::assertInstance($instance);
            parent::__construct(new \ReflectionObject($instance), $bindScope, $resolver);
        } catch (\Exception $exception) {
            throw new \RuntimeException('Parameter must be an instantiated object instance');
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
