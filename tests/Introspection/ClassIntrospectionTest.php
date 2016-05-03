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

namespace SR\Reflection\Tests\Introspection;

use SR\Reflection\Definition\ReflectionConstant;
use SR\Reflection\Introspection\AbstractIntrospection;
use SR\Reflection\Introspection\ClassIntrospection;
use SR\Reflection\Introspection\ConstantIntrospection;
use SR\Reflection\Introspection\InterfaceIntrospection;
use SR\Reflection\Introspection\MethodIntrospection;
use SR\Reflection\Introspection\PropertyIntrospection;
use SR\Reflection\Tests\Helper\AbstractTestHelper;

/**
 * Class ClassIntrospectionTest.
 */
class ClassIntrospectionTest extends AbstractTestHelper
{
    /**
     * @var string
     */
    const TEST_CLASS = '\Introspection\ClassIntrospection';

    /**
     * @var ClassIntrospection
     */
    protected static $instance = null;

    private function checkMethods(array $methods)
    {
        array_walk($methods, function (MethodIntrospection $method) {
            $expectedVisibilityMethod = 'is'.ucfirst($this->getMethodExpectedVisibility($method));
            $this->assertTrue($method->reflection()->{$expectedVisibilityMethod}());
        });
    }

    public function getMethodsAndCheckCount(AbstractIntrospection $m, $filter = '', $countAssert = null, $levels = null)
    {
        $call = ucfirst($filter).'Methods';
        $methods = $m->{$call}($levels);

        if ($countAssert !== null) {
            $this->assertTrue(count($methods) === $countAssert);
        }

        return $methods;
    }

    private function getMethodExpectedVisibility(MethodIntrospection $method)
    {
        if (1 !== preg_match('{public|protected|private}', $method->name(), $match) || count($match) !== 1) {
            $this->fail('Could not determine expected visibility.');
        }

        return array_pop($match);
    }

    public function testInvalidConstructorArguments()
    {
        $this->expectException('SR\Exception\InvalidArgumentException');
        $this->getFixtureInstances('/AN/INVALID/NAME/SPACE/I/REALLY/HOPE');
    }

    public function testStaticFactoryConstruction()
    {
        $_r = $this->getClassnameQualified();

        foreach ($this->getFixtureClassNamesAbsolute() as $_n) {
            $_nn = new $_r($_n);
            $_a = call_user_func([$_nn, 'reflection']);
            static::assertSame($_n, call_user_func([$_a, 'getName']));
        }

        $this->expectException('SR\Exception\InvalidArgumentException');
        $this->getFixtureInstances('/AN/INVALID/NAME/SPACE/I/REALLY/HOPE');
    }

    public function testConstruction()
    {
        list($_1n, $_2n, $_3n) = $this->getFixtureClassNamesAbsolute();

        foreach ($this->getFixtureInstances() as $i => $_) {
            $_z = '_'.($i + 1).'n';
            $_a = $_->reflection();

            $this->assertTrue($$_z === $_a->getName());
            $methods = $this->getMethodsAndCheckCount($_, '', 9 * ($i + 1));
            $this->checkMethods($methods);
        }
    }

    public function testExport()
    {
        foreach ($this->getFixtureInstances() as $i => $_) {
            $export = $_::export($_->nameQualified());
            $this->assertRegExp('{- Constants \[[0-9]+\] \{}', $export);
        }
    }

    public function testMethodFilterPublic()
    {
        list($_1n, $_2n, $_3n) = $this->getFixtureClassNamesAbsolute();

        foreach ($this->getFixtureInstances() as $i => $_) {
            $_z = '_'.($i + 1).'n';
            $_a = $_->reflection();

            $this->assertTrue($$_z === $_a->getName());
            $methods = $this->getMethodsAndCheckCount($_, 'Public', 3 * ($i + 1));
            $this->checkMethods($methods);
        }
    }

    public function testMethodFilterProtected()
    {
        list($_1n, $_2n, $_3n) = $this->getFixtureClassNamesAbsolute();

        foreach ($this->getFixtureInstances() as $i => $_) {
            $_z = '_'.($i + 1).'n';
            $_a = $_->reflection();

            $this->assertTrue($$_z === $_a->getName());
            $methods = $this->getMethodsAndCheckCount($_, 'Protected', 3 * ($i + 1));
            $this->checkMethods($methods);
        }
    }

