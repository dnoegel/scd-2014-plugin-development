<?php

class PluginTest extends Shopware\Components\Test\Plugin\TestCase
{
    protected static $ensureLoadedPlugins = array(
        'SwagScdExample' => array()
    );

    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();

        $helper = \TestHelper::Instance();
        $loader = $helper->Loader();

        $loader->registerNamespace(
            'Shopware\Plugins\SwagScdExample',
                dirname(__DIR__) . '/'
        );
    }


    public function testCheckoutAllowedShouldAllow()
    {
        $subscriber = new \Shopware\Plugins\SwagScdExample\Subscriber\Basket(50, 'EK');
        $result = $subscriber->checkoutAllowed();

        $this->assertEquals(true, $result);
    }

    public function testCheckoutAllowedShouldDeny()
    {
        $subscriber = new \Shopware\Plugins\SwagScdExample\Subscriber\Basket(33, 'EK');
        $result = $subscriber->checkoutAllowed();

        $this->assertEquals(false, $result);
    }

}