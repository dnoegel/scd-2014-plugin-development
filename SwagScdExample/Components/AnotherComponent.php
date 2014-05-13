<?php

namespace Shopware\Plugins\SwagScdExample\Components;

use Shopware\Components\Model\ModelManager;

/**
 * Example of a class with a dependency to ModelManager and to 'myComponent'.
 * In Subscriber\Resource you can see how this dependency is resolved
 *
 * Class AnotherComponent
 * @package Shopware\Plugins\SwagScdExample\Components
 */
class AnotherComponent
{
    /**
     * @var \Shopware\Components\Model\ModelManager
     */
    private $em;
    /**
     * @var MyComponent
     */
    private $myComponent;

    public function __construct(ModelManager $em, MyComponent $myComponent)
    {
        $this->em = $em;
        $this->myComponent = $myComponent;
    }

    public function doStuff()
    {
        $this->myComponent->doStuff();
    }
}