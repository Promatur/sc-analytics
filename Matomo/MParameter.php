<?php


namespace ScAnalytics\Matomo;


use ScAnalytics\Core\AParameter;

/**
 * Class MParameter. Contains all Parameters of the Matomo Tracking API.
 *
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 * @link https://developer.matomo.org/api-reference/tracking-api
 */
class MParameter extends AParameter
{
    // - Required
    /**
     * @var MParameter The ID of the website we're tracking a visit/action for
     */
    public static $SITEID;
    /**
     * @var MParameter Required for tracking, must be set to one (1)
     */
    public static $REC;

    // - Recommended
    /**
     * @var MParameter The title of the action being tracked. It is possible to use slashes / to set one or several categories for this action. For example, <b>Help / Feedback</b> will create the Action <b>Feedback</b> in the category <b>Help</b>
     */
    public static $ACTION;
    /**
     * @var MParameter The full URL for the current action
     */
    public static $URL;
    /**
     * @var MParameter The unique visitor ID, must be a 16 characters hexadecimal string. Every unique visitor must be assigned a different ID and this ID must not change after it is assigned
     */
    public static $VISITORID;
    /**
     * @var MParameter Meant to hold a random value that is generated before each request
     */
    public static $RAND;
    /**
     * @var MParameter The parameter defines the api version to use
     */
    public static $APIVERSION;
    /**
     * @var MParameter This parameter can be optionally sent along any tracking request, that isn't a page view
     * @see MParameter::$PING Do not use this parameter together with <code>Ping = 1</code>
     */
    public static $CUSTOMACTION;
    /**
     * @var MParameter The full HTTP Referrer URL
     */
    public static $REFERRER;
    /**
     * @var MParameter Visit scope custom variables. This is a JSON encoded string of the custom variable array
     */
    public static $CUSTOMVARIABLES;
    /**
     * @var MParameter The current count of visits for this visitor
     */
    public static $VISITCOUNT;
    /**
     * @var MParameter The UNIX timestamp of this visitor's previous visit
     */
    public static $LASTTIMESTAMP;
    /**
     * @var MParameter The UNIX timestamp of this visitor's first visit
     */
    public static $FIRSTTIMESTAMP;
    /**
     * @var MParameter The Campaign name (<i>Note: this will only be used to attribute goal conversions, not visits</i>)
     * @see MParameter::$URL Set tracking parameters in the url
     */
    public static $CAMPAIGNNAME;
    /**
     * @var MParameter The Campaign name (<i>Note: this will only be used to attribute goal conversions, not visits</i>)
     * @see MParameter::$URL Set tracking parameters in the url
     */
    public static $CAMPAIGNKEYWORD;
    /**
     * @var MParameter The resolution of the device the visitor is using, eg <code>1280x1024</code>
     */
    public static $RESOLUTION;
    /**
     * @var MParameter The current hour
     */
    public static $HOUR;
    /**
     * @var MParameter The current minute
     */
    public static $MINUTE;
    /**
     * @var MParameter The current second
     */
    public static $SECOND;
    /**
     * @var MParameter If the client uses a plugin for flash
     */
    public static $FLASH;
    /**
     * @var MParameter If the client uses a plugin for Java
     */
    public static $JAVA;
    /**
     * @var MParameter If the client uses a plugin for Director
     */
    public static $DIRECTOR;
    /**
     * @var MParameter If the client uses a plugin for quicktime
     */
    public static $QUICKTIME;
    /**
     * @var MParameter If the client uses a plugin for real player
     */
    public static $REALPLAYER;
    /**
     * @var MParameter If the client uses a plugin for PDF
     */
    public static $PDF;
    /**
     * @var MParameter If the client uses a plugin for windows media
     */
    public static $WINDOWSMEDIA;
    /**
     * @var MParameter If the client uses a plugin for Gears
     */
    public static $GEARS;
    /**
     * @var MParameter If the client uses a plugin for silverlight
     */
    public static $SILVERLIGHT;
    /**
     * @var MParameter If the client supports cookies
     */
    public static $COOKIES;
    /**
     * @var MParameter User-Agent HTTP header field
     */
    public static $USERAGENT;
    /**
     * @var MParameter JSON encoded <b>Client Hints</b> collected by javascript. This will be used to enrich the detected user agent data. (requires Matomo 4.12.0)
     */
    public static $USERAGENTHINTS;
    /**
     * @var MParameter Accept-Language HTTP header field
     */
    public static $LANGUAGE;
    /**
     * @var MParameter Defines the User ID for this request. User ID is any non-empty unique string identifying the user
     */
    public static $USERID;
    /**
     * @var MParameter Defines the visitor ID for this request. You must set this value to exactly a 16 character hexadecimal string
     */
    public static $CLIENTID;
    /**
     * @var MParameter If set to 1, will force a new visit to be created for this action
     */
    public static $NEWVISIT;
    /**
     * @var MParameter A Custom Dimension value for a specific Custom Dimension ID. Requires Matomo 2.15.1 + Custom Dimensions plugin
     */
    public static $CUSTOMDIMENSION;

