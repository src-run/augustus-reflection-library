<?php

/*
 * This file is part of the `src-run/augustus-reflection-library` project.
 *
 * (c) Rob Frawley 2nd <rmf@src.run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace SR\Reflection\Tests\Introspect;

use SR\Reflection\Exception\InvalidArgumentException;
use SR\Reflection\Inspector\AbstractInspector;
use SR\Reflection\Inspector\ClassInspector;
use SR\Reflection\Inspector\ConstantInspector;
use SR\Reflection\Inspector\InterfaceInspector;
use SR\Reflection\Inspector\MethodInspector;
use SR\Reflection\Inspector\PropertyInspector;
use SR\Reflection\Tests\Helper\AbstractTestHelper;

/**
 * Class ClassIntrospectionTest.
 *
 * @covers \SR\Reflection\Inspector\AbstractInspector
 * @covers \SR\Reflection\Inspector\ClassInspector
 * @covers \SR\Reflection\Inspector\Aware\ScopeClass\ConstantAwareTrait
 * @covers \SR\Reflection\Inspector\Aware\ScopeClass\IdentityAwareTrait
 * @covers \SR\Reflection\Inspector\Aware\ScopeClass\InterfaceAwareTrait
 * @covers \SR\Reflection\Inspector\Aware\ScopeClass\ConstantAwareTrait
 * @covers \SR\Reflection\Inspector\Aware\ScopeClass\MethodAwareTrait
 * @covers \SR\Reflection\Inspector\Aware\ScopeClass\ModifiersAwareTrait
 * @covers \SR\Reflection\Inspector\Aware\ScopeClass\PropertyAwareTrait
 * @covers \SR\Reflection\Inspector\Aware\ScopeConstant\IdentityAwareTrait
 * @covers \SR\Reflection\Inspector\Aware\ScopeCore\DocBlockAwareTrait
 * @covers \SR\Reflection\Inspector\Aware\ScopeCore\IdentityDeclaringClassAwareTrait
 * @covers \SR\Reflection\Inspector\Aware\ScopeCore\IdentityInheritanceAwareTrait
 * @covers \SR\Reflection\Inspector\Aware\ScopeCore\IdentityNameAwareTrait
 * @covers \SR\Reflection\Inspector\Aware\ScopeCore\IdentityNamespaceAwareTrait
 * @covers \SR\Reflection\Inspector\Aware\ScopeCore\LocationAwareTrait
 * @covers \SR\Reflection\Inspector\Aware\ScopeCore\ModifiersAwareTrait
 * @covers \SR\Reflection\Inspector\Aware\ScopeCore\VisibilityAwareTrait
 * @covers \SR\Reflection\Inspector\Aware\ScopeMethod\CallableAwareTrait
 * @covers \SR\Reflection\Inspector\Aware\ScopeMethod\IdentityAwareTrait
 * @covers \SR\Reflection\Inspector\Aware\ScopeMethod\ModifiersAwareTrait
 * @covers \SR\Reflection\Inspector\Aware\ScopeProperty\IdentityAwareTrait
 * @covers \SR\Reflection\Inspector\Aware\ScopeProperty\ModifiersAwareTrait
 * @covers \SR\Reflection\Inspector\Aware\ScopeProperty\ValueAwareTrait
 * @covers \SR\Reflection\Resolver\Resolver
 */
class ClassIntrospectTest extends AbstractTestHelper
{
    /**
     * @var string
     */
    const TEST_CLASS = ClassInspector::class;

    /**
     * @var ClassInspector
     */
    protected static $instance = null;

    public function getMethodsAndCheckCount(AbstractInspector $m, $filter = '', $countAssert = null, $levels = null)
    {
        $call = 'getMethods'.ucfirst($filter);
        $methods = $m->{$call}($levels);

        if (null !== $countAssert) {
            $this->assertTrue(count($methods) === $countAssert);
        }

        return $methods;
    }

