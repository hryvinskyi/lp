<?php

/**
 * Copyright (c) 2017. Volodumur Hryvinskyi
 * @author   Volodumur Hryvinskyi <script@email.ua>
 * @package  scriptua\lp
 */
class Lp_Reviews_Block_Adminhtml_Reviews_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $helper = Mage::helper('lpreviews');
        $model = Mage::registry('current_review');

        $form = new Varien_Data_Form([
            'id'      => 'edit_form',
            'action'  => $this->getUrl('*/*/save', [
                'id' => $this->getRequest()->getParam('id'),
            ]),
            'method'  => 'post',
            'enctype' => 'multipart/form-data',
        ]);

        $this->setForm($form);

        $fieldset = $form->addFieldset('reviews_form', ['legend' => $helper->__('Reviews Information')]);

        $users = Mage::getModel('customer/customer')->getCollection()
            ->addAttributeToSelect('firstname')
            ->addAttributeToSelect('lastname')
            ->addAttributeToSelect('email');

        $dropDownUsers = [];
        foreach ($users as $user) {
            $dropDownUsers[$user->getId()] = $user->getName();
        }

        $fieldset->addField('user_id', 'select', [
            'label'    => $helper->__('User'),
            'required' => true,
            'name'     => 'user_id',
            'values'   => $dropDownUsers,
        ]);

        $fieldset->addField('content', 'editor', [
            'label'    => $helper->__('Content'),
            'required' => true,
            'name'     => 'content',
        ]);

        $fieldset->addField('created_at', 'date', [
            'format' => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
            'image'  => $this->getSkinUrl('images/grid-cal.gif'),
            'label'  => $helper->__('Created'),
            'name'   => 'created_at',
        ]);

        $form->setUseContainer(true);

        if ($data = Mage::getSingleton('adminhtml/session')->getFormData()) {
            $form->setValues($data);
        } else {
            $form->setValues($model->getData());
        }

        return parent::_prepareForm();
    }
}