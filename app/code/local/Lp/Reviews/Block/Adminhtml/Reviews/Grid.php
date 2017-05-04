<?php
/**
 * Copyright (c) 2017. Volodumur Hryvinskyi
 * @author   Volodumur Hryvinskyi <script@email.ua>
 * @package  scriptua\lp
 */


class Lp_Reviews_Block_Adminhtml_Reviews_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('lp_reviews/reviews')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {

        $helper = Mage::helper('lpreviews');

        $this->addColumn('id', array(
            'header' => $helper->__('Review ID'),
            'index' => 'id'
        ));

        $this->addColumn('user_id', array(
            'header' => $helper->__('Usear ID'),
            'index' => 'id',
            'type' => 'text',
        ));

        $this->addColumn('created_at', array(
            'header' => $helper->__('Created'),
            'index' => 'created_at',
            'type' => 'date',
        ));

        return parent::_prepareColumns();
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('id');
        $this->getMassactionBlock()->setFormFieldName('reviews');

        $this->getMassactionBlock()->addItem('delete', array(
            'label' => $this->__('Remove'),
            'url' => $this->getUrl('*/*/massDelete'),
        ));
        return $this;
    }

    public function getRowUrl($model)
    {
        return $this->getUrl('*/*/edit', array(
            'id' => $model->getId(),
        ));
    }
}