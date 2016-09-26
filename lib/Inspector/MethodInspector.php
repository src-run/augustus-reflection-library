<?php

/*
 * This file is part of the `src-run/augustus-reflection-library` project.
 *
 * (c) Rob Frawley 2nd <rmf@src.run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace SR\Reflection\Inspector;

use SR\Reflection\Inspector\Aware\ScopeCore\LocationAwareInterface;
use SR\Reflection\Inspector\Aware\ScopeCore\LocationAwareTrait;
use SR\Reflection\Inspector\Aware\ScopeCore\VisibilityAwareInterface;
use SR\Reflection\Inspector\Aware\ScopeCore\VisibilityAwareTrait;
use SR\Reflection\Inspector\Aware\ScopeMethod\CallableAwareInterface;
use SR\Reflection\Inspector\Aware\ScopeMethod\CallableAwareTrait;
use SR\Reflection\Inspector\Aware\ScopeMethod\IdentityAwareInterface;
use SR\Reflection\Inspector\Aware\ScopeMethod\IdentityAwareTrait;
use SR\Reflection\Inspector\Aware\ScopeMethod\ModifiersAwareInterface;
use SR\Reflection\Inspector\Aware\ScopeMethod\ModifiersAwareTrait;
use SR\Reflection\Resolver\ResolverInterface;
use SR\Util\Info\ClassInfo;

class MethodInspector extends AbstractInspector implements CallableAwareInterface, IdentityAwareInterface, LocationAwareInterface, ModifiersAwareInterface, VisibilityAwareInterface
{
    use CallableAwareTrait;
    use IdentityAwareTrait;
    use LocationAwareTrait;
    use ModifiersAwareTrait;
    use VisibilityAwareTrait;

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

            if (ClassInfo::isTrait($class)) {
                $this->declaringClass = new TraitInspector($class);
            }

            if (!ClassInfo::isTrait($class) && ClassInfo::isClass($class)) {
                $this->declaringClass = new ClassInspector($class);
            }
        } catch (\Exception $exception) {
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
