<?php

/**
 * Copyright (c) 2017. Volodumur Hryvinskyi
 * @author   Volodumur Hryvinskyi <script@email.ua>
 * @package  scriptua\lp
 */
class Lp_Reviews_Model_Observer
{

    public function invoicedStatusChange($observer)
    {
        $event = $observer->getEvent();
        /** @var $object Lp_Reviews_Model_Reviews */
        $object = $event->getData('object'); // Alternative $event->getObject()

        if (!$object->isObjectNew()) {
            $oldStatus = $object->getOrigData('status');
            $newStatus = $object->getData('status');

            if ((int)$newStatus == 1 && $oldStatus != $newStatus) {
                $this->_sendStatusMail($object);
            }
        }
    }

    /**
     * @param $review Lp_Reviews_Model_Reviews
     */
    private function _sendStatusMail($review)
    {
        /**
         * @var $emailTemplate Mage_Core_Model_Email_Template
         */
        $user_data     = Mage::getModel('customer/customer')->load((int)$review->getUserId());
        $emailTemplate = Mage::getModel('core/email_template');

        $configTemplate = Mage::getStoreConfig(Lp_Reviews_Model_Reviews::XML_PATH_EMAIL_TEMPLATE_USER);
        $emailIdentity  = Mage::getStoreConfig(Lp_Reviews_Model_Reviews::XML_PATH_SENDER_EMAIL_IDENTITY);

        $emailTemplateVariables['id']         = $review->getId();
        $emailTemplateVariables['username']   = $user_data->getName();
        $emailTemplateVariables['store_url']  = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB);
        $emailTemplateVariables['store_name'] = Mage::app()->getStore()->getName();

        $emailTemplate->setDesignConfig(array('area' => 'frontend'));
        $emailTemplate->sendTransactional(
            $configTemplate,
            $emailIdentity,
            $user_data->getEmail(),
            null,
            $emailTemplateVariables
        );

        if (!$emailTemplate->getSentSuccess()) {
            throw new Exception();
        }
    }
}