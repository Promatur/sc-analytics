<?php


namespace ScAnalytics\NoAnalytics;

use ScAnalytics\Core\AParameter;
use ScAnalytics\Core\ARequest;

/**
 * Class NoRequest. This class is a dummy request, if no analytics handler is available.
 *
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 */
class NoRequest extends ARequest
{

    /**
     * @inheritDoc
     */
    public function setUserIdentifier(?string $userId): void
    {
    }

    /**
     * @inheritDoc
     */
    public function send(): bool
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    public function updateGenerationTime(): void
    {
    }

    /**
     * @inheritDoc
     */
    public function setParameter(AParameter $key, $value): void
    {
    }
}