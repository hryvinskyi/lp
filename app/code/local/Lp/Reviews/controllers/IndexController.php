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
        $this->getResponse()->setHeader('Content-type', 'application/json');
        //$session = Mage::getSingleton('core/session');
        $jsonData = [];
        if ($data = $this->getRequest()->getPost()) {

            $model = Mage::getModel('lpreviews/reviews');
            $model->setData($data);
            $model->setCreatedAt(now());
            if(($validate = $model->validate()) === true) {
                $model->save();
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
}