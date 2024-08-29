<?php

namespace putyourlightson\clearbrowsercache;

use Craft;
use craft\helpers\App;
use yii\base\BootstrapInterface;
use yii\base\Event;
use yii\base\Module;
use yii\web\Cookie;
use yii\web\Response;

class ClearBrowserCache extends Module implements BootstrapInterface
{
    /**
     * The unique ID of this module.
     */
    public const ID = 'clear-browser-cache';

    /**
     * The default cut-off date for clearing the browser cache.
     */
    public const DEFAULT_CUTOFF_DATE = '2026-01-01';

    /**
     * @inheritdoc
     */
    public function bootstrap($app): void
    {
        Craft::$app->setModule(self::ID, $this);

        if (Craft::$app->getRequest()->getIsSiteRequest()) {
            $expireTime = $this->getExpireTime();
            if ($expireTime > 0) {
                Event::on(
                    Response::class,
                    Response::EVENT_AFTER_PREPARE,
                    [$this, 'handleResponse'],
                );
            }
        }
    }

    private function getExpireTime(): int
    {
        $cutoffDate = App::env('CLEAR_BROWSER_CACHE_CUTOFF_DATE') ?? self::DEFAULT_CUTOFF_DATE;
        $expireTime = strtotime($cutoffDate) - time();

        return max($expireTime, 0);
    }

    private function handleResponse(Event $event): void
    {
        $cookie = Craft::$app->getRequest()->getCookies()->get('BrowserCacheCleared');
        if ($cookie !== null) {
            return;
        }

        /** @var Response $response */
        $response = $event->sender;
        $response->getHeaders()->set('Clear-Site-Data', '"cache"');
        $response->getCookies()->add(new Cookie([
            'name' => 'BrowserCacheCleared',
            'value' => 1,
            'expire' => $this->getExpireTime(),
        ]));
    }
}
