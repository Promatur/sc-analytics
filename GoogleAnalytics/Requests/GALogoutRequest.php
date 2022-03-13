<?php


namespace ScAnalytics\GoogleAnalytics\Requests;


/**
 * Class GALogoutRequest. Tracks the event of a user logging out of his/her account.
 *
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 */
class GALogoutRequest extends GAEventRequest
{

    /**
     * GALogoutRequest constructor.
     */
    public function __construct()
    {
        parent::__construct(true, "Account", "logout");
        $this->setUserIdentifier(null);
    }

}