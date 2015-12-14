<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magento.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magento.com for more information.
 *
 * @category    Mage
 * @package     Mage_Paypal
 * @copyright  Copyright (c) 2006-2015 X.commerce, Inc. (http://www.magento.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * PayPal Instant Payment Notification processor model
 */
class Cowgirlk_Paypal_Model_Ipn extends Mage_Paypal_Model_Ipn
{
    /**
     * Get ipn data, send verification to PayPal, run corresponding handler
     * Murtza : avoid the exception in case of missing invoice info so paypal doesn't receive a 503 page
     * @param array $request
     * @param Zend_Http_Client_Adapter_Interface $httpAdapter
     * @throws Exception
     */
    public function processIpnRequest(array $request, Zend_Http_Client_Adapter_Interface $httpAdapter = null)
    {
        $this->_request = $request;
        $this->_debugData = array('ipn' => $request);
        ksort($this->_debugData['ipn']);

        try {
            if (!isset($this->_request['invoice'])) {
                if ($httpAdapter) {
                    $this->_config = Mage::getModel('paypal/config', array('', ''));
                    $this->_postBack($httpAdapter); // send reply to paypal
                }
                $this->_debugData['exception'] = 'Missing Invoice/Order Id (maybe Ebay order ?)';
                return;
            }

            if (isset($this->_request['txn_type']) && 'recurring_payment' == $this->_request['txn_type']) {
                $this->_getRecurringProfile();
                if ($httpAdapter) {
                    $this->_postBack($httpAdapter);
                }
                $this->_processRecurringProfile();
            } else {
                $this->_getOrder();
                if ($httpAdapter) {
                    $this->_postBack($httpAdapter);
                }
                $this->_processOrder();
            }
        } catch (Exception $e) {
            $this->_debugData['exception'] = $e->getMessage();
            $this->_debug();
            throw $e;
        }
        $this->_debug();
    }
}