<?php


namespace ScAnalytics\GoogleAnalytics;


use ScAnalytics\Core\AParameter;

/**
 * Class GAParameter. Contains all Parameters of the Google Analytics API.
 *
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 * @link https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters Parameter Documentation
 */
class GAParameter extends AParameter
{

    /**
     * @var GAParameter Google Analytics <a href="https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#v">version</a>
     */
    public static $VERSION;
    /**
     * @var GAParameter The <a href="https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#t">type</a> of the request
     */
    public static $TYPE;
    /**
     * @var GAParameter Google Analytics <a href="https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#tid">Tracking ID</a>
     */
    public static $TRACKINGID;
    /**
     * @var GAParameter Anonymous <a href="https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#cid"client id</a>
     */
    public static $CLIENTID;
    /**
     * @var GAParameter A unique <a href="https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#uid">user id</a> provided by the request provider
     */
    public static $USERID;
    /**
     * @var GAParameter The <a href="https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#uip">IP</a> of the user
     */
    public static $USERIP;
    /**
     * @var GAParameter The <a href="https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#ua">agent</a> used by the user
     */
    public static $USERAGENT;
    /**
     * @var GAParameter The <a href="https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#geoid">geographical location</a> of the user
     */
    public static $GEOID;
    /**
     * @var GAParameter The <a href="https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#ul">language</a> of the user
     */
    public static $USERLANGUAGE;
    /**
     * @var GAParameter The <a href="https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#ec">category</a> of an event
     */
    public static $EVENTCATEGORY;
    /**
     * @var GAParameter The <a href="https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#ea">action</a> of an event
     */
    public static $EVENTACTION;
    /**
     * @var GAParameter The <a href="https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#el">lable</a> of an event
     */
    public static $EVENTLABEL;
    /**
     * @var GAParameter The <a href="https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#ev">value</a> of an event
     */
    public static $EVENTVALUE;
    /**
     * @var GAParameter The <a href="https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#sn">name</a> of a social network
     */
    public static $SOCIALNETWORK;
    /**
     * @var GAParameter The <a href="https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#sa">action</a> of a social interaction (like, ...)
     */
    public static $SOCIALACTION;
    /**
     * @var GAParameter The <a href="https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#st">target</a> of a social interaction. Usually a URL
     */
    public static $SOCIALTARGET;
    /**
     * @var GAParameter Specifies the <a href="https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#exd">description</a> of an exception
     */
    public static $EXCEPTIONDESCRIPTION;
    /**
     * @var GAParameter Boolean, which specifies whether the exception was <a href="https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#exf">fatal</a>
     */
    public static $EXCEPTIONFATAL;
    /**
     * @var GAParameter Boolean to disable the <a href="https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#npa">personalization</a> of the event for advertising purposes
     */
    public static $NOPERSONALIZATION;
    /**
     * @var GAParameter Boolean to <a href="https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#aip">anonymize</a> the IP address
     */
    public static $ANONYMIZEIP;
    /**
     * @var GAParameter The <a href="https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#dr">referrer</a>, which brought the user to the service
     */
    public static $REFERRER;
    /**
     * @var GAParameter The <a href="https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#ds">source</a> of the request
     */
    public static $DATASOURCE;
    /**
     * @var GAParameter The <a href="https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#qt">time between recording and sending</a> the hit
     */
    public static $QUEUETIME;
    /**
     * @var GAParameter An optional <a href="https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#z">random identifier</a> of the request
     */
    public static $CACHEBUSTER;
    /**
     * @var GAParameter Defines the start and end of a <a href="https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#sc">Session</a>
     */
    public static $SESSIONCONTROL;
    /**
     * @var GAParameter The complete <a href="https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#dl">path</a>
     */
    public static $DOCUMENTLOCATION;
    /**
     * @var GAParameter The <a href="https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#dt">title</a> of the document
     */
    public static $DOCUMENTTITLE;
    /**
     * @var GAParameter The <a href="https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#dp">path</a> of the document, starting with a <i>/</i>
     */
    public static $DOCUMENTPATH;
    /**
     * @var GAParameter The <a href="https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#dh">host</a> of the document (foo.com)
     */
    public static $DOCUMENTHOST;
    /**
     * @var GAParameter The <a href="https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#cd">screen name</a> of a view. Optional for web
     */
    public static $SCREENNAME;
    /**
     * @var GAParameter Specifies the user timing <a href="https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#utc">category</a>
     */
    public static $TIMINGCATEGORY;
    /**
     * @var GAParameter Specifies the user timing <a href="https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#utv">variable</a>
     */
    public static $TIMINGVARIABLE;
    /**
     * @var GAParameter Specifies the user timing <a href="https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#utt">time</a>. The value is in milliseconds
     */
    public static $TIMINGTIME;
    /**
     * @var GAParameter Specifies the user timing <a href="https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#utl">label</a>
     */
    public static $TIMINGLABEL;
    /**
     * @var GAParameter Specifies the page <a href="https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#plt">load time</a>. The value is in milliseconds
     */
    public static $LOADTIME;
    /**
     * @var GAParameter Specifies the time it took to do a <a href="https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#dns">DNS lookup</a>. The value is in milliseconds
     */
    public static $DNSTIME;
    /**
     * @var GAParameter Specifies the time it took for the page to be <a href="https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#updt">downloaded</a>. The value is in milliseconds
     */
    public static $DOWNLOADTIME;
    /**
     * @var GAParameter Specifies the time it took for any <a href="https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#rrt">redirects</a> to happen. The value is in milliseconds
     */
    public static $REDIRECTTIME;
    /**
     * @var GAParameter Specifies the time it took for a <a href="https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#tcp">TCP connection</a> to be made. The value is in milliseconds
     */
    public static $TCPTIME;
    /**
     * @var GAParameter Specifies the time it took for the <a href="https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#srt">server to respond</a> after the connect time. The value is in milliseconds
     */
    public static $SERVERRESPONSETIME;
    /**
     * @var GAParameter Specifies the time it took for <a href="https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#dit"><code>Document.readyState</code></a> to be 'interactive'. The value is in milliseconds
     */
    public static $DOMREADYTIME;
    /**
     * @var GAParameter Specifies the time it took for the <a href="https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#clt"><code>DOMContentLoaded</code> Event</a> to fire. The value is in milliseconds
     */
    public static $CONNECTLOADTIME;
    /**
     * @var GAParameter Each <a href="https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#cd_">custom dimension</a> has an associated index
     */
    public static $CUSTOMDIMENSION;
    /**
     * @var GAParameter Each <a href="https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#cm_">custom metric</a> has an associated index
     */
    public static $CUSTOMMETRIC;
    /**
     * @var GAParameter A boolean, if the hit was without a user <a href="https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#ni">interaction</a>
     */
    public static $NONINTERACTION;
    /**
     * @var GAParameter The <a href="https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#cn">name</a> of the campaign
     */
    public static $CAMPAIGNNAME;
    /**
     * @var GAParameter The <a href="https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#cs">source</a> of the campaign
     */
    public static $CAMPAIGNSOURCE;
    /**
     * @var GAParameter The <a href="https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#cm">medium</a> of the campaign
     */
    public static $CAMPAIGNMEDIUM;
    /**
     * @var GAParameter The <a href="https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#ck">keyword</a> of the campaign
     */
    public static $CAMPAIGNKEYWORD;
    /**
     * @var GAParameter The <a href="https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#cc">medium</a> of the campaign
     */
    public static $CAMPAIGNCONTENT;
    /**
     * @var GAParameter The <a href="https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#ci">id</a> of the campaign
     */
    public static $CAMPAIGNID;
    /**
     * @var GAParameter The <a href="https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#gclid">Google Ads ID</a>
     */
    public static $GOOGLEADSID;
    /**
     * @var GAParameter The <a href="https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#dclid">Google Display Ads ID</a>
     */
    public static $GOOGLEDISPLAYADSID;
    /**
     * @var GAParameter The <a href="https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#sr">screen resolution</a> of the user
     */
    public static $SCREENRESOLUTION;
    /**
     * @var GAParameter The <a href="https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#vp">viewable area</a> of the device
     */
    public static $VIEWPORT;
    /**
     * @var GAParameter The <a href="https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#de">document encoding</a> sent by the user
     */
    public static $ENCODING;
    /**
     * @var GAParameter The <a href="https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#de">color depth</a> of the screen
     */
    public static $COLORS;
    /**
     * @var GAParameter A boolean, if the user has <a href="https://developers.google.com/analytics/devguides/cohe llection/protocol/v1/parameters#je">Java</a> enabled
     */
    public static $JAVA;
    /**
     * @var GAParameter A boolean, if the user has <a href="https://developers.google.com/analytics/devguides/cohe llection/protocol/v1/parameters#fl">Flash</a> enabled
     */
    public static $FLASH;
    /**
     * @var GAParameter A <a href="https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#cg_">content group</a> separated by <i>/</i>
     */
    public static $CONTENTGROUP;
    /**
     * @var GAParameter The <a href="https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#linkid">id</a> of a clicked DOM element
     */
    public static $LINKID;
    /**
     * @var GAParameter The <a href="https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#an">name</a> of an app
     */
    public static $APPNAME;
    /**
     * @var GAParameter The <a href="https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#aid">identifier</a> of an app
     */
    public static $APPID;
    /**
     * @var GAParameter The <a href="https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#av">version</a> of an app
     */
    public static $APPVERSION;
    /**
     * @var GAParameter The <a href="https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#aiid">installer id</a> of an app
     */
    public static $APPINSTALLERID;
    /**
     * @var GAParameter The <a href="https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#ti>id</a> of an e-commerce transaction
     */
    public static $TRANSACTIONID;
    /**
     * @var GAParameter The <a href="https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#ta>affiliation or store name</a> of an e-commerce transaction
     */
    public static $TRANSACTIONAFFILIATION;
    /**
     * @var GAParameter The <a href="https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#tr">revenue</a> generated by a transaction. Contains shipping cost and taxes
     */
    public static $TRANSACTIONREVENUE;
    /**
     * @var GAParameter The <a href="https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#ts">shipping cost</a> of a transaction
     */
    public static $TRANSACTIONSHIPPING;
    /**
     * @var GAParameter The <a href="https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#tcc">coupon code</a> redeemed with a transaction
     */
    public static $TRANSACTIONCOUPON;
    /**
     * @var GAParameter The amount of <a href="https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#tt">taxes</a> of a transaction
     */
    public static $TRANSACTIONTAX;
    /**
     * @var GAParameter The <a href="https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#in">name of an item</a> in a transaction
     */
    public static $ITEMNAME;
    /**
     * @var GAParameter The <a href="https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#ip">price of an item</a> in a transaction
     */
    public static $ITEMPRICE;
    /**
     * @var GAParameter The <a href="https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#iq">quantity of an item</a> in a transaction
     */
    public static $ITEMQUANTITY;
    /**
     * @var GAParameter The <a href="https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#ic">sku or code of an item</a> in a transaction
     */
    public static $ITEMCODE;
    /**
     * @var GAParameter The <a href="https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#iv">category of an item</a> in a transaction
     */
    public static $ITEMCATEGORY;
    /**
     * @var GAParameter The <a href="https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#pr_id">sku or id</a> associated with a product
     */
    public static $PRODUCTSKU;
    /**
     * @var GAParameter The <a href="https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#pr_nm">name</a> associated with a product
     */
    public static $PRODUCTNAME;
    /**
     * @var GAParameter The <a href="https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#pr_br">brand</a> associated with a product
     */
    public static $PRODUCTBRAND;
    /**
     * @var GAParameter The <a href="https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#pr_ca">category</a> associated with a product
     */
    public static $PRODUCTCATEGORY;
    /**
     * @var GAParameter The <a href="https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#pr_va">variant</a> associated with a product
     */
    public static $PRODUCTVARIANT;
    /**
     * @var GAParameter The <a href="https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#pr_pr">price</a> associated with a product
     */
    public static $PRODUCTPRICE;
    /**
     * @var GAParameter The <a href="https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#pr_qt">quantity</a> associated with a product
     */
    public static $PRODUCTQUANTITY;
    /**
     * @var GAParameter The <a href="https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#pr_cc">coupon code </a> associated with a product
     */
    public static $PRODUCTCOUPON;
    /**
     * @var GAParameter The product's <a href="https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#pr_ps">position</a> in a list or collection
     */
    public static $PRODUCTPOSITION;
    /**
     * @var GAParameter A product-level <a href="https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#pr_cd_">custom dimension</a>
     */
    public static $PRODUCTCUSTOMDIMENSION;
    /**
     * @var GAParameter A product-level <a href="https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#pr_cm_">custom metric</a>
     */
    public static $PRODUCTCUSTOMMETRIC;
    /**
     * @var GAParameter The <a href="https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#pa">role</a> of the products included in a hit. Must be one of: detail, click, add, remove, checkout, checkout_option, purchase, refund
     */
    public static $PRODUCTACTION;
    /**
     * @var GAParameter The <a href="https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#pal">list or collection</a> from which a product action occurred
     */
    public static $PRODUCTACTIONLIST;
    /**
     * @var GAParameter The <a href="https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#il_nm">list or collection</a> to which a product belongs
     */
    public static $PRODUCTIMPRESSIONLIST;
    /**
     * @var GAParameter The product <a href="https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#il_pi_id">id or SKU</a> of an impression
     */
    public static $PRODUCTIMPRESSIONSKU;
    /**
     * @var GAParameter The product <a href="https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#il_pi_nm">name</a> of an impression
     */
    public static $PRODUCTIMPRESSIONNAME;
    /**
     * @var GAParameter The product <a href="https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#il_pi_br">brand</a> of an impression
     */
    public static $PRODUCTIMPRESSIONBRAND;
    /**
     * @var GAParameter The product <a href="https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#il_pi_ca">category</a> of an impression
     */
    public static $PRODUCTIMPRESSIONCATEGORY;
    /**
     * @var GAParameter The product <a href="https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#il_pi_va">variant</a> of an impression
     */
    public static $PRODUCTIMPRESSIONVARIANT;
    /**
     * @var GAParameter The product <a href="https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#il_pi_ps">position</a> of an impression
     */
    public static $PRODUCTIMPRESSIONPOSITION;
    /**
     * @var GAParameter The product <a href="https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#il_pi_pr">price</a> of an impression
     */
    public static $PRODUCTIMPRESSIONPRICE;
    /**
     * @var GAParameter A product-level <a href="https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#il_pi_cd_">custom dimension</a> of an impression
     */
    public static $PRODUCTIMPRESSIONCUSTOMDIMENSION;
    /**
     * @var GAParameter A product-level <a href="https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#il_pi_cm_">custom metric</a> of an impression
     */
    public static $PRODUCTIMPRESSIONCUSTOMMETRIC;
    /**
     * @var GAParameter The <a href="https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#cos">step number</a> in a checkout funnel
     */
    public static $CHECKOUTSTEP;
    /**
     * @var GAParameter Some <a href="https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#cos">Additional information</a> about a checkout step
     */
    public static $CHECKOUTSTEPOPTION;
    /**
     * @var GAParameter The promotion <a href="https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#promo_id">id</a>
     */
    public static $PROMOID;
    /**
     * @var GAParameter The promotion <a href="https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#promo_nn">name</a>
     */
    public static $PROMONAME;
    /**
     * @var GAParameter The promotion <a href="https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#promo_cr">creative</a>
     */
    public static $PROMOCREATIVE;
    /**
     * @var GAParameter The promotion <a href="https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#promo_ps">position</a>
     */
    public static $PROMOPOSITION;
    /**
     * @var GAParameter The promotion <a href="https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#promoa">action</a>
     */
    public static $PROMOACTION;
    /**
     * @var GAParameter Indicates the local <a href="https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#cu">currency</a> for all transaction currency values. Value should be a valid ISO 4217 currency code
     */
    public static $CURRENCY;

