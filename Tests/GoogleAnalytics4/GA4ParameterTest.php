<?php

namespace GoogleAnalytics4;

use ReflectionClass;
use ReflectionException;
use ScAnalytics\GoogleAnalytics4\GA4Parameter;
use PHPUnit\Framework\TestCase;

/**
 * Tests the GA4Parameter class.
 *
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 */
class GA4ParameterTest extends TestCase
{

    /**
     * Checks if <code>init()</code> has been executed successfully during class loading.
     *
     * @throws ReflectionException
     */
    public function testInit(): void
    {
        $class = new ReflectionClass(GA4Parameter::class);
        $variables = [];
        foreach ($class->getStaticProperties() as $property => $data) {
            $prop = $class->getProperty($property);
            $prop->setAccessible(true);
            /** @var GA4Parameter $val */
            $val = $prop->getValue();
            self::assertInstanceOf(GA4Parameter::class, $val);
            self::assertNotEmpty($val->getName());
            $variables[] = $val->getName();
        }
        // Check for doubles
        self::assertCount(count($variables), array_flip($variables), "Parameter key used multiple times.");
    }
}
