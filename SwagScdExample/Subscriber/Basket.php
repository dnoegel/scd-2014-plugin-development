<?php


namespace Shopware\Plugins\SwagScdExample\Subscriber;

use Enlight\Event\SubscriberInterface;

/**
 * This example is going to show how to test your methods without global shopware state
 *
 * Class Basket
 * @package Shopware\Plugins\SwagScdExample\Subscriber
 */
class Basket implements SubscriberInterface
{
    private $amount;
    private $customerGroup;

    public function __construct($amount, $customerGroup)
    {
        $this->amount = $amount;
        $this->customerGroup = $customerGroup;
    }

    public static function getSubscribedEvents()
    {
        return array(
            'Enlight_Controller_Action_PreDispatch_Frontend_Checkout' => 'beforeCheckout'
        );
    }

    /**
     * The actual event listener: We don't want to test it, its quite generic
     *
     * @param \Enlight_Event_EventArgs $args
     */
    public function beforeCheckout(\Enlight_Event_EventArgs $args)
    {
        /** @var \Enlight_Controller_Action $controller */
        $controller = $args->get('subject');
        $request = $controller->Request();

        if ($request->getActionName() != 'finish') {
            return;
        }

        if (!$this->checkoutAllowed()) {
            $controller->forward('confirm');
        }
    }

    /**
     * Here be fancy price calculation - by injection all needed parameters, we don't
     * need any global scope
     *
     * @return bool
     */
    public function checkoutAllowed()
    {
        if ($this->customerGroup == 'EK' && $this->amount * 1.1 <= 50) {
            return false;
        }

        return true;
    }
}