    // - Optional Parameters
    /**
     * @var MParameter Page scope custom variables
     */
    public static $PAGEVARIABLES;
    /**
     * @var MParameter An external URL the user has opened. Used for tracking outlink clicks
     */
    public static $OUTGOINLINK;
    /**
     * @var MParameter URL of a file the user has downloaded. Used for tracking downloads
     */
    public static $DOWNLOAD;
    /**
     * @var MParameter The Site Search keyword. When specified, the request will not be tracked as a normal pageview but will instead be tracked as a Site Search request
     */
    public static $SEARCHKEYWORD;
    /**
     * @var MParameter When search keyword is specified, you can optionally specify a search category with this parameter
     */
    public static $SEARCHCATEGORY;
    /**
     * @var MParameter We also recommend setting the search_count to the number of search results displayed on the results page. When keywords are tracked with &search_count=0 they will appear in the "No Result Search Keyword" report
     */
    public static $SEARCHCOUNT;
    /**
     * @var MParameter Accepts a six character unique ID that identifies which actions were performed on a specific page view. When a page was viewed, all following tracking requests (such as events) during that page view should use the same pageview ID. Once another page was viewed a new unique ID should be generated. Use [0-9a-Z] as possible characters for the unique ID
     */
    public static $PAGEVIEWID;
    /**
     * @var MParameter If specified, the tracking request will trigger a conversion for the goal of the website being tracked with this ID
     */
    public static $CONVERSIONGOAL;
    /**
     * @var MParameter The charset of the page being tracked. Set, if value is different from <code>utf-8</code>
     */
    public static $CHARSET;

    // - Event Parameters
    /**
     * @var MParameter The required event category
     */
    public static $EVENTCATEGORY;
    /**
     * @var MParameter The required event action
     */
    public static $EVENTACTION;
    /**
     * @var MParameter The event label (eg. a Movie name, or Song name, or File name...)
     */
    public static $EVENTLABEL;
    /**
     * @var MParameter The event value. Must be a float or integer value (numeric), not a string.
     */
    public static $EVENTVALUE;

    // - Content Parameters
    /**
     * @var MParameter The name of the content
     */
    public static $CONTENTNAME;
    /**
     * @var MParameter The actual content piece. For instance the path to an image, video, audio, any text
     */
    public static $CONTENTPIECE;
    /**
     * @var MParameter The target of the content. For instance the URL of a landing page
     */
    public static $CONTENTTARGET;
    /**
     * @var MParameter The name of the interaction with the content. For instance a 'click'
     */
    public static $CONTENTINTERACTION;

    // - Ecommerce
    /**
     * @var MParameter The unique string identifier for the ecommerce order
     */
    public static $ORDERID;
    /**
     * @var MParameter Items in the Ecommerce order. Each item is an array with the following info in this order:
     * <ul>
     * <li>item sku (required),</li>
     * <li>item name (or if not applicable, set it to an empty string),</li>
     * <li>item category (or if not applicable, set it to an empty string),</li>
     * <li>item price (or if not applicable, set it to 0),</li>
     * <li>item quantity (or if not applicable, set it to 1).</li>
     * </ul>
     */
    public static $ECITEMS;
    /**
     * @var MParameter Revenue of an ecommerce order or the monetary value that was generated as revenue by this goal conversion. Only used for conversion revenue, if idgoal is specified in the request
     */
    public static $REVENUE;
    /**
     * @var MParameter The amount of time it took the server to generate this action, in milliseconds
     */
    public static $GENERATIONTIME;
    /**
     * @var MParameter The subtotal of the order; excludes shipping
     */
    public static $SUBTOTAL;
    /**
     * @var MParameter Tax Amount of the order
     */
    public static $TAX;
    /**
     * @var MParameter Shipping cost of the order
     */
    public static $SHIPPING;
    /**
     * @var MParameter Discount offered
     */
    public static $DISCOUNT;
    /**
     * @var MParameter The UNIX timestamp of this customer's last ecommerce order
     */
    public static $LASTORDERTIMESTAMP;

