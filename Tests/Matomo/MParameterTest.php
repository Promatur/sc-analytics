<?php

namespace ScAnalytics\Tests\Matomo;

use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionException;
use ScAnalytics\Matomo\MParameter;

/**
 * Tests the MParameter class.
 *
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 */
class MParameterTest extends TestCase
{

    /**
     * Checks if <code>init()</code> has been executed successfully during class loading.
     *
     * @throws ReflectionException
     */
    public function testInit(): void
    {
        $class = new ReflectionClass(MParameter::class);
        $variables = [];
        foreach ($class->getStaticProperties() as $property => $data) {
            $prop = $class->getProperty($property);
            $prop->setAccessible(true);
            /** @var MParameter $val */
            $val = $prop->getValue();
            self::assertInstanceOf(MParameter::class, $val);
            self::assertNotEmpty($val->getName());
            $variables[] = $val->getName();
        }
        // Check for doubles
        self::assertCount(count($variables), array_flip($variables), "Parameter key used multiple times.");
    }
}
