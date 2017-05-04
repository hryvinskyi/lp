<?php
/**
 * Copyright (c) 2017. Volodumur Hryvinskyi
 * @author   Volodumur Hryvinskyi <script@email.ua>
 * @package  scriptua\lp
 */

class Lp_Reviews_Block_Adminhtml_Reviews_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{

    protected function _construct()
    {
        $this->_blockGroup = 'lpreviews';
        $this->_controller = 'adminhtml_reviews';
    }

    public function getHeaderText()
    {
        $helper = Mage::helper('lpreviews');
        $model = Mage::registry('current_review');

        if ($model->getId()) {
            return $helper->__("Edit Review '%s'", $this->escapeHtml($model->getTitle()));
        } else {
            return $helper->__("Add Review");
        }
    }
}