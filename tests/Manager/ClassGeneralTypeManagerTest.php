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

namespace SR\Reflection\Tests\Manager;

use SR\Reflection\Definition\ReflectionConstant;
use SR\Reflection\Manager\ClassGeneralTypeManager;
use SR\Reflection\Manager\TypeManagerInterface;
use SR\Reflection\Tests\Helper\AbstractTestHelper;

/**
 * Class ClassGeneralTypeManagerTest.
 */
class ClassGeneralTypeManagerTest extends AbstractTestHelper
{
    /**
     * @var string
     */
    const TEST_CLASS = '\Manager\ClassGeneralTypeManager';

    /**
     * @var ClassGeneralTypeManager
     */
    protected static $instance = null;

    private function checkMethods(array $methods)
    {
        array_walk($methods, function (\ReflectionMethod $method) {
            $expectedVisibilityMethod = 'is'.ucfirst($this->getMethodExpectedVisibility($method));
            $this->assertTrue($method->{$expectedVisibilityMethod}());
        });
    }

    public function getMethodsAndCheckCount(TypeManagerInterface $m, $filter = '', $countAssert = null, $levels = null)
    {
        $call = ucfirst($filter).'Methods';
        $methods = $m->{$call}($levels);

        if ($countAssert !== null) {
            $this->assertTrue(count($methods) === $countAssert);
        }

        return $methods;
    }

    private function getMethodExpectedVisibility(\ReflectionMethod $method)
    {
        if (1 !== preg_match('{public|protected|private}', $method->getName(), $match) || count($match) !== 1) {
            $this->fail('Could not determine expected visibility.');
        }

        return array_pop($match);
    }

    public function testInvalidConstructorArguments()
    {
        $this->expectException('\RuntimeException');
        $this->getFixtureInstances('/AN/INVALID/NAME/SPACE/I/REALLY/HOPE');
    }
    
    public function testStaticFactoryConstruction()
    {
        $_r = $this->getClassNameAbsolute();

        foreach ($this->getFixtureClassNamesAbsolute() as $_n) {
            $_nn = new $_r($_n);
            $_a = call_user_func([$_nn, 'reflection']);
            static::assertSame($_n, call_user_func([$_a, 'getName']));
        }

        $this->expectException('\RuntimeException');
        $this->getFixtureInstances('/AN/INVALID/NAME/SPACE/I/REALLY/HOPE');
    }
    
    public function testConstruction()
    {
        list($_1n, $_2n, $_3n) = $this->getFixtureClassNamesAbsolute();

        foreach ($this->getFixtureInstances() as $i => $_) {
            $_z = '_'.($i+1).'n';
            $_a = $_->reflection();

            $this->assertTrue($$_z === $_a->getName());
            $methods = $this->getMethodsAndCheckCount($_, '', 9 * ($i+1));
            $this->checkMethods($methods);
        }
    }

    public function testMethodFilterPublic()
    {
        list($_1n, $_2n, $_3n) = $this->getFixtureClassNamesAbsolute();

        foreach ($this->getFixtureInstances() as $i => $_) {
            $_z = '_'.($i+1).'n';
            $_a = $_->reflection();

            $this->assertTrue($$_z === $_a->getName());
            $methods = $this->getMethodsAndCheckCount($_, 'Public', 3 * ($i+1));
            $this->checkMethods($methods);
        }
    }

    public function testMethodFilterProtected()
    {
        list($_1n, $_2n, $_3n) = $this->getFixtureClassNamesAbsolute();

        foreach ($this->getFixtureInstances() as $i => $_) {
            $_z = '_'.($i+1).'n';
            $_a = $_->reflection();

            $this->assertTrue($$_z === $_a->getName());
            $methods = $this->getMethodsAndCheckCount($_, 'Protected', 3 * ($i+1));
            $this->checkMethods($methods);
        }
    }

    public function testMethodFilterPrivate()
    {
        list($_1n, $_2n, $_3n) = $this->getFixtureClassNamesAbsolute();

        foreach ($this->getFixtureInstances() as $i => $_) {
            $_z = '_'.($i+1).'n';
            $_a = $_->reflection();

            $this->assertTrue($$_z === $_a->getName());
            $methods = $this->getMethodsAndCheckCount($_, 'Private', 3 * ($i+1));
            $this->checkMethods($methods);
        }
    }

