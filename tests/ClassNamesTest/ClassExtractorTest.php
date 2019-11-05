<?php

/**
 * PHP ClassName getter.
 * A missing class name extractor from PHP files.
 *
 * @link      https://github.com/alex-oleshkevich/classnames the canonical source repository.
 * @copyright Copyright (c) 2014-2016 Alex Oleshkevich <alex.oleshkevich@gmail.com>
 * @license   http://en.wikipedia.org/wiki/MIT_License MIT
 */

namespace ClassNamesTest;

use ClassNames\ClassNames;
use PHPUnit_Framework_TestCase;

class ClassNamesTest extends PHPUnit_Framework_TestCase
{

    public function testNotAClass()
    {
        $extractor = new ClassNames;
        $classes = $extractor->getClassNames(__DIR__ . '/assets/NotAClass.php');
        $this->assertEquals([], $classes);
    }

    public function testNotNamespacedClass()
    {
        $extractor = new ClassNames;
        $classes = $extractor->getClassNames(__DIR__ . '/assets/NotNamespacedClass.php');
        $this->assertEquals(['NotNamespacedClass'], $classes);
    }

    public function testNamespacedClass()
    {
        $extractor = new ClassNames;
        $classes = $extractor->getClassNames(__DIR__ . '/assets/NamespacedClass.php');
        $this->assertEquals(['TestAsset\Classes\NamespacedClass'], $classes);
    }

    public function testManyClassesInOneFile()
    {
        $extractor = new ClassNames;
        $classes = $extractor->getClassNames(__DIR__ . '/assets/ManyClassesInOneFile.php');
        $this->assertEquals(['ManyClassesInOneFile1', 'ManyClassesInOneFile2', 'ManyClassesInOneFile3'], $classes);
    }

    /**
     * @group ns-curly
     */
    public function testCurlyNamespace()
    {
        $extractor = new ClassNames;
        $classes = $extractor->getClassNames(__DIR__ . '/assets/CurlyNamespace.php');
        $this->assertEquals([
            'TestAsset\Asset',
            'TestAsset\Asset2',
            ], $classes);
    }

    /**
     * @group ns-curly-plain-before
     */
    public function testCurlyNamespaceAndPlainClassBefore()
    {
        $extractor = new ClassNames;
        $classes = $extractor->getClassNames(__DIR__ . '/assets/CurlyNamespaceAndPlainClassBefore.php');
        $this->assertEquals([
            'Asset',
            'TestAsset\\Asset',
            ], $classes);
    }

    /**
     * @group ns-curly-plain-after
     */
    public function testCurlyNamespaceAndPlainClassAfter()
    {
        $extractor = new ClassNames;
        $classes = $extractor->getClassNames(__DIR__ . '/assets/CurlyNamespaceAndPlainClassAfter.php');
        $this->assertEquals([
            'TestAsset\\Asset',
            'Asset',
            ], $classes);
    }

    /**
     * @group ns-interface
     */
    public function testNamespacedInterface()
    {
        $extractor = new ClassNames;
        $classes = $extractor->getInterfaceNames(__DIR__ . '/assets/NamespacedInterface.php');
        $this->assertEquals([
            'TestAsset\Classes\NamespacedInterface',
            ], $classes);
    }

    /**
     * @group ns-trait
     */
    public function testNamespacedTrait()
    {
        $extractor = new ClassNames;
        $classes = $extractor->getTraitsNames(__DIR__ . '/assets/NamespacedTrait.php');
        $this->assertEquals([
            'TestAsset\Classes\NamespacedTrait',
            ], $classes);
    }

    /**
     * @group ns-class-constants
     */
    public function testClassWithClassConstants()
    {
        $extractor = new ClassNames;
        $classes = $extractor->getClassNames(__DIR__ . '/assets/ClassWithClassConstants.php');
        $this->assertEquals([
            'TestAsset\Entity\Entity',
            ], $classes);
    }

}
