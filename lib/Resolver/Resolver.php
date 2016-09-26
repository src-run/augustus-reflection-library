<?php

/*
 * This file is part of the `src-run/augustus-reflection-library` project.
 *
 * (c) Rob Frawley 2nd <rmf@src.run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace SR\Reflection\Resolver;

class Resolver implements ResolverInterface
{
    /**
     * @var null|object
     */
    protected $scope = null;

    /**
     * @param \Reflector[] $items
     * @param \Closure     $sort
     * @param mixed        ...$extra
     *
     * @return \Reflector[]
     */
    public function sort(array $items, \Closure $sort, &...$extra)
    {
        $_ = function (\Reflector $first, \Reflector $second) use ($sort, $extra) {
            return (int) $this->bindScopeAndInvoke($sort, $first, $second, ...$extra);
        };

        usort($items, $_);

        return $this->normalizeResultSet($items);
    }

    /**
     * @param \Reflector[] $items
     * @param \Closure     $visit
     * @param mixed        ...$extra
     *
     * @return mixed[]
     */
    public function visit(array $items, \Closure $visit, &...$extra)
    {
        $_ = function (\Reflector &$r, $i) use ($visit, $extra) {
            $r = $this->bindScopeAndInvoke($visit, $r, $i, ...$extra);
        };

        array_walk($items, $_);

        return $this->normalizeResultSet($items, false);
    }

    /**
     * @param \Reflector[] $items
     * @param \Closure     $predicate
     * @param mixed        ...$extra
     *
     * @return \Reflector[]
     */
    public function filter(array $items, \Closure $predicate, &...$extra)
    {
        $_ = function (\Reflector $r, $i) use ($predicate, $extra) {
            return (bool) $this->bindScopeAndInvoke($predicate, $r, $i, ...$extra);
        };

        $items = array_filter($items, $_, ARRAY_FILTER_USE_BOTH);

        return $this->normalizeResultSet($items);
    }

    /**
     * @param \Reflector[] $items
     * @param \Closure     $predicate
     * @param mixed        ...$extra
     *
     * @return \Reflector
     */
    public function filterOne(array $items, \Closure $predicate, &...$extra)
    {
        $items = $this->filter($items, $predicate, ...$extra);

        return $this->normalizeResultSingle($items);
    }

    /**
     * @param \Reflector[] $items
     * @param mixed        $match
     * @param string       $method
     *
     * @return \Reflector[]
     */
    public function match(array $items, $match, $method = '__toString')
    {
        $_ = function (\Reflector $r) use ($match, $method) {
            return is_callable([$r, $method]) ?
                false !== strpos(call_user_func([$r, $method]), $match) : false;
        };

        $items = $this->filter($items, $_);

        return $this->normalizeResultSet($items);
    }

    /**
     * @param \Reflector[] $items
     * @param mixed        $match
     * @param string       $method
     *
     * @return \Reflector[]
     */
    public function matchOne(array $items, $match, $method = '__toString')
    {
        $items = $this->match($items, $match, $method);

        return $this->normalizeResultSingle($items);
    }

    /**
     * @param mixed $scope
     *
     * @return string
     */
    public function validateBind($scope)
    {
        return (bool) is_object($scope);
    }

    /**
     * @param null|object $scope
     *
     * @return $this
     */
    public function bind($scope = null)
    {
        if ($this->validateBind($scope)) {
            $this->scope = $scope;
        }

        return $this;
    }

    /**
     * @param \Closure $invokable
     * @param mixed    $parameters
     *
     * @return mixed
     */
    public function bindScopeAndInvoke(\Closure $invokable, &...$parameters)
    {
        if ($this->validateBind($this->scope)) {
            $invokable = $invokable->bindTo($this->scope, $this->scope);
        }

        return $invokable(...$parameters);
    }

    /**
     * @param \Reflector[]|mixed[] $items
     * @param bool                 $normalize
     *
     * @return \Reflector[]|mixed[]
     */
    protected function normalizeResultSet($items, $normalize = true)
    {
        if ($normalize === true) {
            $items = array_filter($items, function ($item) {
                return $item instanceof \Reflector;
            });
        }

        return (array) array_values((array) $items);
    }

    /**
     * @param \Reflector[]|mixed[] $items
     * @param true|bool            $normalize
     *
     * @return \Reflector|mixed|null
     */
    protected function normalizeResultSingle($items, $normalize = true)
    {
        if (count($items = $this->normalizeResultSet($items, $normalize)) === 1) {
            return array_shift($items);
        }

        return null;
    }
}
