<?php
/**
 * Copyright (c) 2017. Volodumur Hryvinskyi
 * @author   Volodumur Hryvinskyi <script@email.ua>
 * @package  scriptua\lp
 */


class Lp_Reviews_Block_Adminhtml_Reviews extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    protected function _construct()
    {
        parent::_construct();

        $helper = Mage::helper('lpreviews');
        $this->_blockGroup = 'lpreviews';
        $this->_controller = 'adminhtml_reviews';

        $this->_headerText = $helper->__('Reviews');
        $this->_addButtonLabel = $helper->__('Add Review');
    }
}