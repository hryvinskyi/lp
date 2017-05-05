<?php
/**
 * Copyright (c) 2017. Volodumur Hryvinskyi
 * @author   Volodumur Hryvinskyi <script@email.ua>
 * @package  scriptua\lp
 */

class Lp_Reviews_Block_Form extends Mage_Core_Block_Template
{
    public function getAction()
    {
        $userId = Mage::app()->getRequest()->getParam('id', false);
        return Mage::getUrl('reviews/index/add', array('user_id' => $userId, '_secure' => $this->_isSecure()));
    }
}