    public function testMethodFilterPrivate()
    {
        list($_1n, $_2n, $_3n) = $this->getFixtureClassNamesAbsolute();

        foreach ($this->getFixtureInstances() as $i => $_) {
            $_z = '_'.($i + 1).'n';
            $_a = $_->reflection();

            $this->assertTrue($$_z === $_a->getName());
            $methods = $this->getMethodsAndCheckCount($_, 'Private', 3 * ($i + 1));
            $this->checkMethods($methods);
        }
    }

    public function testMethodFilterVarious()
    {
        list($_1n, $_2n, $_3n) = $this->getFixtureClassNamesAbsolute();

        foreach ($this->getFixtureInstances() as $i => $_) {
            $_z = '_'.($i + 1).'n';
            $_a = $_->reflection();

            $this->assertTrue($$_z === $_a->getName());
            $methods = $this->getMethodsAndCheckCount($_, '', 6 * ($i + 1), \ReflectionMethod::IS_PUBLIC | \ReflectionMethod::IS_PRIVATE);
            $this->checkMethods($methods);
        }
    }

    public function testMethodsFilterPredicate()
    {
        $_n = $this->getFixtureClassNamesAbsolute();

        foreach ($this->getFixtureInstances() as $i => $_) {
            $_r = $_->reflection();

            $this->assertTrue($_n[$i] === $_r->getName());

            $methods = $this->getMethodsAndCheckCount($_, '', 9 * ($i + 1));
            $this->checkMethods($methods);

            $filtered = $_->filterMethods(function (MethodIntrospection $m) {
                return substr($m->name(), -1, 1) === '2';
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
            array_walk($constStrings, function (&$name, $j) use ($constIntToString, $i) {
                $name = $constIntToString[$i].'_'.$j;
            });

            foreach ($constStrings as $cs) {
                $this->assertTrue($m->hasConstant($cs));
                $c = $m->getConstant($cs);
                $this->assertTrue($c instanceof ConstantIntrospection);

                $constantDefinitions[] = $c;
                $constantStrings[] = $c->__toString();
            }

            $this->assertArraySubset($constantStrings, $m->constants());
            $this->assertTrue($m->getConstant('NULL_CONST')->isNull($m));
        }
    }

    public function testInvalidConstant()
    {
        $is = $this->getFixtureInstances();

        $this->expectException('SR\Exception\InvalidArgumentException');
        $is[0]->getConstant('NOT_VALID');
    }

    public function testConstantVisitor()
    {
        foreach ($this->getFixtureInstances() as $i => $m) {
            $expectedConstants = $constants = $m->constants();

            array_walk($expectedConstants, function (ConstantIntrospection &$c) {
                $c = $c->name().$c->value();
            });

            $visitedConstants = $m->visitConstants(function (ConstantIntrospection $c) {
                return $c->name().$c->value();
            });

            $this->assertSame($expectedConstants, $visitedConstants);
        }
    }

    public function testConstantFilter()
    {
        foreach ($this->getFixtureInstances() as $i => $m) {
            $result = $m->filterOneConstant(function (ConstantIntrospection $c) {
                return $c->name() === 'ONE_0';
            });

            $this->assertTrue($result instanceof ConstantIntrospection);
        }
    }

    public function testConstantMatchOne()
    {
        foreach ($this->getFixtureInstances() as $i => $m) {
            $result = $m->matchOneConstant('ONE_0');
            $this->assertTrue($result instanceof ConstantIntrospection);
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
            array_walk($results, function ($r) {
                $this->assertTrue($r instanceof ConstantIntrospection);
            });
        }
    }

    public function testConstantsFilter()
    {
        foreach ($this->getFixtureInstances() as $i => $m) {
            $results = $m->filterConstants(function (ConstantIntrospection $c) {
                return false !== strpos($c->name(), 'ONE');
            });
            $this->assertTrue(is_array($results));
            $this->assertCount(3, $results);
            array_walk($results, function ($r) {
                $this->assertTrue($r instanceof ConstantIntrospection);
            });
        }
    }

    public function testSortConstants()
    {
        foreach ($this->getFixtureInstances() as $i => $m) {
            $results = $m->sortConstants(function (ConstantIntrospection $a, ConstantIntrospection $b) {
                return substr($a->name(), -1, 1) > substr($b->name(), -1, 1);
            });

            $this->assertGreaterThan(3, $results);
            $this->assertStringEndsWith('0', $results[0]->name());
            $this->assertStringEndsWith('2', $results[count($results) - 2]->name());
        }
    }

    public function testExtendsAndimplementsInterface()
    {
        $n = $this->getFixtureClassNamesAbsolute();
        $f = $this->getFixtureInstances();

        $this->assertFalse($f[0]->extendsClass('\SR\Reflection\Tests\Helper\FixtureClassOne'));
        $this->assertTrue($f[1]->extendsClass('\SR\Reflection\Tests\Helper\FixtureClassOne'));
        $this->assertTrue($f[2]->extendsClass('\SR\Reflection\Tests\Helper\FixtureClassOne'));
        $this->assertTrue($f[1]->extendsClass('FixtureClassOne'));
        $this->assertTrue($f[2]->extendsClass('FixtureClassOne'));
        $this->assertFalse($f[0]->extendsClass('\SR\Reflection\Tests\Helper\FixtureClassTwo'));
        $this->assertFalse($f[1]->extendsClass('\SR\Reflection\Tests\Helper\FixtureClassTwo'));
        $this->assertTrue($f[2]->extendsClass('\SR\Reflection\Tests\Helper\FixtureClassTwo'));
        $this->assertTrue($f[2]->extendsClass('FixtureClassTwo'));
        $this->assertFalse($f[0]->extendsClass('\SR\Reflection\Tests\Helper\FixtureClassThree'));
        $this->assertFalse($f[1]->extendsClass('\SR\Reflection\Tests\Helper\FixtureClassThree'));
        $this->assertFalse($f[2]->extendsClass('\SR\Reflection\Tests\Helper\FixtureClassThree'));
        $this->assertFalse($f[0]->extendsClass('\SR\Reflection\Tests\Helper\Invalid\Class\Name'));
        $this->assertFalse($f[1]->extendsClass('\SR\Reflection\Tests\Helper\Invalid\Class\Name'));
        $this->assertFalse($f[2]->extendsClass('\SR\Reflection\Tests\Helper\Invalid\Class\Name'));

        $this->assertFalse($f[0]->usesTrait('SR\Reflection\Tests\Helper\FixtureTrait'));
        $this->assertFalse($f[0]->usesTrait('\SR\Reflection\Tests\Helper\FixtureTrait'));
        $this->assertTrue($f[1]->usesTrait('SR\Reflection\Tests\Helper\FixtureTrait'));
        $this->assertTrue($f[1]->usesTrait('\SR\Reflection\Tests\Helper\FixtureTrait'));
        $this->assertTrue($f[1]->usesTrait('FixtureTrait'));
        $this->assertTrue($f[1]->usesTrait('FixtureTrait'));
        $this->assertFalse($f[2]->usesTrait('SR\Reflection\Tests\Helper\FixtureTrait'));
        $this->assertFalse($f[2]->usesTrait('\SR\Reflection\Tests\Helper\FixtureTrait'));

        $this->assertFalse($f[0]->implementsInterface('SR\Reflection\Tests\Helper\FixtureInterfaceTwo'));
        $this->assertFalse($f[0]->implementsInterface('\SR\Reflection\Tests\Helper\FixtureInterfaceTwo'));
        $this->assertTrue($f[1]->implementsInterface('SR\Reflection\Tests\Helper\FixtureInterfaceTwo'));
        $this->assertTrue($f[1]->implementsInterface('\SR\Reflection\Tests\Helper\FixtureInterfaceTwo'));
        $this->assertTrue($f[2]->implementsInterface('SR\Reflection\Tests\Helper\FixtureInterfaceTwo'));
        $this->assertTrue($f[2]->implementsInterface('\SR\Reflection\Tests\Helper\FixtureInterfaceTwo'));
    }

    public function testMethodAccessors()
    {
        foreach ($this->getFixtureInstances() as $i => $m) {
            $result = $m->filterMethods(function (MethodIntrospection $m) {
                return false !== strpos($m->name(), 'publicOne');
            });
            $this->assertCount(3, $result);
            $result = $m->filterMethods(function (MethodIntrospection $m) {
                return $m->name() === 'abcdef';
            });
            $this->assertCount(0, $result);

            $result = $m->filterOneMethod(function (MethodIntrospection $m) {
                return $m->name() === 'publicOne0';
            });
            $this->assertTrue($result instanceof MethodIntrospection);
            $result = $m->filterOneMethod(function (MethodIntrospection $m) {
                return $m->name() === 'abcdef';
            });
            $this->assertNull($result);

            $result = $m->matchMethods('publicOne0');
            $this->assertCount(1, $result);
            $this->assertTrue($result[0] instanceof MethodIntrospection);
            $result = $m->matchMethods('abcdef');
            $this->assertCount(0, $result);

            $result = $m->matchOneMethod('publicOne0');
            $this->assertTrue($result instanceof MethodIntrospection);
            $result = $m->matchOneMethod('abcdef');
            $this->assertNull($result);

            $this->assertTrue($m->hasMethod('publicOne0'));
            $this->assertFalse($m->hasMethod('abcdef'));

            $result = $m->getMethod('publicOne0');
            $this->assertTrue($result instanceof MethodIntrospection);

            $this->assertGreaterThan(2, $m->publicMethods());
            $this->assertGreaterThan(2, $m->protectedMethods());
            $this->assertGreaterThan(2, $m->privateMethods());

            $result = $m->sortMethods(function (MethodIntrospection $a, MethodIntrospection $b) {
                return substr($a->name(), -1, 1) > substr($b->name(), -1, 1);
            });

            $this->assertGreaterThan(3, $result);

            $result = $m->visitMethods(function (MethodIntrospection $p) {
                return $p->name().'VISITOR';
            });

            array_walk($result, function ($p) {
                $this->assertStringEndsWith('VISITOR', $p);
            });
        }

        $this->expectException('SR\Exception\InvalidArgumentException');
        $this->getFixtureInstances()[0]->getMethod('abcdef');
    }

    public function testPropertyAccessors()
    {
        foreach ($this->getFixtureInstances() as $i => $m) {
            $result = $m->filterProperties(function (PropertyIntrospection $m) {
                return false !== strpos($m->name(), 'propPublicOne');
            });
            $this->assertCount(3, $result);
            $result = $m->filterProperties(function (PropertyIntrospection $m) {
                return $m->name() === 'abcdef';
            });
            $this->assertCount(0, $result);

            $result = $m->filterOneProperty(function (PropertyIntrospection $m) {
                return $m->name() === 'propPublicOne0';
            });
            $this->assertTrue($result instanceof PropertyIntrospection);
            $result = $m->filterOneProperty(function (PropertyIntrospection $m) {
                return $m->name() === 'abcdef';
            });
            $this->assertNull($result);

            $result = $m->matchProperties('propPublicOne0');
            $this->assertCount(1, $result);
            $this->assertTrue($result[0] instanceof PropertyIntrospection);
            $result = $m->matchProperties('abcdef');
            $this->assertCount(0, $result);

            $result = $m->matchOneProperty('propPublicOne0');
            $this->assertTrue($result instanceof PropertyIntrospection);
            $result = $m->matchOneProperty('abcdef');
            $this->assertNull($result);

            $this->assertTrue($m->hasProperty('propPublicOne0'));
            $this->assertFalse($m->hasProperty('abcdef'));

            $result = $m->getProperty('propPublicOne0');
            $this->assertTrue($result instanceof PropertyIntrospection);

            $publicMethods = $m->publicProperties();
            $this->assertGreaterThan(2, $publicMethods);
            foreach ($publicMethods as $method) {
                $this->assertSame('public', $method->visibility());
                $this->assertTrue($method->visibilityPublic());
                $this->assertFalse($method->visibilityProtected());
                $this->assertFalse($method->visibilityPrivate());
                $this->assertTrue($method->accessible());
            }

            $propertiesMethods = $m->protectedProperties();
            $this->assertGreaterThan(2, $propertiesMethods);
            foreach ($propertiesMethods as $method) {
                $this->assertSame('protected', $method->visibility());
                $this->assertFalse($method->visibilityPublic());
                $this->assertTrue($method->visibilityProtected());
                $this->assertFalse($method->visibilityPrivate());
                $this->assertFalse($method->accessible());
            }

            $privateMethods = $m->privateProperties();
            $this->assertGreaterThan(2, $privateMethods);
            foreach ($privateMethods as $method) {
                $this->assertSame('private', $method->visibility());
                $this->assertFalse($method->visibilityPublic());
                $this->assertFalse($method->visibilityProtected());
                $this->assertTrue($method->visibilityPrivate());
                $this->assertFalse($method->accessible());
            }

            $result = $m->sortProperties(function (PropertyIntrospection $a, PropertyIntrospection $b) {
                return substr($a->name(), -1, 1) > substr($b->name(), -1, 1);
            });

            $this->assertGreaterThan(3, $result);

            $result = $m->visitProperties(function (PropertyIntrospection $p) {
                return $p->name().'VISITOR';
            });

            array_walk($result, function ($p) {
                $this->assertStringEndsWith('VISITOR', $p);
            });
        }

        $this->expectException('SR\Exception\InvalidArgumentException');
        $this->getFixtureInstances()[0]->getProperty('abcdef');
    }

    public function testInterfaceAccessors()
    {
        $m = new ClassIntrospection('SR\Reflection\Tests\Helper\FixtureClassThree');

        $result = $m->filterInterfaces(
            function (InterfaceIntrospection $m) {
                return false !== strpos($m->name(), 'Two');
            }
        );
        $this->assertCount(1, $result);
        $result = $m->filterInterfaces(
            function (InterfaceIntrospection $m) {
                return $m->name() === 'abcdef';
            }
        );
        $this->assertCount(0, $result);

        $result = $m->filterOneInterface(
            function (InterfaceIntrospection $m) {
                return $m->name() === 'FixtureInterfaceThree';
            }
        );
        $this->assertTrue($result instanceof InterfaceIntrospection);
        $result = $m->filterOneInterface(
            function (InterfaceIntrospection $m) {
                return $m->name() === 'abcdef';
            }
        );
        $this->assertNull($result);

        $result = $m->matchInterfaces('FixtureInterfaceThree');
        $this->assertCount(1, $result);
        $this->assertTrue($result[0] instanceof InterfaceIntrospection);
        $result = $m->matchInterfaces('abcdef');
        $this->assertCount(0, $result);

        $result = $m->matchOneInterface('FixtureInterfaceTwo');
        $this->assertTrue($result instanceof InterfaceIntrospection);
        $result = $m->matchOneInterface('abcdef');
        $this->assertNull($result);

        $this->assertTrue($m->implementsInterface('SR\Reflection\Tests\Helper\FixtureInterfaceTwo'));
        $this->assertTrue($m->implementsInterface('SR\Reflection\Tests\Helper\FixtureInterfaceThree'));
        $this->assertTrue($m->implementsInterface('FixtureInterfaceTwo'));
        $this->assertTrue($m->implementsInterface('FixtureInterfaceThree'));
        $this->assertFalse($m->implementsInterface('abcdef'));

        $result = $m->getInterface('FixtureInterfaceTwo');
        $this->assertTrue($result instanceof InterfaceIntrospection);
        $result = $m->getInterface('FixtureInterfaceThree');
        $this->assertTrue($result instanceof InterfaceIntrospection);
        $result = $m->getInterface('SR\Reflection\Tests\Helper\FixtureInterfaceTwo');
        $this->assertTrue($result instanceof InterfaceIntrospection);
        $result = $m->getInterface('SR\Reflection\Tests\Helper\FixtureInterfaceThree');
        $this->assertTrue($result instanceof InterfaceIntrospection);

        $result = $m->sortInterfaces(
            function (InterfaceIntrospection $a, InterfaceIntrospection $b) {
                return substr($a->name(), -3, 1) > substr($b->name(), -3, 1);
            }
        );

        $this->assertGreaterThan(1, $result);

        $result = $m->visitInterfaces(
            function (InterfaceIntrospection $p) {
                return $p->name().'VISITOR';
            }
        );

        array_walk($result, function ($p) {
            $this->assertStringEndsWith('VISITOR', $p);
        });

        $this->expectException('SR\Exception\InvalidArgumentException');
        $this->getFixtureInstances()[0]->getInterface('abcdef');
    }
}

/* EOF */
