<?php


namespace ScAnalytics\Core;


use RuntimeException;

/**
 * Class ComposerFunctions. Useful functions related to Composer.
 *
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 */
class ComposerFunctions
{

    /**
     * Returns the path to the project root folder, where the composer.json and the vendor directory are located. Does <b>not</b> include a trailing slash. Also works with unit tests.
     *
     * @return string Directory path of the project root
     */
    public static function getRoot(): string
    {
        $directory = __DIR__;
        $root = null;
        do {
            $directory = dirname($directory);
            $vendor = $directory . '/vendor';
            if (file_exists($vendor)) {
                $root = $directory;
            }
        } while (is_null($root) && $directory !== '/');
        if (!is_null($root)) {
            return $root;
        }
        throw new RuntimeException("Could not get project root directory");
    }

    /**
     * Locates the directory storing the assets. Also works with unit tests.
     *
     * @return string Directory path of the asset directory
     */
    public static function getAssetsDir(): string
    {
        $root = self::getRoot();
        if (file_exists($root . "/Assets")) {
            return $root . "/Assets";
        }

        if (file_exists($root . "/libraries/promatur/sc-analytics")) {
            return $root . "/libraries/promatur/sc-analytics";
        }

        throw new RuntimeException("Could not get asset directory");
    }

}