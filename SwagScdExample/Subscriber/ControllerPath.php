<?php


namespace Shopware\Plugins\SwagScdExample\Subscriber;

use Enlight\Event\SubscriberInterface;

/**
 * Simple subscriber for our controller paths
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

    /**
     * This subscriber needs to know the path of your plugin
     *
     * @param $path
     */
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

    /**
     * Just a hint: You don't need to have an own callback for every controller path event - you can  register
     * the same callback for all ControllerPath events and then create the path from the information you find
     * in Enlight_Event_EventsArgs - it will tell you which module and controller it is currently looking for
     *
     * @return string
     */
    public function onGetScdExampleFrontendController()
    {
        return $this->path . 'Controllers/Frontend/SwagScdExample.php';
    }
}