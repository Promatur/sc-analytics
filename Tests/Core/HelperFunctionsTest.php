<?php

namespace ScAnalytics\Tests\Core;

use Exception;
use PHPUnit\Framework\TestCase;
use ScAnalytics\Core\HelperFunctions;

/**
 * Tests the HelperFunctions class.
 *
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 */
class HelperFunctionsTest extends TestCase
{

    public function testGetRoot(): void
    {
        self::assertNotEmpty(HelperFunctions::getRoot());
    }

    public function testGetAssetsDir(): void
    {
        self::assertNotEmpty(HelperFunctions::getAssetsDir());
        self::assertStringContainsString("/Assets", HelperFunctions::getAssetsDir());
    }

    public function testIsHTTPS(): void
    {
        $tests = [
            ["off", 80, "http", "off", false],
            ["on", 443, "https", "on", true],
            [null, 443, null, null, true],
            [null, 80, "http", null, false],
            [null, 80, "https", null, true],
            [null, 80, "http", "on", true]
        ];
        $variables = ['HTTPS', 'SERVER_PORT', 'HTTP_X_FORWARDED_PROTO', 'HTTP_X_FORWARDED_SSL'];

        foreach ($tests as $tid => $test) {
            foreach ($variables as $i => $variable) {
                if (is_null($test[$i]) && isset($_SERVER[$variable])) {
                    unset($_SERVER[$variable]);
                } else {
                    $_SERVER[$variable] = $test[$i];
                }
            }

            self::assertEquals($test[4], HelperFunctions::isHTTPS(), "Failed test for #" . $tid . " " . print_r($test, true));
        }
    }

    public function testGetDomain(): void
    {
        self::assertEquals("http://UNKNOWN", HelperFunctions::getDomain());

        $_SERVER['HTTPS'] = "on";
        self::assertEquals("https://UNKNOWN", HelperFunctions::getDomain());

        $_SERVER['SERVER_NAME'] = "promatur.com";
        self::assertEquals("https://promatur.com", HelperFunctions::getDomain());

        $_SERVER['HTTPS'] = "off";
        self::assertEquals("http://promatur.com", HelperFunctions::getDomain());
    }

    /** @noinspection HttpUrlsUsage */

    public function testGetURL(): void
    {
        self::assertEquals("http://UNKNOWN", HelperFunctions::getURL());

        $_SERVER['HTTPS'] = "on";
        $_SERVER['SERVER_NAME'] = "promatur.com";
        $_SERVER['REQUEST_URI'] = "/abc";
        self::assertEquals("https://promatur.com/abc", HelperFunctions::getURL());
    }

    /**
     * @throws Exception
     */
    public function testGetIpAddress(): void
    {
        self::assertNull(HelperFunctions::getIpAddress());
        $parameters = ['HTTP_CLIENT_IP', 'HTTP_CF_CONNECTING_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR'];
        foreach ($parameters as $key) {
            $valid = "56.148.194.76";
            $_SERVER[$key] = $valid;
            self::assertEquals($valid, HelperFunctions::getIpAddress(), "Failed for $key");
            $_SERVER[$key] = "56.148.194";
            self::assertNull(HelperFunctions::getIpAddress());
            unset($_SERVER[$key]);
        }
    }

    public function testEndsWith(): void
    {
        self::assertFalse(HelperFunctions::endsWith("abcdefg", "fös"));
        self::assertFalse(HelperFunctions::endsWith("abcdefg", "eFg"));
        self::assertFalse(HelperFunctions::endsWith("abcdefg", "abcdefG"));
        self::assertTrue(HelperFunctions::endsWith("abcdefg", "efg"));
        self::assertTrue(HelperFunctions::endsWith("abcdefg", "g"));
        self::assertTrue(HelperFunctions::endsWith("abcdefg", "abcdefg"));
    }

    public function testGenerateUUID(): void
    {
        $list = array();
        for ($i = 0; $i < 100; $i++) {
            /** @var string $uuid */
            $uuid = HelperFunctions::generateUUID();
            self::assertNotContains($uuid, $list);
            $list[] = $uuid;
            self::assertMatchesRegularExpression("/\b[0-9a-f]{8}\b-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-\b[0-9a-f]{12}\b/", $uuid);
        }
    }

    protected function tearDown(): void
    {
        unset($_SERVER['HTTPS'], $_SERVER['SERVER_PORT'], $_SERVER['HTTP_X_FORWARDED_PROTO'], $_SERVER['HTTP_X_FORWARDED_SSL'], $_SERVER['SERVER_NAME'], $_SERVER['REQUEST_URI']);
    }
}
