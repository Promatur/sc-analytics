<?php

namespace ScAnalytics\Tests\GoogleAnalytics;

use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionException;
use ScAnalytics\GoogleAnalytics\GAParameter;

/**
 * Tests the GAParameter class.
 *
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 */
class GAParameterTest extends TestCase
{

    /**
     * Checks if <code>init()</code> has been executed successfully during class loading.
     *
     * @throws ReflectionException
     */
    public function testInit(): void
    {
        $class = new ReflectionClass(GAParameter::class);
        $variables = [];
        foreach ($class->getStaticProperties() as $property => $data) {
            $prop = $class->getProperty($property);
            $prop->setAccessible(true);
            /** @var GAParameter $val */
            $val = $prop->getValue();
            self::assertInstanceOf(GAParameter::class, $val);
            self::assertNotEmpty($val->getName());
            $variables[] = $val->getName();
        }
        // Check for doubles
        self::assertCount(count($variables), array_flip($variables), "Parameter key used multiple times.");
    }
}
