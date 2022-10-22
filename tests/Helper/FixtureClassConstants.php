<?php

/*
 * This file is part of the `src-run/augustus-reflection-library` project.
 *
 * (c) Rob Frawley 2nd <rmf@src.run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace SR\Reflection\Tests\Helper;

/**
 * Class FixtureClassConstants.
 */
class FixtureClassConstants
{
    /**
     * @var string
     */
    public const CONSTANT_STRING = 'string';

    /**
     * @var int
     */
    public const CONSTANT_INT = 1;

    /**
     * @var null
     */
    public const CONSTANT_NULL = null;

    /**
     * @var array
     */
    public const CONSTANT_ARRAY = [
        self::CONSTANT_STRING,
        self::CONSTANT_INT,
        self::CONSTANT_NULL,
        'string' => self::CONSTANT_STRING,
        'integer' => self::CONSTANT_INT,
        'null' => self::CONSTANT_NULL,
    ];
}

/* EOF */
