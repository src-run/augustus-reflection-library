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
use SR\Reflection\Introspection\Resolver\ResolverInterface;
use SR\Utility\ClassInspect;

/**
 * Class TraitIntrospection.
 */
class TraitIntrospection extends AbstractIntrospection
{
    /**
     * @var \ReflectionClass
     */
    protected $reflection;

    /**
     * @param string                 $name
     * @param object|null            $bindScope
     * @param ResolverInterface|null $resolver
     */
    public function __construct($name, $bindScope = null, ResolverInterface $resolver = null)
    {
        try {
            ClassInspect::assertTrait($name);
            parent::__construct(new \ReflectionClass($name), $bindScope, $resolver);
        } catch (\Exception $exception) {
            throw RuntimeException::create('Parameter must be a string containing a valid trait name');
        }
    }

    /**
     * @return string[]
     */
    protected function reflectionRequiredIsInstanceOfSet()
    {
        return array_merge(
            (array) parent::reflectionRequiredIsInstanceOfSet(),
            (array) ['\ReflectionClass']
        );
    }
}

/* EOF */