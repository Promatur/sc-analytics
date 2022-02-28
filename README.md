Server-Client-Analytics
==============

[![Latest Stable Version](https://poser.pugx.org/promatur/sc-analytics/v/stable)](https://packagist.org/packages/promatur/sc-analytics)
[![Latest Unstable Version](https://poser.pugx.org/promatur/sc-analytics/v/unstable)](https://packagist.org/packages/promatur/sc-analytics)
[![Total Downloads](https://poser.pugx.org/promatur/sc-analytics/downloads)](https://packagist.org/packages/promatur/sc-analytics)
[![License](https://poser.pugx.org/promatur/sc-analytics/license)](https://packagist.org/packages/promatur/sc-analytics)

## Code Status

![PHPUnit](https://github.com/promatur/sc-analytics/workflows/PHPUnit/badge.svg?branch=main)
![PHPStan](https://github.com/promatur/sc-analytics/workflows/PHPStan%20check/badge.svg?branch=main)
[![Average time to resolve an issue](http://isitmaintained.com/badge/resolution/promatur/sc-analytics.svg)](http://isitmaintained.com/project/promatur/sc-analytics "Average time to resolve an issue")
[![Percentage of issues still open](http://isitmaintained.com/badge/open/promatur/sc-analytics.svg)](http://isitmaintained.com/project/promatur/sc-analytics "Percentage of issues still open")

## Description

A combination of clientside and serverside analytics for PHP-based websites. This repository builds upon existing analytics solutions and offers integrations for [Matomo](https://matomo.org) and [Google Analytics](https://analytics.google.com).

## Usage

It is recommended to use SCAnalytics with composer, which is the easiest way to use it. Just add `promatur/sc-analytics` to your projects requirements.

```shell
composer require promatur/sc-analytics
```

Use some code like this one:

```php
require_once 'vendor/autoload.php';


// - Configure your preferred analytics
// Select between 'matomo', 'google analytics' or 'auto' (recommended)
\ScAnalytics\Core\AnalyticsConfig::$preferred = "matomo";
// Configure your matomo endpoint
\ScAnalytics\Core\AnalyticsConfig::$matomoID = "1";
\ScAnalytics\Core\AnalyticsConfig::$matomoEndpoint = "https://analytics.example.com/";
\ScAnalytics\Core\AnalyticsConfig::$matomoToken = "RCmmQo3mOBfuEwF5OI9l23DcbHymRa6I"; // Optional
// Configure one or multiple Google Analytics tracking IDs
\ScAnalytics\Core\AnalyticsConfig::$googleAnalyticsIDs = ["UA-000000-2", "UA-XXXXXX-X"];

// - Initialize the analytics system
\ScAnalytics\Analytics::init();

// - Get your Analytics Handler
$analytics = Analytics::get();

// - Sending a new page view
// Create a PageData object including the page title and the titles of parent pages
$pageData = new \ScAnalytics\Core\PageData("Help Page", ["Support", "Help Page Overview"])
```

### Assets

SCAnalytics also provides JavaScript assets. If you want the combination of server-side and client-side analytics, configure the location of the assets in your `composer.json`:

```json
{
  "extra": {
    "assets-dir": "libraries",
    "assets-strategy": "copy"
  }
}
```

If you want to use another folder for the assets, configure it in the config:

```php
\ScAnalytics\Core\AnalyticsConfig::$assets = "my-directory";
```

Learn more about the [Composer Assets Plugin](https://github.com/frontpack/composer-assets-plugin).

## Contributing

### Using the library

This is a free/libre library under license LGPL v3 or later.

Your pull requests and/or feedback is very welcome!

### Contributors
Created by Jan-Nicklas Adler.

I am looking forward to your contributions and pull requests!
