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

namespace SR\Reflection\Definition;

/**
 * Class ReflectionConstant.
 */
class ReflectionConstant implements \Reflector
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var null|mixed
     */
    private $value;

    /**
     * @param string     $name
     * @param null|mixed $value
     */
    public function __construct($name, $value = null)
    {
        $this->name = (string) $name;
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed|null
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return bool
     */
    public function isNull()
    {
        return $this->value === null;
    }

    /**
     * @todo Real implementation should be written
     *
     * @throws \RuntimeException
     */
    public static function export()
    {
        throw new \RuntimeException(
            sprintf('TODO: Implement %s functionality.', get_class()));
    }
}

/* EOF */