    public function testMethodFilterVarious()
    {
        list($_1n, $_2n, $_3n) = $this->getFixtureClassNamesAbsolute();

        foreach ($this->getFixtureInstances() as $i => $_) {
            $_z = '_'.($i+1).'n';
            $_a = $_->reflection();

            $this->assertTrue($$_z === $_a->getName());
            $methods = $this->getMethodsAndCheckCount($_, '', 6 * ($i+1), \ReflectionMethod::IS_PUBLIC|\ReflectionMethod::IS_PRIVATE);
            $this->checkMethods($methods);
        }
    }

    public function testMethodsFilterPredicate()
    {
        $_n = $this->getFixtureClassNamesAbsolute();

        foreach ($this->getFixtureInstances() as $i => $_) {
            $_r = $_->reflection();

            $this->assertTrue($_n[$i] === $_r->getName());

            $methods = $this->getMethodsAndCheckCount($_, '', 9 * ($i+1));
            $this->checkMethods($methods);

            $filtered = $_->filterMethods(function (\ReflectionMethod $m) {
                return substr($m->getName(), -1, 1) === '2';
            });
        }
    }

    public function testConstants()
    {
        $constIntToString = ['ONE', 'TWO', 'THREE'];

        foreach ($this->getFixtureInstances() as $i => $m) {
            $this->assertFalse($m->hasConstant('BAD_CONST_NAME'));
            $constantDefinitions = $constantStrings = [];

            $constStrings = $constIntToString;
            array_walk($constStrings, function(&$name, $j) use ($constIntToString, $i) {
                $name = $constIntToString[$i] . '_' . $j;
            });

            foreach ($constStrings as $cs) {
                $this->assertTrue($m->hasConstant($cs));
                $c = $m->getConstant($cs);
                $this->assertTrue($c instanceof ReflectionConstant);

                $constantDefinitions[] = $c;
                $constantStrings[] = $c->__toString();
            }

            $this->assertArraySubset($constantStrings, $m->constants());
            $this->assertTrue($m->getConstant('NULL_CONST')->isNull());
        }
    }

    public function testInvalidConstant()
    {
        $is = $this->getFixtureInstances();

        $this->expectException('\InvalidArgumentException');
        $is[0]->getConstant('NOT_VALID');
    }

    public function testConstantVisitor()
    {
        foreach ($this->getFixtureInstances() as $i => $m) {
            $expectedConstants = $constants = $m->constants();

            array_walk($expectedConstants, function(ReflectionConstant &$c) {
                $c = $c->getName().$c->getValue();
            });

            $visitedConstants = $m->visitConstants(function(ReflectionConstant $c) {
                return $c->getName().$c->getValue();
            });

            $this->assertSame($expectedConstants, $visitedConstants);
        }
    }

    public function testConstantFilter()
    {
        foreach ($this->getFixtureInstances() as $i => $m) {
            $result = $m->filterOneConstant(function(ReflectionConstant $c) {
                return $c->getName() === 'ONE_0';
            });

            $this->assertTrue($result instanceof ReflectionConstant);
        }
    }

    public function testConstantMatchOne()
    {
        foreach ($this->getFixtureInstances() as $i => $m) {
            $result = $m->matchOneConstant('ONE_0');
            $this->assertTrue($result instanceof ReflectionConstant);
        }
    }

    public function testConstantNotMatchOne()
    {
        foreach ($this->getFixtureInstances() as $i => $m) {
            $result = $m->matchOneConstant('ABCDEF');
            $this->assertNull($result);
            $result = $m->matchOneConstant('ONE_');
            $this->assertNull($result);
        }
    }

    public function testConstantMatches()
    {
        foreach ($this->getFixtureInstances() as $i => $m) {
            $results = $m->matchConstants('_');
            $this->assertTrue(is_array($results));
            $this->assertGreaterThan(3, $results);
            array_walk($results, function($r) {
                $this->assertTrue($r instanceof ReflectionConstant);
            });
        }
    }

