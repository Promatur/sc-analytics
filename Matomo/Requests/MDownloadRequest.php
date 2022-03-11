<?php


namespace ScAnalytics\Matomo\Requests;


use JsonException;
use ScAnalytics\Core\HelperFunctions;
use ScAnalytics\Matomo\MParameter;

/**
 * Class MDownloadRequest. Used for tracking downloads.
 *
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 */
class MDownloadRequest extends MEventRequest
{

    /**
     * MDownloadRequest constructor.
     *
     * @param string $fileName The name of the file including the type (for example: <i>file.zip</i>)
     * @param int|null $size The size of the file in bytes
     */
    public function __construct(string $fileName, ?int $size = null)
    {
        parent::__construct("Download", "download", $fileName, $size);
        try {
            $this->setParameter(MParameter::$DOWNLOAD, HelperFunctions::getURL());
            $this->setParameter(MParameter::$BANDWIDTH, $size);
        } catch (JsonException $ignored) {
        }
    }

}