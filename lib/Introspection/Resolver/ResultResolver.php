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

namespace SR\Reflection\Introspection\Resolver;

/**
 * Class ResultResolver.
 */
class ResultResolver implements ResolverInterface
{
    /**
     * @var null|object
     */
    protected $scope = null;

    /**
     * @param \Reflector[] $items
     * @param \Closure     $sort
     * @param mixed,...    $extra
     *
     * @return \Reflector[]
     */
    public function sort(array $items, \Closure $sort, &...$extra)
    {
        $_ = function (\Reflector $first, \Reflector $second) use ($sort, $extra){
            return (int) $this->doBindScopeAndInvoke($sort, $first, $second, ...$extra);
        };

        usort($items, $_);

        return $this->doResultReturnSet($items);
    }

    /**
     * @param \Reflector[] $items
     * @param \Closure     $visit
     * @param mixed,...    $extra
     *
     * @return mixed[]
     */
    public function visit(array $items, \Closure $visit, &...$extra)
    {
        $_ = function (\Reflector &$r, $i) use ($visit, $extra) {
            $r = $this->doBindScopeAndInvoke($visit, $r, $i, ...$extra);
        };

        array_walk($items, $_);

        return $this->doResultReturnSet($items, false);
    }

    /**
     * @param \Reflector[] $items
     * @param \Closure     $predicate
     * @param mixed,...    $extra
     *
     * @return \Reflector[]
     */
    public function filter(array $items, \Closure $predicate, &...$extra)
    {
        $_ = function (\Reflector $r, $i) use ($predicate, $extra) {
            return (bool) $this->doBindScopeAndInvoke($predicate, $r, $i, ...$extra);
        };

        $items = array_filter($items, $_, ARRAY_FILTER_USE_BOTH);

        return $this->doResultReturnSet($items);
    }

    /**
     * @param \Reflector[] $items
     * @param \Closure     $predicate
     * @param mixed,...    $extra
     *
     * @return \Reflector
     */
    public function filterOne(array $items, \Closure $predicate, &...$extra)
    {
        $items = $this->filter($items, $predicate, ...$extra);

        return $this->doResultReturnOne($items);
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

        return $this->doResultReturnSet($items);
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

        return $this->doResultReturnOne($items);
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
     * @param object|null $scope
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
    public function doBindScopeAndInvoke(\Closure $invokable, &...$parameters)
    {
        if ($this->validateBind($this->scope)) {
            $invokable = $invokable->bindTo($this->scope, $this->scope);
        }

        return $invokable(...$parameters);
    }

    /**
     * @param \Reflector[]|mixed[] $items
     *
     * @return \Reflector[]
     */
    protected function doResultSetNormalization($items)
    {
        return (array) array_filter((array) $items, function ($v) {
            return $v instanceof \Reflector;
        });
    }

    /**
     * @param \Reflector[]|mixed[] $items
     * @param bool                 $normalize
     *
     * @return \Reflector[]|mixed[]
     */
    protected function doResultReturnSet($items, $normalize = true)
    {
        if ($normalize === true) {
            $items = $this->doResultSetNormalization($items);
        }

        return (array) array_values((array) $items);
    }

    /**
     * @param \Reflector[]|mixed[] $items
     * @param true|bool            $normalize
     *
     * @return \Reflector|mixed|null
     */
    protected function doResultReturnOne($items, $normalize = true)
    {
        if (count($items = $this->doResultReturnSet($items, $normalize)) !== 1) {
            return null;
        }

        return array_shift($items);
    }
}

/* EOF */