    public function testConstantsFilter()
    {
        foreach ($this->getFixtureInstances() as $i => $m) {
            $results = $m->filterConstants(function(ReflectionConstant $c) {
                return false !== strpos($c->getName(), 'ONE');
            });
            $this->assertTrue(is_array($results));
            $this->assertCount(3, $results);
            array_walk($results, function($r) {
                $this->assertTrue($r instanceof ReflectionConstant);
            });
        }
    }

    public function testSortConstants()
    {
        foreach ($this->getFixtureInstances() as $i => $m) {
            $results = $m->sortConstants(function(ReflectionConstant $a, ReflectionConstant $b) {
                return substr($a->getName(), -1, 1) > substr($b->getName(), -1, 1);
            });

            $this->assertGreaterThan(3, $results);
            $this->assertStringEndsWith('0', $results[0]->getName());
            $this->assertStringEndsWith('2', $results[count($results)-2]->getName());
        }
    }

    public function testConstantExport()
    {
        $this->expectException('\RuntimeException');
        
        foreach ($this->getFixtureInstances() as $i => $m) {
            $results = $m->constants();
            foreach ($results as $c) {
                $c->export();
            }
        }
    }

    public function testExtendsAndImplements()
    {
        $n = $this->getFixtureClassNamesAbsolute();
        $f = $this->getFixtureInstances();

        $this->assertFalse($f[0]->extendsClass('\SR\Reflection\Tests\Helper\FixtureClassOne'));
        $this->assertTrue($f[1]->extendsClass('\SR\Reflection\Tests\Helper\FixtureClassOne'));
        $this->assertTrue($f[2]->extendsClass('\SR\Reflection\Tests\Helper\FixtureClassOne'));
        $this->assertFalse($f[0]->extendsClass('\SR\Reflection\Tests\Helper\FixtureClassTwo'));
        $this->assertFalse($f[1]->extendsClass('\SR\Reflection\Tests\Helper\FixtureClassTwo'));
        $this->assertTrue($f[2]->extendsClass('\SR\Reflection\Tests\Helper\FixtureClassTwo'));
        $this->assertFalse($f[0]->extendsClass('\SR\Reflection\Tests\Helper\FixtureClassThree'));
        $this->assertFalse($f[1]->extendsClass('\SR\Reflection\Tests\Helper\FixtureClassThree'));
        $this->assertFalse($f[2]->extendsClass('\SR\Reflection\Tests\Helper\FixtureClassThree'));

        $this->assertFalse($f[0]->usesTrait('SR\Reflection\Tests\Helper\FixtureTrait'));
        $this->assertFalse($f[0]->usesTrait('\SR\Reflection\Tests\Helper\FixtureTrait'));
        $this->assertTrue($f[1]->usesTrait('SR\Reflection\Tests\Helper\FixtureTrait'));
        $this->assertTrue($f[1]->usesTrait('\SR\Reflection\Tests\Helper\FixtureTrait'));
        $this->assertFalse($f[2]->usesTrait('SR\Reflection\Tests\Helper\FixtureTrait'));
        $this->assertFalse($f[2]->usesTrait('\SR\Reflection\Tests\Helper\FixtureTrait'));

        $this->assertFalse($f[0]->implementsInterface('SR\Reflection\Tests\Helper\FixtureInterface'));
        $this->assertFalse($f[0]->implementsInterface('\SR\Reflection\Tests\Helper\FixtureInterface'));
        $this->assertTrue($f[1]->implementsInterface('SR\Reflection\Tests\Helper\FixtureInterface'));
        $this->assertTrue($f[1]->implementsInterface('\SR\Reflection\Tests\Helper\FixtureInterface'));
        $this->assertTrue($f[2]->implementsInterface('SR\Reflection\Tests\Helper\FixtureInterface'));
        $this->assertTrue($f[2]->implementsInterface('\SR\Reflection\Tests\Helper\FixtureInterface'));
    }

