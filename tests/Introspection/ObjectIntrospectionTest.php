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

use SR\Reflection\Introspection\ObjectIntrospection;
use SR\Reflection\Tests\Helper\AbstractTestHelper;

/**
 * Class ObjectIntrospectionTest.
 */
class ObjectIntrospectionTest extends AbstractTestHelper
{
    /**
     * @var string
     */
    const TEST_CLASS = '\Introspection\ObjectIntrospection';

    /**
     * @var ObjectIntrospection
     */
    protected static $instance = null;

    /**
     * @return ObjectIntrospection[]
     */
    protected function getFixtureInstances($one = null, $two = null, $three = null)
    {
        $testClass = $this->getClassnameQualified();
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

    public function testInvalidConstructorArguments()
    {
        $this->expectException('SR\Exception\InvalidArgumentException');
        $this->getFixtureInstances('/AN/INVALID/NAME/SPACE/I/REALLY/HOPE');
    }

    public function testExport()
    {
        foreach ($this->getFixtureInstances() as $i => $_) {
            $export = $_::export($_);
            $this->assertRegExp('{Object of class \[ }', $export);
            $this->assertRegExp('{- Constants \[[0-9]+\] \{}', $export);
        }
    }

    public function testDocBlock()
    {
        foreach ($this->getFixtureInstances() as $i => $_) {
            $result = $_->docBlock();
            $this->assertRegExp('{Class FixtureClass(One|Two|Three).}', $result);
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
            $this->assertRegExp('{[0-9]+}', (string) $_->lineStart());
            $this->assertRegExp('{[0-9]+}', (string) $_->lineEnd());
            $this->assertTrue(gettype($_->lineStart()) === 'integer');
            $this->assertTrue(gettype($_->lineEnd()) === 'integer');
        }
    }

    public function testModifiers()
    {
        foreach ($this->getFixtureInstances() as $i => $_) {
            $result = $_->modifiers();
            $this->assertTrue(gettype($result) === 'integer');
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
}

/* EOF */
