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

use SR\Exception\InvalidArgumentException;
use SR\Exception\RuntimeException;

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
     * @var string
     */
    private $declaringContext;

    /**
     * @param string $declaringContext
     * @param string $constantName
     */
    public function __construct($declaringContext, $constantName)
    {
        $constant = $declaringContext.'::'.$constantName;

        if (!defined($constant)) {
            throw InvalidArgumentException::create()
                ->setMessage('Constant "%s" does not exist')
                ->with($constant);
        }

        $this->name = $constantName;
        $this->declaringContext = $declaringContext;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return constant($this->declaringContext.'::'.$this->name);
    }

    /**
     * @return string
     */
    public function getDeclaringContext()
    {
        return $this->declaringContext;
    }

    /**
     * @todo Real implementation should be written
     *
     * @throws RuntimeException
     */
    public static function export($class, $name)
    {
        $constant = $class.'::'.$name;

        if (!defined($constant)) {
            throw InvalidArgumentException::create()->setMessage('Constant "%s" does not exist')->with($constant);
        }

        $reflect = new \ReflectionClass($class);
        $valOriginal = constant($constant);
        $valFormatted = $valOriginal;

        if (is_array($valOriginal)) {
            $valFormatted = '';
            foreach ($valOriginal as $key => $value) {
                $valFormatted .= '['.$key.'] => '.($value ?: 'NULL').', ';
            }
            $valFormatted = substr($valFormatted, 0, strlen($valFormatted) - 2);
        } elseif (is_null($valOriginal)) {
            $valFormatted = 'NULL';
        }

        printf("Constant [ %s %s::%s ] {\n  %s\n}", gettype($valOriginal), $reflect->getName(), $name, $valFormatted);
    }
}

/* EOF */
