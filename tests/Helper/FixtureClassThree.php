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
 * Class FixtureClassThree.
 */
class FixtureClassThree extends FixtureClassTwo implements FixtureInterfaceThree
{
    const THREE_0 = 'three-0';
    const THREE_1 = 'three-1';
    const THREE_2 = 'three-2';

    public $propPublicThree0 = 'propPublicThree0';
    public $propPublicThree1 = 'propPublicThree1';
    public $propPublicThree2 = 'propPublicThree2';

    protected $propProtectedThree0 = 'propProtectedThree0';
    protected $propProtectedThree1 = 'propProtectedThree1';
    protected $propProtectedThree2 = 'propProtectedThree2';

    private $propPrivateThree0 = 'propPrivateThree0';
    private $propPrivateThree1 = 'propPrivateThree1';
    private $propPrivateThree2 = 'propPrivateThree2';

    public function publicThree0()
    {
        return 'prop'.ucfirst(__FUNCTION__);
    }
    public function publicThree1()
    {
        return 'prop'.ucfirst(__FUNCTION__);
    }
    public function publicThree2()
    {
        return 'prop'.ucfirst(__FUNCTION__);
    }

    protected function protectedThree0()
    {
        return 'prop'.ucfirst(__FUNCTION__);
    }
    protected function protectedThree1()
    {
        return 'prop'.ucfirst(__FUNCTION__);
    }
    protected function protectedThree2()
    {
        return 'prop'.ucfirst(__FUNCTION__);
    }

    private function privateThree0()
    {
        return 'prop'.ucfirst(__FUNCTION__);
    }
    private function privateThree1()
    {
        return 'prop'.ucfirst(__FUNCTION__);
    }
    private function privateThree2()
    {
        return 'prop'.ucfirst(__FUNCTION__);
    }
}

/* EOF */
