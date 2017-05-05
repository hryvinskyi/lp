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
        if ($data = $this->getRequest()->getPost()) {
            $model = Mage::getModel('lpreviews/reviews');
            $model->setData($data);
            $model->setCreatedAt(now());
            $model->save();
        }
        $this->_redirect('*/*/');
    }
}