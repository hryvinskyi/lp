<?php
/**
 * Copyright (c) 2017. Volodumur Hryvinskyi
 * @author   Volodumur Hryvinskyi <script@email.ua>
 * @package  scriptua\lp
 */

class Lp_Reviews_Block_Adminhtml_Reviews_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function getRowUrl($model)
    {
        return $this->getUrl('*/*/edit', [
            'id' => $model->getId(),
        ]);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('lpreviews/reviews')->getCollection();
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {

        $helper = Mage::helper('lpreviews');

        $this->addColumn('id', [
            'header' => $helper->__('Review ID'),
            'index'  => 'id',
        ]);

        $this->addColumn('user_id', [
            'header' => $helper->__('Usear ID'),
            'index'  => 'id',
            'type'   => 'text',
        ]);

        $this->addColumn('created_at', [
            'header' => $helper->__('Created'),
            'index'  => 'created_at',
            'type'   => 'date',
        ]);

        return parent::_prepareColumns();
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('id');
        $this->getMassactionBlock()->setFormFieldName('reviews');

        $this->getMassactionBlock()->addItem('delete', [
            'label' => $this->__('Remove'),
            'url'   => $this->getUrl('*/*/massDelete'),
        ]);

        return $this;
    }
}