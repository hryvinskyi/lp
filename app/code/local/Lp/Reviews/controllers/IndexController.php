<?php
/**
 * Copyright (c) 2017. Volodumur Hryvinskyi
 * @author   Volodumur Hryvinskyi <script@email.ua>
 * @package  scriptua\lp
 */

class Lp_Reviews_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction() {
        $this->loadLayout()->renderLayout();
    }

    public function addAction() {
        //$this->getResponse()->setHeader('Content-type', 'application/json');
//        $session = Mage::getSingleton('core/session');
        $jsonData = [];
        if ($data = $this->getRequest()->getPost()) {

            $model = Mage::getModel('lpreviews/reviews');
            $model->setData($data);
            $model->setCreatedAt(now());
            if(($validate = $model->validate()) === true) {
                $model->save();
                $this->_sendMail($model);
                $jsonData = ['success' => $this->__('Review success added. Will be added after moderation')];
            } else {
                if (is_array($validate)) {
                    $jsonData = ['error' => implode(',', $validate)];
                }
                else {
                    $jsonData = ['error' => $this->__('Unable to post the review.')];
                }
//                $session->setFormData($data);
//                if (is_array($validate)) {
//                    foreach ($validate as $errorMessage) {
//                        $session->addError($errorMessage);
//                    }
//                }
//                else {
//                    $session->addError($this->__('Unable to post the review.'));
//                }
            }
        }

        $this->getResponse()->setBody(json_encode($jsonData));
    }

    private function _sendMail($review) {

        /**
         * @var $emailTemplate Mage_Core_Model_Email_Template
         */
        $user_data     = Mage::getModel('customer/customer')->load((int)$review->getUserId());
        $emailTemplate = Mage::getModel('core/email_template');

        $configTemplate = Mage::getStoreConfig(Lp_Reviews_Model_Reviews::XML_PATH_EMAIL_TEMPLATE_ADMIN);
        $emailIdentity  = Mage::getStoreConfig(Lp_Reviews_Model_Reviews::XML_PATH_SENDER_EMAIL_IDENTITY);
        $emailAdmin     = Mage::getStoreConfig(Lp_Reviews_Model_Reviews::XML_PATH_RECIPIENT_EMAIL);

        $emailTemplateVariables['id']         = $review->getId();
        $emailTemplateVariables['username']   = $user_data->getName();
        $emailTemplateVariables['store_url']  = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB);
        $emailTemplateVariables['store_name'] = Mage::app()->getStore()->getName();

        $emailTemplate->setDesignConfig(array('area' => 'frontend'));
        $emailTemplate->sendTransactional(
            $configTemplate,
            $emailIdentity,
            $emailAdmin,
            null,
            $emailTemplateVariables
        );

        if (!$emailTemplate->getSentSuccess()) {
            throw new Exception();
        }
    }
}