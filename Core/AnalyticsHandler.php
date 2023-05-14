<?php


namespace ScAnalytics\Core;


use ScAnalytics\Core\ECommerce\Product;
use ScAnalytics\Core\ECommerce\Transaction;

/**
 * Interface AnalyticsHandler. This interface creates a simple interface for all integrated analytics handlers. This interface maps different functions to the specific parameters of the analytics handlers.
 *
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 */
interface AnalyticsHandler
{

    /**
     * @return string The name of the Analytics Handler
     */
    public function getName(): string;

    /**
     * @return bool A boolean, if the Analytics Handler is available and configured
     */
    public function isAvailable(): bool;

    /**
     * Loads the Analytics API in a privacy-friendly way. It also sends a PageView request using the PHP API to get a reliable amount of page views. The page view using the JavaScript API is disabled. The initial <code>pageViewRequest</code> can also be set in <code>$GLOBALS["pageView"]</code> <b>before</b> calling this method. This can be useful, if you want to send a custom page view request with additional data.
     *
     * @param PageData $pageData The data of the current page
     * @param ARequest|null $pageViewRequest An initial page view request. Set to <code>null</code> to use the default one
     * @return string HTML code
     */
    public function loadJS(PageData $pageData, ?ARequest $pageViewRequest = null): string;

    // - Requests

    /**
     * Events are user interactions with content that can be measured independently of a web page or a screen load.
     *
     * @param bool $interactive A boolean, if the event is a result of user interaction
     * @param string $category Typically the object that was interacted with
     * @param string $action The type of interaction
     * @param string|null $label Useful for categorizing events
     * @param int|null $value A numeric value associated with the event
     * @return ARequest The analytics request
     */
    public function event(bool $interactive, string $category, string $action, ?string $label = null, ?int $value = null): ARequest;

    /**
     * Exception tracking allows you to measure the number and type of crashes or errors that occur on your property.
     *
     * @param string|null $description A description of the exception
     * @param bool $fatal true if the exception was fatal
     * @return ARequest The analytics request
     */
    public function exception(?string $description = null, bool $fatal = false): ARequest;

    /**
     * Page view measurement allows you to measure the number of views you had for a particular page on your website.
     *
     * @param PageData|null $pageData Data of the current page
     * @return ARequest The analytics request
     */
    public function pageView(?PageData $pageData): ARequest;

    /**
     * You can use social interaction analytics to measure the number of times users click on social buttons embedded in webpages. For example, you might measure a Facebook "Like" or a Twitter "Tweet".
     *
     * @param string $network The network on which the action occurs (e.g. Facebook, Twitter)
     * @param string $action The type of action that happens (e.g. Like, Send, Tweet)
     * @param string $target Specifies the target of a social interaction. This value is typically a URL but can be any text (e.g. https://promatur.com)
     * @return ARequest The analytics request
     */
    public function social(string $network, string $action, string $target): ARequest;

    /**
     * Reducing page load time can improve the overall user experience of a site.
     *
     * @param string $group A string for categorizing all user timing variables into logical groups (e.g. 'JS Dependencies')
     * @param string $name A string to identify the variable being recorded (e.g. 'load')
     * @param int $milliseconds The number of milliseconds in elapsed time to report to Analytics (e.g. 20)
     * @param string|null $label A string that can be used to add flexibility in visualizing user timings in the reports (e.g. 'Google CDN')
     * @return ARequest The analytics request
     */
    public function timing(string $group, string $name, int $milliseconds, ?string $label = null): ARequest;

    /**
     * Site Search tracking allows tracking how people use the website’s internal search engine.
     *
     * @param PageData|null $pageData The data of the viewed page
     * @param string $keyword The keyword of the search request
     * @param int $results The amount of results of the search request
     * @param string $category The category of the search request (for example: products, help articles, ...)
     * @return ARequest The analytics request
     */
    public function search(?PageData $pageData, string $keyword, int $results, string $category = "all"): ARequest;

    /**
     * Tracks the event of a user logging out of his/her account.
     *
     * @return ARequest The analytics request
     */
    public function logout(): ARequest;

    /**
     * Used for tracking downloads.
     *
     * @param string $fileName The name of the file including the type (for example: <i>file.zip</i>)
     * @param int|null $size The size of the file in bytes
     * @return ARequest The analytics request
     */
    public function download(string $fileName, ?int $size = null): ARequest;

    // - ECommerce
    /**
     * Sent, when adding one or more products to a shopping cart.
     *
     * @param Product[] $products A list of products, which are added to the cart. Keys are their position starting with <code>0</code>
     * @return ARequest The analytics request
     */
    public function addCart(array $products): ARequest;

    /**
     * Sent, when removing one or more products from a shopping cart.
     *
     * @param Product[] $products A list of products, which are removed from the cart. Keys are their position starting with <code>0</code>
     * @return ARequest The analytics request
     */
    public function removeCart(array $products): ARequest;

    /**
     * Sent, when a purchase is completed.
     *
     * @param Transaction $transaction The completed transaction
     * @return ARequest The analytics request
     */
    public function purchase(Transaction $transaction): ARequest;

    /**
     * Sent, starting or proceeding in a checkout process. Is sent as the initial page view request.
     * @param PageData|null $pageData The data of the page
     * @param Product[] $products A list of products, which are added to the cart. Keys are their position starting with <code>0</code>
     * @param int $step The step number
     * @param string|null $option Additional information about a checkout step
     * @return ARequest The analytics request
     */
    public function checkoutStep(?PageData $pageData, array $products, int $step, ?string $option = null): ARequest;

    /**
     * Measures a click on a product.
     *
     * @param string $listName The list, where the product is displayed
     * @param Product $product The product, which the user clicked on
     * @param int $productPosition The position of the product in the list
     * @return ARequest The analytics request
     */
    public function productClick(string $listName, Product $product, int $productPosition = 1): ARequest;

    /**
     * Measures the view of a product page.
     *
     * @param Product $product The product, which is viewed
     * @param PageData|null $pageData The data of the viewed page
     * @return ARequest The analytics request
     */
    public function productPage(Product $product, ?PageData $pageData = null): ARequest;

}