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

use SR\Reflection\Exception\InvalidArgumentException;
use SR\Reflection\Inspector\Aware\ScopeCore\DocBlockAwareInterface;
use SR\Reflection\Inspector\Aware\ScopeCore\DocBlockAwareTrait;
use SR\Reflection\Resolver\Resolver;
use SR\Reflection\Resolver\ResolverInterface;

abstract class AbstractInspector implements \Reflector, DocBlockAwareInterface
{
    use DocBlockAwareTrait;

    /**
     * @var null|\ReflectionClass|\ReflectionObject|\Reflector
     */
    protected $reflection;

    /**
     * @var ResolverInterface
     */
    protected $resolver;

    /**
     * @param \Reflector  $reflection
     * @param null|object $bind
     * @param Resolver    $resolver
     */
    public function __construct(\Reflector $reflection, $bind = null, Resolver $resolver = null)
    {
        $this->setReflection($reflection);
        $this->setResolver($resolver, $bind);
    }

    /**
     * @return \ReflectionMethod|\ReflectionProperty|\ReflectionClass|\ReflectionObject|\Reflector
     */
    final public function reflection()
    {
        return $this->reflection;
    }

    /**
     * @return ResolverInterface
     */
    final public function resolver()
    {
        return $this->resolver;
    }

    /**
     * @return string
     */
    abstract public function nameQualified();

    /**
     * @return string
     */
    final public function __toString()
    {
        return $this->nameQualified();
    }

    /**
     * @param null|ResolverInterface $resolver
     * @param null|object            $bind
     *
     * @return $this
     */
    protected function setResolver(ResolverInterface $resolver = null, $bind = null)
    {
        $this->resolver = $resolver ?: new Resolver();
        $this->resolver->bind($bind);

        return $this;
    }

    /**
     * @return string[]
     */
    abstract protected function getReflectionRequirements();

    /**
     * @param string $class
     * @param mixed  ...$parameters
     *
     * @return string
     */
    final protected static function exportFor($class, ...$parameters)
    {
        ob_start();

        try {
            $class::export(...$parameters);
        } catch (\ReflectionException $e) {
            $parameters = array_map(function ($p) {
                return var_export($p, true);
            }, $parameters);

            throw InvalidArgumentException::create('Could not export %s: ', implode('::', $parameters), $e->getMessage());
        } finally {
            $export = ob_get_contents();
            ob_end_clean();
        }

        return trim($export);
    }

    /**
     * @param \Reflector $reflection
     *
     * @return $this
     */
    final protected function setReflection(\Reflector $reflection)
    {
        $failedChecks = array_filter($this->getReflectionRequirements(), function ($type) use ($reflection) {
            return !$reflection instanceof $type;
        });

        if (count($failedChecks) !== 0) {
            throw InvalidArgumentException::create('Failed required instanceof checks against: %s', implode(', ', $failedChecks));
        }

        $this->reflection = $reflection;

        return $this;
    }

    /**
     * @param mixed ...$for
     *
     * @return InvalidArgumentException
     */
    final protected function getConstructorException(...$for)
    {
        $message = [];

        foreach ($for as $i => $f) {
            $message[] = sprintf(
                'parameter "%d" must be valid %s, got type "%s" containing "%s"',
                $i + 1,
                $f[0],
                gettype($f[1]),
                $f[1]
            );
        }

        return InvalidArgumentException::create('Invalid constructor parameters provided: %s', implode('; ', $message));
    }
}
