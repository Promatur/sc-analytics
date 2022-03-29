<?php

namespace ScAnalytics\GoogleAnalytics4;

use ScAnalytics\Core\AParameter;

/**
 * Class GA4Event. Parameters for the JSON post body.
 *
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 * @link https://developers.google.com/analytics/devguides/collection/protocol/ga4/reference?client_type=gtag Protocol Reference
 */
class GA4Parameter extends AParameter
{

    // Required
    /**
     * @var GA4Parameter Required. Uniquely identifies a user instance of a web client.
     * @link https://developers.google.com/gtagjs/reference/api#get_mp_example Send event to the Measurement Protocol
     */
    public static $CLIENT_ID;

    // Optional
    /**
     * @var GA4Parameter Optional. A unique identifier for a user.
     * @link https://support.google.com/analytics/answer/9213390 User-ID for cross-platform analysis
     */
    public static $USER_ID;

    /**
     * @var GA4Parameter Optional. A Unix timestamp (in <b>microseconds</b>) for the time to associate with the event. This should only be set to record events that happened in the past. Events can be backdated up to 3 calendar days based on the property's timezone.
     */
    public static $TIMESTAMP;

    /**
     * @var GA4Parameter Optional. The user properties for the measurement.
     * @link https://developers.google.com/analytics/devguides/collection/protocol/ga4/user-properties User properties
     */
    public static $USER_PROPERTIES;

    /**
     * @var GA4Parameter Optional. Set to true to indicate these events should not be used for personalized ads.
     */
    public static $NON_PERSONALIZED_ADS;

    /**
     * @var GA4Parameter <b>Do not use, will be set automatically.</b>. An array of event items. Up to 25 events can be sent per request.
     * @link Events https://developers.google.com/analytics/devguides/collection/protocol/ga4/reference/events reference
     * @see GA4Event
     */
    public static $EVENTS;

    /**
     * Initializes all supported parameters.
     */
    public static function init(): void
    {
        // Required
        self::$CLIENT_ID = new self("client_id");
        // Optional
        self::$USER_ID = new self("user_id");
        self::$TIMESTAMP = new self("timestamp_micros");
        self::$USER_PROPERTIES = new self("user_properties");
        self::$NON_PERSONALIZED_ADS = new self("non_personalized_ads");
        self::$EVENTS = new self("events");
    }
}
GA4Parameter::init();