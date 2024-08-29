# Clear Browser Cache Module for Craft CMS

This module clears the local browser cache once per unique visitor. It does so by send a `Clear-Site-Data` response header with a value of `"cache"`, and sets a cookie called `BrowserCacheCleared` to prevent the header from being sent again.

To learn the reason for its existence, [read this article →](https://putyourlightson.com/articles/critical-update-for-a-blitz-blunder)

Install this module via composer.

```shell
composer require putyourlightson/craft-clear-browser-cache
```

Once installed, the module self-bootstraps and does not require any further setup.

The module is configured to run only until a cut-off date, which is set to `2026-01-01` by default. After that date, the module will have no effect. This value can be overridden by setting a `CLEAR_BROWSER_CACHE_CUTOFF_DATE` environment variable in your `.env` file.

```shell
CLEAR_BROWSER_CACHE_CUTOFF_DATE=2025-09-01
```

---

Created by [PutYourLightsOn](https://putyourlightson.com/).
