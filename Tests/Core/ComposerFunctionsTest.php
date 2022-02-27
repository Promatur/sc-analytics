<?php

namespace ScAnalytics\Tests\Core;

use PHPUnit\Framework\TestCase;
use ScAnalytics\Core\ComposerFunctions;

/**
 * Tests the ComposerFunctions class.
 *
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 */
class ComposerFunctionsTest extends TestCase
{

    public function testGetRoot(): void
    {
        self::assertNotEmpty(ComposerFunctions::getRoot());
    }

    public function testGetAssetsDir(): void
    {
        self::assertNotEmpty(ComposerFunctions::getAssetsDir());
        self::assertStringContainsString("/Assets", ComposerFunctions::getAssetsDir());
    }
}
