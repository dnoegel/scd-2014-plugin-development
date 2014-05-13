<?php

namespace Shopware\Plugins\SwagScdExample\Components;

use Shopware\Components\Model\ModelManager;

/**
 * Example of a simple component with a dependency to the ModelManager
 *
 * Class MyComponent
 * @package Shopware\Plugins\SwagScdExample\Components
 */
class MyComponent
{
    /**
     * @var \Shopware\Components\Model\ModelManager
     */
    private $em;

    public function __construct(ModelManager $em)
    {
        $this->em = $em;
    }

    public function doStuff()
    {
        // your code
    }
}