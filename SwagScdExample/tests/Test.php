<?php

/**
 * Simple test example
 *
 * By extending Test\Plugin\TestCase we can use some convenient helpers
 *
 * Class PluginTest
 */
class PluginTest extends Shopware\Components\Test\Plugin\TestCase
{
    /**
     * A list of plugins that you want to have installed and active.
     *
     * This is very convenient if you want to run the tests automatically - the helper will take care of the plugins,
     * so you just need to check them out in the correct directory
     *
     * @var array
     */
    protected static $ensureLoadedPlugins = array(
        'SwagScdExample' => array()
    );

    /**
     * Here I just overwrite the setUpBeforeClass method in order to register my namespace
     *
     * That might also be done in a separate bootstrap.php file you include from your phpunit.xml
     *
     */
    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();

        \TestHelper::Instance()->Loader()->registerNamespace(
            'Shopware\Plugins\SwagScdExample',
                dirname(__DIR__) . '/'
        );
    }


    /**
     * As we don't have an global singletons in our test, testing our fancy price calculation is quite easy
     * As stated before: One might want to move the price calculation into an distinct class
     */
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