<?php


namespace ScAnalytics\Matomo\Requests;


use JsonException;
use ScAnalytics\Matomo\MParameter;

/**
 * Class MLogoutRequest. Tracks the event of a user logging out of his/her account.
 *
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 * @link https://developer.matomo.org/guides/tracking-javascript-guide#when-user-logs-out-reset-user-id Documentation
 */
class MLogoutRequest extends MEventRequest
{

    /**
     * MLogoutRequest constructor.
     */
    public function __construct()
    {
        parent::__construct("account", "logout");
        try {
            $this->setParameter(MParameter::$NEWVISIT, true);
            $this->setParameter(MParameter::$USERID, "");
        } catch (JsonException $ignored) {
        }
    }
}