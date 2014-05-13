<?php

namespace Shopware\Plugins\SwagScdExample\Subscriber;


use Enlight\Event\SubscriberInterface;
use Shopware\Components\DependencyInjection\Container;
use Shopware\Plugins\SwagScdExample\Components\AnotherComponent;
use Shopware\Plugins\SwagScdExample\Components\MyComponent;

/**
 * Resources can be used to extend the DI container in shopware.
 * In the future extending the DI via services.xml will also be possible for plugins
 *
 * Class Resource
 * @package Shopware\Plugins\SwagScdExample\Subscriber
 */
class Resource implements SubscriberInterface
{
    /**
     * @var \Shopware\Components\DependencyInjection\Container
     */
    private $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public static function getSubscribedEvents()
    {
        return array(
            'Enlight_Bootstrap_InitResource_SwagScdExample_MyComponent'
                => 'onInitResourceMyComponent',
            'Enlight_Bootstrap_InitResource_SwagScdExample_AnotherComponent'
                => 'onInitResourceAnotherComponent'
        );
    }


    public function onInitResourceMyComponent()
    {
        return new MyComponent($this->container->get('models'));
    }

    public function onInitResourceAnotherComponent()
    {
        return new AnotherComponent(
            $this->container->get('models'),
            $this->container->get('swagscdexample_mycomponent')
        );
    }

}