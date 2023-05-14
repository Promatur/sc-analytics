<?php

namespace ScAnalytics\Tests\Core;

use PHPUnit\Framework\TestCase;
use ScAnalytics\Core\AnalyticsConfig;

/**
 * Tests the AnalyticsConfig class.
 *
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 */
class AnalyticsConfigTest extends TestCase
{

    /**
     * Tests the default values.
     */
    public function testValues(): void
    {
        self::assertFalse(AnalyticsConfig::$debug);
        self::assertNull(AnalyticsConfig::$version);
        self::assertEquals("auto", AnalyticsConfig::$preferred);
        self::assertEmpty(AnalyticsConfig::$matomoID);
        self::assertIsNotArray(AnalyticsConfig::$matomoID);
        self::assertEmpty(AnalyticsConfig::$matomoEndpoint);
        self::assertIsNotArray(AnalyticsConfig::$matomoEndpoint);
        self::assertEmpty(AnalyticsConfig::$matomoToken);
        self::assertIsNotArray(AnalyticsConfig::$matomoToken);
        self::assertEmpty(AnalyticsConfig::$googleAnalyticsIDs);
        self::assertIsArray(AnalyticsConfig::$googleAnalyticsIDs);
        self::assertEquals("assets", AnalyticsConfig::$assets);
        self::assertEquals("", AnalyticsConfig::$relativeAssetsPrefix);
        self::assertEquals("USD", AnalyticsConfig::$currency);
    }

}
