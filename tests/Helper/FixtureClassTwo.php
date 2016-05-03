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
 * Class FixtureClassTwo.
 */
class FixtureClassTwo extends FixtureClassOne implements FixtureInterfaceTwo
{
    use FixtureTrait;

    const TWO_0 = 'two-0';
    const TWO_1 = 'two-1';
    const TWO_2 = 'two-2';

    public $propPublicTwo0 = 'propPublicTwo0';
    public $propPublicTwo1 = 'propPublicTwo1';
    public $propPublicTwo2 = 'propPublicTwo2';

    protected $propProtectedTwo0 = 'propProtectedTwo0';
    protected $propProtectedTwo1 = 'propProtectedTwo1';
    protected $propProtectedTwo2 = 'propProtectedTwo2';

    private $propPrivateTwo0 = 'propPrivateTwo0';
    private $propPrivateTwo1 = 'propPrivateTwo1';
    private $propPrivateTwo2 = 'propPrivateTwo2';

    public function publicTwo0()
    {
        return 'prop'.ucfirst(__FUNCTION__);
    }
    public function publicTwo1()
    {
        return 'prop'.ucfirst(__FUNCTION__);
    }
    public function publicTwo2()
    {
        return 'prop'.ucfirst(__FUNCTION__);
    }

    protected function protectedTwo0()
    {
        return 'prop'.ucfirst(__FUNCTION__);
    }
    protected function protectedTwo1()
    {
        return 'prop'.ucfirst(__FUNCTION__);
    }
    protected function protectedTwo2()
    {
        return 'prop'.ucfirst(__FUNCTION__);
    }

    private function privateTwo0()
    {
        return 'prop'.ucfirst(__FUNCTION__);
    }
    private function privateTwo1()
    {
        return 'prop'.ucfirst(__FUNCTION__);
    }
    private function privateTwo2()
    {
        return 'prop'.ucfirst(__FUNCTION__);
    }
}

/* EOF */
