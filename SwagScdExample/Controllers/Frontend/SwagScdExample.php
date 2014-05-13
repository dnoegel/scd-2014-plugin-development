<?php

class Shopware_Controllers_Frontend_SwagScdExample extends Enlight_Controller_Action
{
    /**
     * Disable the automated lookup of template files
     */
    public function preDispatch()
    {
        $this->View()->loadTemplate('');
    }

    public function indexAction()
    {
        // Instantiating your class directly
        $myComponent = new \Shopware\Plugins\SwagScdExample\Components\MyComponent(
            $this->get('models')
        );

        // Instantiating the class via DI
        $myComponent = $this->get('swagscdexample_mycomponent');

        $myComponent->doStuff();
    }
}