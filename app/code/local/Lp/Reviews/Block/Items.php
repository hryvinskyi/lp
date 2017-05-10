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

        /** @var $collection Lp_Reviews_Model_Resource_Reviews_Collection */

        $collection = Mage::getModel('lpreviews/reviews')->getCollection();

        $fn = Mage::getModel('eav/entity_attribute')->loadByCode('1', 'firstname');
        $ln = Mage::getModel('eav/entity_attribute')->loadByCode('1', 'lastname');

        $collection->getSelect()
            ->join(['ce1' => 'customer_entity_varchar'], 'ce1.entity_id=main_table.user_id', ['firstname' => 'value'])
            ->where('ce1.attribute_id=' . $fn->getAttributeId())

            ->join(['ce2' => 'customer_entity_varchar'], 'ce2.entity_id=main_table.user_id', ['lastname' => 'value'])
            ->where('ce2.attribute_id=' . $ln->getAttributeId())
            ->columns(new Zend_Db_Expr("CONCAT(`ce1`.`value`, ' ',`ce2`.`value`) AS fullname"))
            ->where('main_table.status=1')
            ->order('created_at DESC');

        $this->setCollection($collection);
    }

    public function getToolbarHtml()
    {
        return $this->getChildHtml('pager');
    }

    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        $collection = Mage::getModel('lpreviews/reviews')
            ->getCollection()
            ->addFieldToFilter('status', '1');

        $pager = $this->getLayout()->createBlock('page/html_pager', 'custom.pager');
        $pager->setAvailableLimit([5 => 5, 10 => 10, 20 => 20, 'all' => 'all']);
        $pager->setCollection($this->getCollection());
        $pager->setAvailableOrders(['created_at' => 'Created Date', 'id' => 'ID']);
        $pager->setDefaultOrder('created_at');
        $pager->setDefaultDirection("asc");
        $pager->setCollection($collection);

        $this->setChild('pager', $pager);
        $this->getCollection()->load();

        return $this;
    }
}