    public function testInvalidConstructorArguments()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->getFixtureInstances('/AN/INVALID/NAME/SPACE/I/REALLY/HOPE');
    }

    public function testStaticFactoryConstruction()
    {
        $_r = $this->getClassNameQualified();

        foreach ($this->getFixtureClassNamesAbsolute() as $_n) {
            $_nn = new $_r($_n);
            $_a = call_user_func([$_nn, 'reflection']);
            static::assertSame($_n, call_user_func([$_a, 'getName']));
        }

        $this->expectException(InvalidArgumentException::class);
        $this->getFixtureInstances('/AN/INVALID/NAME/SPACE/I/REALLY/HOPE');
    }

    public function testConstruction()
    {
        [$_1n, $_2n, $_3n] = $this->getFixtureClassNamesAbsolute();

        foreach ($this->getFixtureInstances() as $i => $_) {
            $_z = '_'.($i + 1).'n';
            $_a = $_->reflection();

            $this->assertTrue(${$_z} === $_a->getName());
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
        [$_1n, $_2n, $_3n] = $this->getFixtureClassNamesAbsolute();

        foreach ($this->getFixtureInstances() as $i => $_) {
            $_z = '_'.($i + 1).'n';
            $_a = $_->reflection();

            $this->assertTrue(${$_z} === $_a->getName());
            $methods = $this->getMethodsAndCheckCount($_, 'Public', 3 * ($i + 1));
            $this->checkMethods($methods);
        }
    }

    public function testMethodFilterProtected()
    {
        [$_1n, $_2n, $_3n] = $this->getFixtureClassNamesAbsolute();

        foreach ($this->getFixtureInstances() as $i => $_) {
            $_z = '_'.($i + 1).'n';
            $_a = $_->reflection();

            $this->assertTrue(${$_z} === $_a->getName());
            $methods = $this->getMethodsAndCheckCount($_, 'Protected', 3 * ($i + 1));
            $this->checkMethods($methods);
        }
    }

    public function testMethodFilterPrivate()
    {
        [$_1n, $_2n, $_3n] = $this->getFixtureClassNamesAbsolute();

        foreach ($this->getFixtureInstances() as $i => $_) {
            $_z = '_'.($i + 1).'n';
            $_a = $_->reflection();

            $this->assertTrue(${$_z} === $_a->getName());
            $methods = $this->getMethodsAndCheckCount($_, 'Private', 3 * ($i + 1));
            $this->checkMethods($methods);
        }
    }

    public function testMethodFilterVarious()
    {
        [$_1n, $_2n, $_3n] = $this->getFixtureClassNamesAbsolute();

        foreach ($this->getFixtureInstances() as $i => $_) {
            $_z = '_'.($i + 1).'n';
            $_a = $_->reflection();

            $this->assertTrue(${$_z} === $_a->getName());
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

            $filtered = $_->filterMethods(function (MethodInspector $m) {
                return '2' === mb_substr($m->name(), -1, 1);
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
                $this->assertTrue($c instanceof ConstantInspector);

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

        $this->expectException(InvalidArgumentException::class);
        $is[0]->getConstant('NOT_VALID');
    }

    public function testConstantVisitor()
    {
        foreach ($this->getFixtureInstances() as $i => $m) {
            $expectedConstants = $constants = $m->constants();

            array_walk($expectedConstants, function (ConstantInspector &$c) {
                $c = $c->name().$c->value();
            });

            $visitedConstants = $m->visitConstants(function (ConstantInspector $c) {
                return $c->name().$c->value();
            });

            $this->assertSame($expectedConstants, $visitedConstants);
        }
    }

    public function testConstantFilter()
    {
        foreach ($this->getFixtureInstances() as $i => $m) {
            $result = $m->filterOneConstant(function (ConstantInspector $c) {
                return 'ONE_0' === $c->name();
            });

            $this->assertTrue($result instanceof ConstantInspector);
        }
    }

    public function testConstantMatchOne()
    {
        foreach ($this->getFixtureInstances() as $i => $m) {
            $result = $m->matchOneConstant('ONE_0');
            $this->assertTrue($result instanceof ConstantInspector);
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
            $this->assertInternalType('array', $results);
            $this->assertGreaterThan(3, $results);
            array_walk($results, function ($r) {
                $this->assertTrue($r instanceof ConstantInspector);
            });
        }
    }

    public function testConstantsFilter()
    {
        foreach ($this->getFixtureInstances() as $i => $m) {
            $results = $m->filterConstants(function (ConstantInspector $c) {
                return false !== mb_strpos($c->name(), 'ONE');
            });
            $this->assertInternalType('array', $results);
            $this->assertCount(3, $results);
            array_walk($results, function ($r) {
                $this->assertTrue($r instanceof ConstantInspector);
            });
        }
    }

    public function testSortConstants()
    {
        foreach ($this->getFixtureInstances() as $i => $m) {
            $results = $m->sortConstants(function (ConstantInspector $a, ConstantInspector $b) {
                return mb_substr($a->name(), -1, 1) > mb_substr($b->name(), -1, 1);
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
            $result = $m->filterMethods(function (MethodInspector $m) {
                return false !== mb_strpos($m->name(), 'publicOne');
            });
            $this->assertCount(3, $result);
            $result = $m->filterMethods(function (MethodInspector $m) {
                return 'abcdef' === $m->name();
            });
            $this->assertCount(0, $result);

            $result = $m->filterOneMethod(function (MethodInspector $m) {
                return 'publicOne0' === $m->name();
            });
            $this->assertTrue($result instanceof MethodInspector);
            $result = $m->filterOneMethod(function (MethodInspector $m) {
                return 'abcdef' === $m->name();
            });
            $this->assertNull($result);

            $result = $m->matchMethods('publicOne0');
            $this->assertCount(1, $result);
            $this->assertTrue($result[0] instanceof MethodInspector);
            $result = $m->matchMethods('abcdef');
            $this->assertCount(0, $result);

            $result = $m->matchOneMethod('publicOne0');
            $this->assertTrue($result instanceof MethodInspector);
            $result = $m->matchOneMethod('abcdef');
            $this->assertNull($result);

            $this->assertTrue($m->hasMethod('publicOne0'));
            $this->assertFalse($m->hasMethod('abcdef'));

            $result = $m->getMethod('publicOne0');
            $this->assertTrue($result instanceof MethodInspector);

            $this->assertGreaterThan(2, $m->getMethodsPublic());
            $this->assertGreaterThan(2, $m->getMethodsProtected());
            $this->assertGreaterThan(2, $m->getMethodsPrivate());

            $result = $m->sortMethods(function (MethodInspector $a, MethodInspector $b) {
                return mb_substr($a->name(), -1, 1) > mb_substr($b->name(), -1, 1);
            });

            $this->assertGreaterThan(3, $result);

            $result = $m->visitMethods(function (MethodInspector $p) {
                return $p->name().'VISITOR';
            });

            array_walk($result, function ($p) {
                $this->assertStringEndsWith('VISITOR', $p);
            });
        }

        $this->expectException(InvalidArgumentException::class);
        $this->getFixtureInstances()[0]->getMethod('abcdef');
    }

    public function testPropertyAccessors()
    {
        foreach ($this->getFixtureInstances() as $i => $m) {
            $result = $m->filterProperties(function (PropertyInspector $m) {
                return false !== mb_strpos($m->name(), 'propPublicOne');
            });
            $this->assertCount(3, $result);
            $result = $m->filterProperties(function (PropertyInspector $m) {
                return 'abcdef' === $m->name();
            });
            $this->assertCount(0, $result);

            $result = $m->filterOneProperty(function (PropertyInspector $m) {
                return 'propPublicOne0' === $m->name();
            });
            $this->assertTrue($result instanceof PropertyInspector);
            $result = $m->filterOneProperty(function (PropertyInspector $m) {
                return 'abcdef' === $m->name();
            });
            $this->assertNull($result);

            $result = $m->matchProperties('propPublicOne0');
            $this->assertCount(1, $result);
            $this->assertTrue($result[0] instanceof PropertyInspector);
            $result = $m->matchProperties('abcdef');
            $this->assertCount(0, $result);

            $result = $m->matchOneProperty('propPublicOne0');
            $this->assertTrue($result instanceof PropertyInspector);
            $result = $m->matchOneProperty('abcdef');
            $this->assertNull($result);

            $this->assertTrue($m->hasProperty('propPublicOne0'));
            $this->assertFalse($m->hasProperty('abcdef'));

            $result = $m->getProperty('propPublicOne0');
            $this->assertTrue($result instanceof PropertyInspector);

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

            $result = $m->sortProperties(function (PropertyInspector $a, PropertyInspector $b) {
                return mb_substr($a->name(), -1, 1) > mb_substr($b->name(), -1, 1);
            });

            $this->assertGreaterThan(3, $result);

            $result = $m->visitProperties(function (PropertyInspector $p) {
                return $p->name().'VISITOR';
            });

            array_walk($result, function ($p) {
                $this->assertStringEndsWith('VISITOR', $p);
            });
        }

        $this->expectException(InvalidArgumentException::class);
        $this->getFixtureInstances()[0]->getProperty('abcdef');
    }

    public function testInterfaceAccessors()
    {
        $m = new ClassInspector('SR\Reflection\Tests\Helper\FixtureClassThree');

        $result = $m->filterInterfaces(
            function (InterfaceInspector $m) {
                return false !== mb_strpos($m->name(), 'Two');
            }
        );
        $this->assertCount(1, $result);
        $result = $m->filterInterfaces(
            function (InterfaceInspector $m) {
                return 'abcdef' === $m->name();
            }
        );
        $this->assertCount(0, $result);

        $result = $m->filterOneInterface(
            function (InterfaceInspector $m) {
                return 'FixtureInterfaceThree' === $m->name();
            }
        );
        $this->assertTrue($result instanceof InterfaceInspector);
        $result = $m->filterOneInterface(
            function (InterfaceInspector $m) {
                return 'abcdef' === $m->name();
            }
        );
        $this->assertNull($result);

        $result = $m->matchInterfaces('FixtureInterfaceThree');
        $this->assertCount(1, $result);
        $this->assertTrue($result[0] instanceof InterfaceInspector);
        $result = $m->matchInterfaces('abcdef');
        $this->assertCount(0, $result);

        $result = $m->matchOneInterface('FixtureInterfaceTwo');
        $this->assertTrue($result instanceof InterfaceInspector);
        $result = $m->matchOneInterface('abcdef');
        $this->assertNull($result);

        $this->assertTrue($m->implementsInterface('SR\Reflection\Tests\Helper\FixtureInterfaceTwo'));
        $this->assertTrue($m->implementsInterface('SR\Reflection\Tests\Helper\FixtureInterfaceThree'));
        $this->assertTrue($m->implementsInterface('FixtureInterfaceTwo'));
        $this->assertTrue($m->implementsInterface('FixtureInterfaceThree'));
        $this->assertFalse($m->implementsInterface('abcdef'));

        $result = $m->getInterface('FixtureInterfaceTwo');
        $this->assertTrue($result instanceof InterfaceInspector);
        $result = $m->getInterface('FixtureInterfaceThree');
        $this->assertTrue($result instanceof InterfaceInspector);
        $result = $m->getInterface('SR\Reflection\Tests\Helper\FixtureInterfaceTwo');
        $this->assertTrue($result instanceof InterfaceInspector);
        $result = $m->getInterface('SR\Reflection\Tests\Helper\FixtureInterfaceThree');
        $this->assertTrue($result instanceof InterfaceInspector);

        $result = $m->sortInterfaces(
            function (InterfaceInspector $a, InterfaceInspector $b) {
                return mb_substr($a->name(), -3, 1) > mb_substr($b->name(), -3, 1);
            }
        );

        $this->assertGreaterThan(1, $result);

        $result = $m->visitInterfaces(
            function (InterfaceInspector $p) {
                return $p->name().'VISITOR';
            }
        );

        array_walk($result, function ($p) {
            $this->assertStringEndsWith('VISITOR', $p);
        });

        $this->expectException(InvalidArgumentException::class);
        $this->getFixtureInstances()[0]->getInterface('abcdef');
    }

    public function testNamespaceParts()
    {
        $m = new ClassInspector(__CLASS__);
        $this->assertSame(__NAMESPACE__, implode('\\', $m->namespaceSections()));
    }

    private function checkMethods(array $methods)
    {
        array_walk($methods, function (MethodInspector $method) {
            $expectedVisibilityMethod = 'is'.ucfirst($this->getMethodExpectedVisibility($method));
            $this->assertTrue($method->reflection()->{$expectedVisibilityMethod}());
        });
    }

    private function getMethodExpectedVisibility(MethodInspector $method)
    {
        if (1 !== preg_match('{public|protected|private}', $method->name(), $match) || 1 !== count($match)) {
            $this->fail('Could not determine expected visibility.');
        }

        return array_pop($match);
    }
}

/* EOF */
