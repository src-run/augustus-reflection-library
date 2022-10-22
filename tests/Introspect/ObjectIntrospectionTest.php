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

use SR\Reflection\Inspector\ObjectInspector;
use SR\Reflection\Tests\Helper\AbstractTestHelper;

/**
 * Class ObjectIntrospectionTest.
 *
 * @covers \SR\Reflection\Inspector\AbstractInspector
 * @covers \SR\Reflection\Inspector\ObjectInspector
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
class ObjectIntrospectionTest extends AbstractTestHelper
{
    /**
     * @var string
     */
    public const TEST_CLASS = ObjectInspector::class;

    /**
     * @var ObjectInspector
     */
    protected static $instance = null;

    public function testInvalidConstructorArguments()
    {
        $this->expectException('SR\Reflection\Exception\InvalidArgumentException');
        $this->getFixtureInstances('/AN/INVALID/NAME/SPACE/I/REALLY/HOPE');
    }

    /*
    public function testExport()
    {
        foreach ($this->getFixtureInstances() as $i => $_) {
            $export = $_::export($_);
            $this->assertMatchesRegularExpression('{Object of class \[ }', $export);
            $this->assertMatchesRegularExpression('{- Constants \[[0-9]+\] \{}', $export);
        }
    }
    */

    public function testDocBlock()
    {
        foreach ($this->getFixtureInstances() as $i => $_) {
            $result = $_->docBlock();
            $this->assertMatchesRegularExpression('{Class FixtureClass(One|Two|Three).}', $result);
        }
    }

    public function testLocation()
    {
        $files = [
            'FixtureClassOne.php',
            'FixtureClassTwo.php',
            'FixtureClassThree.php',
        ];

        foreach ($this->getFixtureInstances() as $i => $_) {
            $result = $_->file();
            $this->assertSame($files[$i], $result->getFilename());
            $this->assertMatchesRegularExpression('{[0-9]+}', (string) $_->lineStart());
            $this->assertMatchesRegularExpression('{[0-9]+}', (string) $_->lineEnd());
            $this->assertTrue('integer' === gettype($_->lineStart()));
            $this->assertTrue('integer' === gettype($_->lineEnd()));
        }
    }

    public function testModifiers()
    {
        foreach ($this->getFixtureInstances() as $i => $_) {
            $result = $_->modifiers();
            $this->assertTrue('integer' === gettype($result));
            $this->assertFalse($_->isAbstract());
            $this->assertFalse($_->isTrait());
            $this->assertFalse($_->isIterateable());
            $this->assertFalse($_->isAnonymous());
            $this->assertTrue($_->isClonable());
            $this->assertFalse($_->isFinal());
            $this->assertFalse($_->isInternal());
            $this->assertTrue($_->isUserDefined());
            $this->assertTrue($_->isInstantiable());
            $class = $_->name(true);
            $class = new $class();
            $this->assertTrue($_->isInstance($class));
            $this->assertFalse($_->isInterface());
        }
    }

    /**
     * @return ObjectInspector[]
     */
    protected function getFixtureInstances($one = null, $two = null, $three = null)
    {
        $testClass = $this->getClassNameQualified();
        $_ = $this->getFixtureClassNamesAbsolute();

        array_walk($_, function (&$className) {
            $className = new $className();
        });

        return [
            new $testClass($one ?: $_[0]),
            new $testClass($two ?: $_[1]),
            new $testClass($three ?: $_[2]),
        ];
    }
}

/* EOF */