    // - Performance Parameters
    /**
     * @var MParameter Network time in ms (connectEnd – fetchStart)
     */
    public static $NETWORKTIME;
    /**
     * @var MParameter Server time in ms (responseStart – requestStart)
     */
    public static $SERVERTIME;
    /**
     * @var MParameter Transfer time in ms (responseEnd – responseStart)
     */
    public static $TRANSFERTIME;
    /**
     * @var MParameter DOM Processing to Interactive time in ms (domInteractive – domLoading)
     */
    public static $DOMPROCESSINGTIME;
    /**
     * @var MParameter DOM Interactive to Complete time in ms (domComplete – domInteractive)
     */
    public static $DOMCOMPLETIONTIME;
    /**
     * @var MParameter Onload time in ms (loadEventEnd – loadEventStart)
     */
    public static $ONLOADTIME;

    // - Protected Parameters
    /**
     * @var MParameter 32 character authorization key used to authenticate the API request. We recommend to create a user specifically for accessing the Tracking API, and give the user only write permission on the website(s)
     */
    public static $AUTHTOKEN;
    /**
     * @var MParameter Override value for the visitor IP (both IPv4 and IPv6 notations supported). Requires authorization
     * @see MParameter::$AUTHTOKEN
     */
    public static $IP;
    /**
     * @var MParameter Override for the datetime of the request. Auth token required, if date is older than 24h. Requires authorization
     * @see MParameter::$AUTHTOKEN
     */
    public static $DATETIME;
    /**
     * @var MParameter An override value for the country. Should be set to the two letter country code of the visitor (lowercase), eg fr, de, us. Requires authorization
     * @see MParameter::$AUTHTOKEN
     */
    public static $COUNTRY;
    /**
     * @var MParameter An override value for the region. Should be set to a ISO 3166-2 region code. Requires authorization
     * @see MParameter::$AUTHTOKEN
     */
    public static $REGION;
    /**
     * @var MParameter An override value for the city. The name of the city the visitor is located in. Requires authorization
     * @see MParameter::$AUTHTOKEN
     */
    public static $CITY;
    /**
     * @var MParameter An override value for the visitor's latitude. Requires authorization
     * @see MParameter::$AUTHTOKEN
     */
    public static $LATITUDE;
    /**
     * @var MParameter An override value for the visitor's longitude. Requires authorization
     * @see MParameter::$AUTHTOKEN
     */
    public static $LONGITUDE;

    // - Media parameters
    /**
     * @var MParameter A unique id that is always the same while playing a media. As soon as the played media changes (new video or audio started), this ID has to change.
     */
    public static $MEDIAID;
    /**
     * @var MParameter The name / title of the media
     */
    public static $MEDIANAME;
    /**
     * @var MParameter The URL of the media resource
     */
    public static $MEDIAURL;
    /**
     * @var MParameter <code>video</code> or <code>audio</code> depending on the type of the media
     */
    public static $MEDIATYPE;
    /**
     * @var MParameter The name of the media player, for example <code>html5</code>
     */
    public static $MEDIAPLAYER;
    /**
     * @var MParameter The time in seconds for how long a user has been playing this media
     */
    public static $MEDIATIMER;
    /**
     * @var MParameter The duration (the length) of the media in seconds
     */
    public static $MEDIALENGTH;
    /**
     * @var MParameter The progress / current position within the media
     */
    public static $MEDIAPOSITION;
    /**
     * @var MParameter Defines after how many seconds the user has started playing this media. For example a user might have seen the poster of the video for 30 seconds before a user actually pressed the play button
     */
    public static $MEDIASTARTED;
    /**
     * @var MParameter The resolution width of the media in pixels
     */
    public static $MEDIAWIDTH;
    /**
     * @var MParameter The resolution height of the media in pixels
     */
    public static $MEDIAHEIGHT;
    /**
     * @var MParameter Defines whether the media is currently viewed in full screen
     */
    public static $MEDIAFULLSCREEN;
    /**
     * @var MParameter An optional comma separated list of which positions within a media a user has played
     */
    public static $MEDIAPOSITIONS;

    // - Queued Parameters
    /**
     * @var MParameter When set to 0 (zero), the queued tracking handler won't be used and instead the tracking request will be executed directly. This can be useful when you need to debug a tracking problem or want to test that the tracking works in general
     */
    public static $QUEUEDTRACKING;

