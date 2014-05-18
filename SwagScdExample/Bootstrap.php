<?php
use Shopware\Plugins\SwagScdExample\Commands\SwagScdExampleCommand;
use Shopware\Plugins\SwagScdExample\Subscriber\Resource;

/**
 * The Bootstrap class is the main entry point of any shopware plugin.
 *
 * Short function reference
 * - install: Called a single time during (re)installation. Here you can trigger install-time actions like
 *   - creating the menu
 *   - creating attributes
 *   - creating database tables
 *   You need to return "true" or array('success' => true, 'invalidateCache' => array()) in order to let the installation
 *   be successfull
 *
 * - update: Triggered when the user updates the plugin. You will get passes the former version of the plugin as param
 *   In order to let the update be successful, return "true"
 *
 * - uninstall: Triggered when the plugin is reinstalled or uninstalled. Clean up your tables here.
 */
class Shopware_Plugins_Core_SwagScdExample_Bootstrap extends Shopware_Components_Plugin_Bootstrap
{

    public function getVersion()
    {
        return '1.0.0';
    }

    public function getLabel()
    {
        return 'SwagScdExample';
    }

    public function uninstall()
    {
        return true;
    }

    public function update($oldVersion)
    {
        return true;
    }

    public function install()
    {

        // The SubscriberInterface is available in SW 4.1.4 and later
        if (!$this->assertVersionGreaterThen('4.1.4')) {
            throw new \RuntimeException('At least Shopware 4.1.4 is required');
        }

        // Event listener for console command
        $this->subscribeEvent(
            'Shopware_Console_Add_Command',
            'onAddConsoleCommand'
        );

        // Register an early event for our event subscribers
        $this->subscribeEvent(
            'Enlight_Controller_Front_DispatchLoopStartup',
            'onStartDispatch'
        );

        // old school way of an event listener with global state
        $this->subscribeEvent(
            'Enlight_Controller_Action_PreDispatch_Frontend_Checkout',
            'onPreDispatchCheckoutFinish'
        );

        return true;
    }

    /**
     * Register a command
     * Registering multiple commands is also possible:
     * http://wiki.shopware.de/Shopware-4.2-Upgrade-Guide-for-Developers_detail_1436.html#Provide_own_console_commands_via_Plugin
     *
     * @return SwagScdExampleCommand
     */
    public function onAddConsoleCommand()
    {
        // Register the resource subscriber in order to have access to ower components from
        // within the console command
        $this->registerDefaultSubscriber();

        return new SwagScdExampleCommand();
    }

    /**
     * This callback function is triggered at the very beginning of the dispatch process and allows
     * us to register additional events on the fly. This way you won't ever need to reinstall you
     * plugin for new events - any event and hook can simply be registerend in the event subscribers
     *
     * Notice: We will only register our subscribers here, if we are in frontend.
     * Notice: This callback won't be triggered when running the CLI tools - that's why we register
     * our resource subscriber manually in the CLI callback
     *
     */
    public function onStartDispatch(Enlight_Event_EventArgs $args)
    {
        $this->registerDefaultSubscriber();

        if ($args->getRequest()->getModuleName() != 'frontend') {
            return;
        }

        // In this example we don't want our subscriber to use the global Shopware() singleton.
        // instead we insert the "global state" directly into the subscriber.
        $amount = Shopware()->Modules()->Basket()->sGetAmount();
        $customerGroup = Shopware()->Session()->sUserGroup;

        $subscribers = array(
            new \Shopware\Plugins\SwagScdExample\Subscriber\Basket($amount['totalAmount'], $customerGroup),
            new \Shopware\Plugins\SwagScdExample\Subscriber\ControllerPath($this->Path())
        );

        foreach ($subscribers as $subscriber) {
            $this->Application()->Events()->addSubscriber($subscriber);
        }
    }

    /**
     * The default subscriber will always be used - in frontend, backend or CLI
     */
    public function registerDefaultSubscriber()
    {
        $this->Application()->Events()->addSubscriber(
            new Resource(Shopware()->Container())
        );
    }

    /**
     * Registers the plugin's namespace. As a convention weh should use
     *
     *  Shopwage\Plugins\YourPluginName
     *
     * as namespace
     *
     */
    public function afterInit()
    {
        $this->Application()->Loader()->registerNamespace(
            'Shopware\Plugins\SwagScdExample',
            $this->Path()
        );
    }

    /**
     * Example for an "old school" event subscriber
     *
     * Downsides of this approach for tests:
     *  * Global Shopware() object is needed here
     *  * do you really want to test the Enlight_Event_EventArgs object and functions like
     *    Shopware()->Modules()->Basket()->sGetAmount()?
     *  * do you really want to test the shopware controller?
     *
     *  => see basket subscriber for another approach
     *
     * @param Enlight_Event_EventArgs $args
     */
    public function beforeCheckout(\Enlight_Event_EventArgs $args)
    {
        /** @var \Enlight_Controller_Action $controller */
        $controller = $args->get('subject');
        $request = $controller->Request();

        if ($request->getActionName() != 'finish') {
            return;
        }
        $amount = Shopware()->Modules()->Basket()->sGetAmount();
        $customerGroup = Shopware()->Session()->sUserGroup;


        if ($customerGroup == 'EK' && $amount * 1.1 <= 50) {
            $controller->forward('confirm');
        }
    }
}