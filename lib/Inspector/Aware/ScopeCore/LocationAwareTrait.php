<?php

/*
 * This file is part of the `src-run/augustus-reflection-library` project.
 *
 * (c) Rob Frawley 2nd <rmf@src.run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace SR\Reflection\Inspector\Aware\ScopeCore;

trait LocationAwareTrait // implements LocationAwareInterface
{
    /**
     * @return \ReflectionMethod|\ReflectionClass|\ReflectionObject
     */
    abstract public function reflection();

    /**
     * @return \SplFileInfo
     */
    public function file()
    {
        return new \SplFileInfo($this->reflection()->getFileName());
    }

    /**
     * @return int
     */
    public function lineStart()
    {
        return $this->reflection()->getStartLine();
    }

    /**
     * @return int
     */
    public function lineEnd()
    {
        return $this->reflection()->getEndLine();
    }
}
