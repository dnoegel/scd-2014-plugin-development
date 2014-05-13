<?php


namespace Shopware\Plugins\SwagScdExample\Subscriber;

use Enlight\Event\SubscriberInterface;

/**
 * Simple subscriber for out controller paths
 *
 * Class ControllerPath
 * @package Shopware\Plugins\SwagScdExample\Subscriber
 */
class ControllerPath implements SubscriberInterface
{
    /**
     * @var string
     */
    private $path;

    public function __construct($path)
    {

        $this->path = $path;
    }

    public static function getSubscribedEvents()
    {
        return array(
            'Enlight_Controller_Dispatcher_ControllerPath_Frontend_SwagScdExample' => 'onGetScdExampleFrontendController'
        );
    }

    public function onGetScdExampleFrontendController()
    {
        return $this->path . 'Controllers/Frontend/SwagScdExample.php';
    }
}