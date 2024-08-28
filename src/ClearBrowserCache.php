<?php

namespace putyourlightson\clearbrowsercache;

use Craft;
use yii\base\BootstrapInterface;
use yii\base\Event;
use yii\base\Module;
use yii\web\Cookie;
use yii\web\Response;

class ClearBrowserCache extends Module implements BootstrapInterface
{
    /**
     * @inheritdoc
     */
    public function bootstrap($app): void
    {
        if (Craft::$app->getRequest()->getIsSiteRequest()) {
            Event::on(
                Response::class,
                Response::EVENT_AFTER_PREPARE,
                function(Event $event) {
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
                        'expire' => time() + (60 * 60 * 24 * 365 * 10), // 10 years
                    ]));
                }
            );
        }
    }
}