    // - Other parameters
    /**
     * @var MParameter If set to 0 (send_image=0) Matomo will respond with a HTTP 204 response code instead of a GIF image
     */
    public static $SENDIMAGE;
    /**
     * @var MParameter If set to 1, the request will be a Heartbeat request which will not track any new activity (such as a new visit, new action or new goal). The heartbeat request will only update the visit's total time to provide accurate "Visit duration" metric
     */
    public static $PING;

    // - Bot Parameters
    /**
     * @var MParameter Set to true, to enable bot tracking
     */
    public static $BOTS;

    // - Custom plugin parameters
    /**
     * @var MParameter Measures the bandwidth in bytes that was used by each page view or download. Requires the <b>Bandwidth</b> plugin.
     * @see https://plugins.matomo.org/Bandwidth Plugin page
     */
    public static $BANDWIDTH;
    /**
     * @var MParameter Measures the device pixel ratio of the visitor's devices. Requires the <b>Device Pixel Ratio</b> plugin.
     * @see https://plugins.matomo.org/DevicePixelRatio Plugin page
     */
    public static $DEVICEPIXELRATIO;
    /**
     * @var MParameter The hash of the user's email address. Used to display the user's Gravatar image in Matomo visitor reports. Requires the <b>ProfileGravatar</b> plugin. Use <code><?php echo hash('sha256', 'user.name@mail.com'); ?></code>
     * @see https://plugins.matomo.org/ProfileGravatar Plugin page
     */
    public static $GRAVATARHASH;
    // Crashes
    /**
     * @var MParameter The error message (required).
     */
    public static $ERRORMESSAGE;
    /**
     * @var MParameter Optional stack trace of the error.
     */
    public static $ERRORSTACKTRACE;
    /**
     * @var MParameter Optional category of the error.
     */
    public static $ERRORCATEGORY;
    /**
     * @var MParameter Optional error type.
     */
    public static $ERRORTYPE;
    /**
     * @var MParameter Optional error file.
     */
    public static $ERRORFILE;
    /**
     * @var MParameter Optional error line.
     */
    public static $ERRORLINE;
    /**
     * @var MParameter Optional error column.
     */
    public static $ERRORCOLUMN;