    public function testMethodAccessors()
    {
        foreach ($this->getFixtureInstances() as $i => $m) {
            $result = $m->filterMethods(function(\ReflectionMethod $m) {
                return false !== strpos($m->getName(), 'publicOne');
            });
            $this->assertCount(3, $result);
            $result = $m->filterMethods(function(\ReflectionMethod $m) {
                return $m->getName() === 'abcdef';
            });
            $this->assertCount(0, $result);

            $result = $m->filterOneMethod(function(\ReflectionMethod $m) {
                return $m->getName() === 'publicOne0';
            });
            $this->assertTrue($result instanceof \ReflectionMethod);
            $result = $m->filterOneMethod(function(\ReflectionMethod $m) {
                return $m->getName() === 'abcdef';
            });
            $this->assertNull($result);

            $result = $m->matchMethods('publicOne0');
            $this->assertCount(1, $result);
            $this->assertTrue($result[0] instanceof \ReflectionMethod);
            $result = $m->matchMethods('abcdef');
            $this->assertCount(0, $result);

            $result = $m->matchOneMethod('publicOne0');
            $this->assertTrue($result instanceof \ReflectionMethod);
            $result = $m->matchOneMethod('abcdef');
            $this->assertNull($result);

            $this->assertTrue($m->hasMethod('publicOne0'));
            $this->assertFalse($m->hasMethod('abcdef'));

            $result = $m->getMethod('publicOne0');
            $this->assertTrue($result instanceof \ReflectionMethod);

            $this->assertGreaterThan(2, $m->publicMethods());
            $this->assertGreaterThan(2, $m->protectedMethods());
            $this->assertGreaterThan(2, $m->privateMethods());

            $result = $m->sortMethods(function (\ReflectionMethod $a, \ReflectionMethod $b) {
                return substr($a->getName(), -1, 1) > substr($b->getName(), -1, 1);
            });

            $this->assertGreaterThan(3, $result);

            $result = $m->visitMethods(function (\ReflectionMethod $p) {
                return $p->getName().'VISITOR';
            });

            array_walk($result, function ($p) {
                $this->assertStringEndsWith('VISITOR', $p);
            });
        }

        $this->expectException('\InvalidArgumentException');
        $this->getFixtureInstances()[0]->getMethod('abcdef');
    }

    public function testPropertyAccessors()
    {
        foreach ($this->getFixtureInstances() as $i => $m) {
            $result = $m->filterProperties(function(\ReflectionProperty $m) {
                return false !== strpos($m->getName(), 'propPublicOne');
            });
            $this->assertCount(3, $result);
            $result = $m->filterProperties(function(\ReflectionProperty $m) {
                return $m->getName() === 'abcdef';
            });
            $this->assertCount(0, $result);

            $result = $m->filterOneProperty(function(\ReflectionProperty $m) {
                return $m->getName() === 'propPublicOne0';
            });
            $this->assertTrue($result instanceof \ReflectionProperty);
            $result = $m->filterOneProperty(function(\ReflectionProperty $m) {
                return $m->getName() === 'abcdef';
            });
            $this->assertNull($result);

            $result = $m->matchProperties('propPublicOne0');
            $this->assertCount(1, $result);
            $this->assertTrue($result[0] instanceof \ReflectionProperty);
            $result = $m->matchProperties('abcdef');
            $this->assertCount(0, $result);

            $result = $m->matchOneProperty('propPublicOne0');
            $this->assertTrue($result instanceof \ReflectionProperty);
            $result = $m->matchOneProperty('abcdef');
            $this->assertNull($result);

            $this->assertTrue($m->hasProperty('propPublicOne0'));
            $this->assertFalse($m->hasProperty('abcdef'));

            $result = $m->getProperty('propPublicOne0');
            $this->assertTrue($result instanceof \ReflectionProperty);

            $this->assertGreaterThan(2, $m->publicProperties());
            $this->assertGreaterThan(2, $m->protectedProperties());
            $this->assertGreaterThan(2, $m->privateProperties());

            $result = $m->sortProperties(function (\ReflectionProperty $a, \ReflectionProperty $b) {
                return substr($a->getName(), -1, 1) > substr($b->getName(), -1, 1);
            });

            $this->assertGreaterThan(3, $result);

            $result = $m->visitProperties(function (\ReflectionProperty $p) {
                return $p->getName().'VISITOR';
            });

            array_walk($result, function ($p) {
                $this->assertStringEndsWith('VISITOR', $p);
            });
        }

        $this->expectException('\InvalidArgumentException');
        $this->getFixtureInstances()[0]->getProperty('abcdef');
    }
}

/* EOF */