    /**
     * Initializes all supported parameters.
     */
    public static function init(): void
    {
        // General
        self::$VERSION = new self("v");
        self::$TRACKINGID = new self("tid");
        self::$ANONYMIZEIP = new self("aip");
        self::$NOPERSONALIZATION = new self("npa");
        self::$DATASOURCE = new self("ds");
        self::$QUEUETIME = new self("qt");
        self::$CACHEBUSTER = new self("z");
        // User
        self::$CLIENTID = new self("cid");
        self::$USERID = new self("uid");
        // Session
        self::$SESSIONCONTROL = new self("sc");
        self::$USERIP = new self("uip");
        self::$USERAGENT = new self("ua");
        self::$GEOID = new self("geoid");
        // Traffic sources
        self::$REFERRER = new self("dr");
        self::$CAMPAIGNNAME = new self("cn");
        self::$CAMPAIGNSOURCE = new self("cs");
        self::$CAMPAIGNMEDIUM = new self("cm");
        self::$CAMPAIGNKEYWORD = new self("ck");
        self::$CAMPAIGNCONTENT = new self("cc");
        self::$CAMPAIGNID = new self("ci");
        self::$GOOGLEADSID = new self("gclid");
        self::$GOOGLEDISPLAYADSID = new self("dclid");
        // System Info
        self::$SCREENRESOLUTION = new self("sr");
        self::$VIEWPORT = new self("vp");
        self::$ENCODING = new self("de");
        self::$COLORS = new self("sd");
        self::$USERLANGUAGE = new self("ul");
        self::$JAVA = new self("je");
        self::$FLASH = new self("fl");
        // Hit
        self::$TYPE = new self("t");
        self::$NONINTERACTION = new self("ni");
        // Content Information
        self::$DOCUMENTLOCATION = new self("dl");
        self::$DOCUMENTHOST = new self("dh");
        self::$DOCUMENTPATH = new self("dp");
        self::$DOCUMENTTITLE = new self("dt");
        self::$SCREENNAME = new self("cd");
        self::$CONTENTGROUP = new self("cg%p1%");
        self::$LINKID = new self("linkid");
        // Apps
        self::$APPNAME = new self("an");
        self::$APPID = new self("aid");
        self::$APPVERSION = new self("av");
        self::$APPINSTALLERID = new self("aiid");
        // Events
        self::$EVENTCATEGORY = new self("ec");
        self::$EVENTACTION = new self("ea");
        self::$EVENTLABEL = new self("el");
        self::$EVENTVALUE = new self("ev");
        // E-Commerce
        self::$TRANSACTIONID = new self("ti");
        self::$TRANSACTIONAFFILIATION = new self("ta");
        self::$TRANSACTIONREVENUE = new self("tr");
        self::$TRANSACTIONSHIPPING = new self("ts");
        self::$TRANSACTIONTAX = new self("tt");
        self::$ITEMNAME = new self("in");
        self::$ITEMPRICE = new self("ip");
        self::$ITEMQUANTITY = new self("iq");
        self::$ITEMCODE = new self("ic");
        self::$ITEMCATEGORY = new self("iv");
        // Enhanced E-Commerce
        self::$PRODUCTSKU = new self("pr%p1%id");
        self::$PRODUCTNAME = new self("pr%p1%nm");
        self::$PRODUCTBRAND = new self("pr%p1%br");
        self::$PRODUCTCATEGORY = new self("pr%p1%ca");
        self::$PRODUCTVARIANT = new self("pr%p1%va");
        self::$PRODUCTPRICE = new self("pr%p1%pr");
        self::$PRODUCTQUANTITY = new self("pr%p1%qt");
        self::$PRODUCTCOUPON = new self("pr%p1%cc");
        self::$PRODUCTPOSITION = new self("pr%p1%ps");
        self::$PRODUCTCUSTOMDIMENSION = new self("pr%p1%cd%p2%");
        self::$PRODUCTCUSTOMMETRIC = new self("pr%p1%cm%p2%");
        self::$PRODUCTACTION = new self("pa");
        self::$TRANSACTIONCOUPON = new self("tcc");
        self::$PRODUCTACTIONLIST = new self("pal");
        self::$CHECKOUTSTEP = new self("cos");
        self::$CHECKOUTSTEPOPTION = new self("col");
        self::$PRODUCTIMPRESSIONLIST = new self("il%p1%nm");
        self::$PRODUCTIMPRESSIONSKU = new self("il%p1%pi%p2%id");
        self::$PRODUCTIMPRESSIONNAME = new self("il%p1%pi%p2%nm");
        self::$PRODUCTIMPRESSIONBRAND = new self("il%p1%pi%p2%br");
        self::$PRODUCTIMPRESSIONCATEGORY = new self("il%p1%pi%p2%ca");
        self::$PRODUCTIMPRESSIONVARIANT = new self("il%p1%pi%p2%va");
        self::$PRODUCTIMPRESSIONPOSITION = new self("il%p1%pi%p2%ps");
        self::$PRODUCTIMPRESSIONPRICE = new self("il%p1%pi%p2%pr");
        self::$PRODUCTIMPRESSIONCUSTOMDIMENSION = new self("il%p1%pi%p2%cd%p3%");
        self::$PRODUCTIMPRESSIONCUSTOMMETRIC = new self("il%p1%pi%p2%cm%p3%");
        self::$PROMOID = new self("promo%p1%id");
        self::$PROMONAME = new self("promo%p1%nm");
        self::$PROMOCREATIVE = new self("promo%p1%cr");
        self::$PROMOPOSITION = new self("promo%p1%ps");
        self::$PROMOACTION = new self("promo%p1%a");
        self::$CURRENCY = new self("cu");
        // Social Interactions
        self::$SOCIALNETWORK = new self("sn");
        self::$SOCIALACTION = new self("sa");
        self::$SOCIALTARGET = new self("st");
        // Timing
        self::$TIMINGCATEGORY = new self("utc");
        self::$TIMINGVARIABLE = new self("utv");
        self::$TIMINGTIME = new self("utt");
        self::$TIMINGLABEL = new self("utl");
        self::$LOADTIME = new self("plt");
        self::$DNSTIME = new self("dns");
        self::$DOWNLOADTIME = new self("pdt");
        self::$REDIRECTTIME = new self("rrt");
        self::$TCPTIME = new self("tcp");
        self::$SERVERRESPONSETIME = new self("srt");
        self::$DOMREADYTIME = new self("dit");
        self::$CONNECTLOADTIME = new self("clt");
        // Exceptions
        self::$EXCEPTIONDESCRIPTION = new self("exd");
        self::$EXCEPTIONFATAL = new self("exf");
        // Custom Dimensions/Metrics
        self::$CUSTOMDIMENSION = new self("cd%p1%");
        self::$CUSTOMMETRIC = new self("cm%p1%");
    }
}

GAParameter::init();