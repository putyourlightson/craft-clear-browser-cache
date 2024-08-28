# Clear Browser Cache Extension for Craft CMS

This package clears the local browser cache once per unique visitor. It does so by send a `Clear-Site-Data` response header with a value of `"cache"`, and sets a cookie called `BrowserCacheCleared` to prevent the header from being sent again.

[Read this article](https://putyourlightson.com/articles/critical-update-for-a-blitz-blunder) to learn the reason for the existence of this package.

Install this package via composer.

```shell
composer require putyourlightson/craft-clear-browser-cache
```

---

Created by [PutYourLightsOn](https://putyourlightson.com/).
