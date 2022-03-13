<?php


namespace ScAnalytics\GoogleAnalytics\Requests;

/**
 * Class GADownloadRequest. Used for tracking downloads.
 *
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 */
class GADownloadRequest extends GAEventRequest
{

    /**
     * GADownloadRequest constructor.
     * @param string $fileName The name of the file including the type (for example: <i>file.zip</i>)
     * @param int|null $size The size of the file in bytes
     */
    public function __construct(string $fileName, ?int $size = null)
    {
        parent::__construct(true, "Download", "download", $fileName, $size);
    }

}