    /**
     * Initializes all supported parameters.
     */
    public static function init(): void
    {
        self::$SITEID = new MParameter("idsite");
        self::$REC = new MParameter("rec");
        self::$ACTION = new MParameter("action_name");
        self::$URL = new MParameter("url");
        self::$VISITORID = new MParameter("_id");
        self::$RAND = new MParameter("rand");
        self::$APIVERSION = new MParameter("apiv");

        self::$REFERRER = new MParameter("urlref");
        self::$RESOLUTION = new MParameter("res");
        // Current Time
        self::$HOUR = new MParameter("h");
        self::$MINUTE = new MParameter("m");
        self::$SECOND = new MParameter("s");
        // Plugins
        self::$FLASH = new MParameter("fla");
        self::$JAVA = new MParameter("java");
        self::$DIRECTOR = new MParameter("dir");
        self::$QUICKTIME = new MParameter("qt");
        self::$REALPLAYER = new MParameter("realp");
        self::$PDF = new MParameter("pdf");
        self::$WINDOWSMEDIA = new MParameter("wma");
        self::$GEARS = new MParameter("gears");
        self::$SILVERLIGHT = new MParameter("ag");
        // User data
        self::$COOKIES = new MParameter("cookie");
        self::$USERAGENT = new MParameter("ua");
        self::$USERAGENTHINTS = new MParameter("uadata");
        self::$LANGUAGE = new MParameter("lang");
        self::$USERID = new MParameter("uid");
        self::$CLIENTID = new MParameter("cid");
        self::$NEWVISIT = new MParameter("new_visit");
        // Custom data
        self::$CUSTOMDIMENSION = new MParameter("dimension%p1%");
        self::$CUSTOMVARIABLES = new MParameter("_cvar");
        // Campaign info
        self::$CAMPAIGNNAME = new MParameter("_rcn");
        self::$CAMPAIGNKEYWORD = new MParameter("_rck");
        // Undocumented variables
        self::$VISITCOUNT = new MParameter("_idvc");
        self::$LASTTIMESTAMP = new MParameter("_viewts");
        self::$FIRSTTIMESTAMP = new MParameter("_idts");
        self::$GENERATIONTIME = new MParameter("gt_ms");
        // Action info
        self::$PAGEVARIABLES = new MParameter("cvar");
        self::$OUTGOINLINK = new MParameter("link");
        self::$DOWNLOAD = new MParameter("download");
        self::$SEARCHKEYWORD = new MParameter("search");
        self::$SEARCHCATEGORY = new MParameter("search_cat");
        self::$SEARCHCOUNT = new MParameter("search_count");
        self::$PAGEVIEWID = new MParameter("pv_id");
        self::$CONVERSIONGOAL = new MParameter("idgoal");
        // Conversion revenue uses the same parameter as revenue
        self::$CHARSET = new MParameter("cs");
        self::$CUSTOMACTION = new MParameter("ca");
        // Page performance info
        self::$NETWORKTIME = new MParameter("pf_net");
        self::$SERVERTIME = new MParameter("pf_srv");
        self::$TRANSFERTIME = new MParameter("pf_tfr");
        self::$DOMPROCESSINGTIME = new MParameter("pf_dm1");
        self::$DOMCOMPLETIONTIME = new MParameter("pf_dm2");
        self::$ONLOADTIME = new MParameter("pf_onl");
        // Event tracking info
        self::$EVENTCATEGORY = new MParameter("e_c");
        self::$EVENTACTION = new MParameter("e_a");
        self::$EVENTLABEL = new MParameter("e_n");
        self::$EVENTVALUE = new MParameter("e_v");
        // Content Tracking info
        self::$CONTENTNAME = new MParameter("c_n");
        self::$CONTENTPIECE = new MParameter("c_p");
        self::$CONTENTTARGET = new MParameter("c_t");
        self::$CONTENTINTERACTION = new MParameter("c_i");
        // Ecommerce info
        self::$ORDERID = new MParameter("ec_id");
        self::$ECITEMS = new MParameter("ec_items");
        self::$REVENUE = new MParameter("revenue");
        self::$SUBTOTAL = new MParameter("ec_st");
        self::$TAX = new MParameter("ec_tx");
        self::$SHIPPING = new MParameter("ec_sh");
        self::$DISCOUNT = new MParameter("ec_dt");
        self::$LASTORDERTIMESTAMP = new MParameter("_ects"); // Undocumented
        // Requiring token authorization
        self::$AUTHTOKEN = new MParameter("token_auth");
        self::$IP = new MParameter("cip");
        self::$DATETIME = new MParameter("cdt");
        self::$COUNTRY = new MParameter("country");
        self::$REGION = new MParameter("region");
        self::$CITY = new MParameter("city");
        self::$LATITUDE = new MParameter("lat");
        self::$LONGITUDE = new MParameter("long");
        // Media Analytics
        self::$MEDIAID = new MParameter("ma_id");
        self::$MEDIANAME = new MParameter("ma_ti");
        self::$MEDIAURL = new MParameter("ma_re");
        self::$MEDIATYPE = new MParameter("ma_mt");
        self::$MEDIAPLAYER = new MParameter("ma_pn");
        self::$MEDIATIMER = new MParameter("ma_st");
        self::$MEDIALENGTH = new MParameter("ma_le");
        self::$MEDIAPOSITION = new MParameter("ma_ps");
        self::$MEDIASTARTED = new MParameter("ma_ttp");
        self::$MEDIAWIDTH = new MParameter("ma_w");
        self::$MEDIAHEIGHT = new MParameter("ma_h");
        self::$MEDIAFULLSCREEN = new MParameter("ma_fs");
        self::$MEDIAPOSITIONS = new MParameter("ma_se");
        // Crashes
        self::$ERRORMESSAGE = new MParameter("cra");
        self::$ERRORSTACKTRACE = new MParameter("cra_st");
        self::$ERRORCATEGORY = new MParameter("cra_ct");
        self::$ERRORTYPE = new MParameter("cra_tp");
        self::$ERRORFILE = new MParameter("cra_ru");
        self::$ERRORLINE = new MParameter("cra_rl");
        self::$ERRORCOLUMN = new MParameter("cra_rc");
        // Queued tracking
        self::$QUEUEDTRACKING = new MParameter("queuedtracking");
        // Other parameters
        self::$SENDIMAGE = new MParameter("send_image");
        self::$PING = new MParameter("ping");
        // Tracking bots
        self::$BOTS = new MParameter("bots");
        // Plugins
        self::$BANDWIDTH = new MParameter("bw_bytes");
        self::$DEVICEPIXELRATIO = new MParameter("devicePixelRatio");
        self::$GRAVATARHASH = new MParameter("gravatar_hash");
    }

}

MParameter::init();