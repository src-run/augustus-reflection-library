<?php

/*
 * This file is part of the `src-run/augustus-reflection-library` project.
 *
 * (c) Rob Frawley 2nd <rmf@src.run>
 * (c) Scribe Inc      <scr@src.run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace SR\Reflection\Tests\Helper;

/**
 * Class FixtureClassOne.
 */
class FixtureClassOne
{
    const ONE_0 = 'one-0';
    const ONE_1 = 'one-1';
    const ONE_2 = 'one-2';
    const NULL_CONST = null;

    /**
     * @var string
     */
    public $propPublicOne0 = 'propPublicOne0';
    public $propPublicOne1 = 'propPublicOne1';
    public $propPublicOne2 = 'propPublicOne2';

    /**
     * @var string
     */
    protected $propProtectedOne0 = 'propProtectedOne0';
    protected $propProtectedOne1 = 'propProtectedOne1';
    protected $propProtectedOne2 = 'propProtectedOne2';

    /**
     * @var string
     */
    private $propPrivateOne0 = 'propPrivateOne0';
    private $propPrivateOne1 = 'propPrivateOne1';
    private $propPrivateOne2 = 'propPrivateOne2';

    /**
     * @param string $param
     *
     * @return string
     */
    public function publicOne0($param = '')
    {
        return 'prop'.ucfirst(__FUNCTION__).$param;
    }
    public function publicOne1($param = '')
    {
        return 'prop'.ucfirst(__FUNCTION__).$param;
    }
    public function publicOne2($param = '')
    {
        return 'prop'.ucfirst(__FUNCTION__).$param;
    }

    /**
     * @param string $param
     *
     * @return string
     */
    protected function protectedOne0($param = '')
    {
        return 'prop'.ucfirst(__FUNCTION__).$param;
    }
    protected function protectedOne1($param = '')
    {
        return 'prop'.ucfirst(__FUNCTION__).$param;
    }
    protected function protectedOne2($param = '')
    {
        return 'prop'.ucfirst(__FUNCTION__).$param;
    }
    
    /**
     * @param string $param
     *
     * @return string
     */
    private function privateOne0($param = '')
    {
        return 'prop'.ucfirst(__FUNCTION__).$param;
    }
    private function privateOne1($param = '')
    {
        return 'prop'.ucfirst(__FUNCTION__).$param;
    }
    private function privateOne2($param = '')
    {
        return 'prop'.ucfirst(__FUNCTION__).$param;
    }
}

/* EOF */
