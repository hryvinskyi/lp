<?php
/**
 * Copyright (c) 2017. Volodumur Hryvinskyi
 * @author   Volodumur Hryvinskyi <script@email.ua>
 * @package  scriptua\lp
 */

class Lp_Reviews_Model_Reviews extends Mage_Core_Model_Abstract
{
    /**
     * @inheritdoc
     */
    public function _construct()
    {
        parent::_construct();
        $this->_init('lpreviews/reviews');
    }

    public function validate()
    {
        $errors = array();

        if (!Zend_Validate::is($this->getContent(), 'NotEmpty')) {
            $errors[] = Mage::helper('lpreviews')->__('Review content can\'t be empty');
        }

        if (empty($errors)) {
            return true;
        }
        return $errors;
    }
}