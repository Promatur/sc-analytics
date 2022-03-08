<?php

namespace ScAnalytics\Core;

/**
 * Class Scope. This class contains user-specific settings to the analytics APIs, which are used to enrich requests.
 *
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 */
class Scope
{

    /**
     * @var string|null The language the user is using to visit the website
     */
    private $language;

    /**
     * @var string[] Some custom dimensions, configured by the analytics provider
     */
    private $customDimensions;

    /**
     * @var boolean A boolean if the user has given consent to analyze personal data
     */
    private $analyticsConsent;

    /**
     * @var string|null A unique ID for the client visiting the website (logged in or not)
     */
    private $clientId;

    /**
     * @var string|null A unique ID for a logged-in user. Can be an auto-incremented id
     */
    private $userId;

    /**
     * @param string|null $language The language the user is using to visit the website
     * @param string[] $customDimensions Some custom dimensions, configured by the analytics provider
     * @param bool $analyticsConsent A boolean if the user has given consent to analyze personal data
     * @param string|null $clientId A unique ID for the client visiting the website (logged in or not)
     * @param string|null $userId A unique ID for a logged-in user. Can be an auto-incremented id
     */
    public function __construct(?string $language = null, array $customDimensions = [], bool $analyticsConsent = false, ?string $clientId = null, ?string $userId = null)
    {
        $this->language = $language;
        $this->customDimensions = $customDimensions;
        $this->analyticsConsent = $analyticsConsent;
        $this->clientId = $clientId;
        $this->userId = $userId;
    }


    /**
     * @param string|null $language The language the user is using to visit the website
     * @return Scope Current instance
     */
    public function setLanguage(?string $language): Scope
    {
        $this->language = $language;
        return $this;
    }

    /**
     * @param int $index The index of the custom dimension
     * @param string|null $value The value of the custom dimension
     * @return Scope Current instance
     */
    public function setCustomDimension(int $index, ?string $value): Scope
    {
        if (is_null($value)) {
            unset($this->customDimensions[$index]);
        } else {
            $this->customDimensions[$index] = $value;
        }
        return $this;
    }

    /**
     * @param bool $analyticsConsent A boolean if the user has given consent to analyze personal data
     * @return Scope Current instance
     */
    public function setAnalyticsConsent(bool $analyticsConsent): Scope
    {
        $this->analyticsConsent = $analyticsConsent;
        return $this;
    }

    /**
     * @param string|null $clientId A unique ID for the client visiting the website (logged in or not)
     * @return Scope Current instance
     */
    public function setClientId(?string $clientId): Scope
    {
        $this->clientId = $clientId;
        return $this;
    }

    /**
     * @param string|null $userId A unique ID for a logged-in user. Can be an auto-incremented id
     */
    public function setUserId(?string $userId): void
    {
        $this->userId = $userId;
    }

    /**
     * @return string|null The language the user is using to visit the website
     */
    public function getLanguage(): ?string
    {
        return $this->language;
    }

    /**
     * @return string[] Some custom dimensions, configured by the analytics provider
     */
    public function getCustomDimensions(): array
    {
        return $this->customDimensions;
    }

    /**
     * @return bool A boolean if the user has given consent to analyze personal data
     */
    public function hasAnalyticsConsent(): bool
    {
        return $this->analyticsConsent;
    }

    /**
     * If no manual client id is set using <code>Scope::setClientId()</code>, this function will automatically create and manage a session variable. If analytics consent is given, the client id will be stored in a cookie.
     *
     * @return string|null A unique ID for the client visiting the website (logged in or not)
     */
    public function getClientId(): ?string
    {
        if (!empty($this->clientId)) {
            return $this->clientId;
        }
        if (session_status() === PHP_SESSION_ACTIVE) {
            if (empty($_SESSION['sc_uuid'])) {
                if (empty($_COOKIE['sc_client'])) {
                    $_SESSION['sc_uuid'] = HelperFunctions::generateUUID();
                } else {
                    $_SESSION['sc_uuid'] = $_COOKIE['sc_client'];
                }
            }
            if ($this->analyticsConsent && empty($_COOKIE['sc_session']) && !headers_sent()) {
                setcookie('sc_client', $_SESSION['sc_uuid'], time() + 2628000, '/', '', HelperFunctions::isHTTPS(), true);
            }
            return $_SESSION['sc_uuid'];
        }
        return HelperFunctions::generateUUID();
    }

    /**
     * @return string|null A unique ID for a logged-in user. Can be an auto-incremented id
     */
    public function getUserId(): ?string
    {
        return $this->userId;
    }

}