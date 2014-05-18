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

    /**
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Whenever the container looks up a component, it will trigger the event
     *
     *  Enlight_Bootstrap_InitResource_{REQUESTED_CLASS_NAME}
     *
     * I recommend some namespacing: "MyComponent" might be a very generic name, in order to avoid problems
     * with other plugins, you should prepend your plugin's name or at least your developer prefix
     *
     *
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            'Enlight_Bootstrap_InitResource_SwagScdExample_MyComponent'
                => 'onInitResourceMyComponent',
            'Enlight_Bootstrap_InitResource_SwagScdExample_AnotherComponent'
                => 'onInitResourceAnotherComponent'
        );
    }


    /**
     * In the callbacks we just need to return an instance of the requested class
     *
     * @return MyComponent
     */
    public function onInitResourceMyComponent()
    {
        return new MyComponent($this->container->get('models'));
    }

    /**
     * This callback is already using the DI container to instantiate the class "swagscdexample_mycomponent"
     *
     * @return AnotherComponent
     */
    public function onInitResourceAnotherComponent()
    {
        return new AnotherComponent(
            $this->container->get('models'),
            $this->container->get('swagscdexample_mycomponent')
        );
    }

}