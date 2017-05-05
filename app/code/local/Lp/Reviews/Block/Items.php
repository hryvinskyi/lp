<?php

/**
 * Copyright (c) 2017. Volodumur Hryvinskyi
 * @author   Volodumur Hryvinskyi <script@email.ua>
 * @package  scriptua\lp
 */

class Lp_Reviews_Block_Items extends Mage_Core_Block_Template
{
    public function __construct()
    {
        parent::__construct();

        $collection = Mage::getModel('lpreviews/reviews')->getCollection();
        $this->setCollection($collection);
    }

    public function getToolbarHtml()
    {
        return $this->getChildHtml('pager');
    }

    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        $collection = Mage::getModel('lpreviews/reviews')->getCollection();

        $pager = $this->getLayout()->createBlock('page/html_pager', 'custom.pager');
        $pager->setAvailableLimit(array(5=>5,10=>10,20=>20,'all'=>'all'));
        $pager->setCollection($this->getCollection());
        $pager->setAvailableOrders(['created_at' => 'Created Date', 'id' => 'ID']);
        $pager->setDefaultOrder('id');
        $pager->setDefaultDirection("asc");
        $pager->setCollection($collection);

        $this->setChild('pager', $pager);
        $this->getCollection()->load();

        return $this;
    }
}