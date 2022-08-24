Server-Client-Analytics
==============

[![Latest Stable Version](https://poser.pugx.org/promatur/sc-analytics/v/stable)](https://github.com/Promatur/sc-analytics/releases/latest)
[![Latest Unstable Version](https://poser.pugx.org/promatur/sc-analytics/v/unstable)](https://packagist.org/packages/promatur/sc-analytics)
[![Total Downloads](https://poser.pugx.org/promatur/sc-analytics/downloads)](https://packagist.org/packages/promatur/sc-analytics)
[![License](https://poser.pugx.org/promatur/sc-analytics/license)](https://packagist.org/packages/promatur/sc-analytics)

## Code Status

![PHPUnit](https://github.com/promatur/sc-analytics/workflows/PHPUnit/badge.svg?branch=main)
![PHPStan](https://github.com/promatur/sc-analytics/workflows/PHPStan%20check/badge.svg?branch=main)
[![Average time to resolve an issue](http://isitmaintained.com/badge/resolution/promatur/sc-analytics.svg)](http://isitmaintained.com/project/promatur/sc-analytics "Average time to resolve an issue")
[![Percentage of issues still open](http://isitmaintained.com/badge/open/promatur/sc-analytics.svg)](http://isitmaintained.com/project/promatur/sc-analytics "Percentage of issues still open")

## Description


<img align="left" height="200" src="https://user-images.githubusercontent.com/56178675/167543506-ba3b3f1e-789c-4d9e-81ab-4158233c2e05.png" alt="SC-Analytics Logo">

A combination of clientside and serverside analytics for PHP-based websites. This repository builds upon existing
analytics solutions and offers integrations for [Matomo](https://matomo.org)
and [Google Analytics](https://analytics.google.com).
Tested using PHP `7.3`, `7.4` and `8.1`.

<span style="display:block">⠀</span>

<span style="display:block">⠀</span>

<span style="display:block">⠀</span>

## Usage

It is recommended to use SC-Analytics with composer, which is the easiest way to use it. Just add `promatur/sc-analytics`
to your projects requirements.

```shell
composer require promatur/sc-analytics
```

Use some code like this one:

```php
require_once 'vendor/autoload.php';


// - Configure your preferred analytics endpoint
\ScAnalytics\Core\AnalyticsConfig::$matomoID = "1";
\ScAnalytics\Core\AnalyticsConfig::$matomoEndpoint = "https://analytics.example.com/";

// - Initialize the analytics system
\ScAnalytics\Analytics::init();

// - Get your Analytics Handler
$analytics = Analytics::get();

// - Load the Client-Side JavaScript code and initialize the page view
$pageData = new \ScAnalytics\Core\PageData("Help Page", ["Support", "Help Page Overview"])
// Put this anywhere you want to load the JavaScript code
echo $analytics->loadJS($pageData);
```

Learn more in the [Wiki](https://github.com/Promatur/sc-analytics/wiki).

### Assets

SC-Analytics also provides JavaScript assets. If you want the combination of server-side and client-side analytics,
configure the location of the assets in your `composer.json`:

```json
{
  "extra": {
    "assets-dir": "assets",
    "assets-strategy": "copy"
  }
}
```

If you want to use another folder for the assets, configure it in the config:

```php
\ScAnalytics\Core\AnalyticsConfig::$assets = "my-directory";
```

Learn more about the [Composer Assets Plugin](https://github.com/frontpack/composer-assets-plugin).

### Error handling

This package has an integration of [Sentry](https://github.com/getsentry/sentry-php), which is optional to use. Errors
are automatically handled by Sentry and additional information is added.

## Contributing

### Using the library

This is a free/libre library under license LGPL v3 or later.

Your pull requests and/or feedback is very welcome!

### Contributors

Created by Jan-Nicklas Adler.

I am looking forward to your contributions and pull requests!
