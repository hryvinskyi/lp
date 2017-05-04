<?php

/**
 * Copyright (c) 2017. Volodumur Hryvinskyi
 * @author   Volodumur Hryvinskyi <script@email.ua>
 * @package  scriptua\lp
 */
class Lp_Reviews_Adminhtml_ReviewsController extends Mage_Adminhtml_Controller_Action
{
    /**
     * Lists all Reviews.
     */
    public function indexAction()
    {
        $this->loadLayout()->_setActiveMenu('lpreviews');

        $contentBlock = $this->getLayout()->createBlock('lpreviews/adminhtml_reviews');

        $this->_addContent($contentBlock)->renderLayout();
    }

    /**
     * Add Reviews.
     */
    public function newAction()
    {
        $this->_forward('edit');
    }

    /**
     * Edit Reviews
     */
    public function editAction()
    {
        $id = (int)$this->getRequest()->getParam('id');

//        $model = Mage::getModel('lp_reviews/reviews');
//        if (isset($id) && $id != 0) {
//            $model->load($id);
//        }
        $model = Mage::getModel('lpreviews/reviews')->load($id);
        Mage::register('current_review', $model);

        $this->loadLayout()->_setActiveMenu('lpreviews');
        $this->_addContent($this->getLayout()->createBlock('lpreviews/adminhtml_reviews_edit'));
        $this->renderLayout();
    }

    /**
     * Save Review to DB
     */
    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost()) {
            try {
                $model = Mage::getModel('lpreviews/reviews');
                $model->setData($data)->setId($this->getRequest()->getParam('id'));
                if(!$model->getCreatedAt()){
                    $model->setCreatedAt(now());
                }
                $model->save();

                Mage::getSingleton('adminhtml/session')->addSuccess($this->__('Reviews was saved successfully'));
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                $this->_redirect('*/*/');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', array(
                    'id' => $this->getRequest()->getParam('id'),
                ));
            }
            return;
        }
        Mage::getSingleton('adminhtml/session')->addError($this->__('Unable to find item to save'));
        $this->_redirect('*/*/');
    }

    /**
     * Delete Review
     */
    public function deleteAction()
    {
        if ($id = $this->getRequest()->getParam('id')) {
            try {
                Mage::getModel('lp_reviews/reviews')->setId($id)->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess($this->__('Reviews was deleted successfully'));
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', ['id' => $id]);
            }
        }
        $this->_redirect('*/*/');
    }

    /**
     * Mass Delete Reviews
     */
    public function massDeleteAction()
    {
        $news = $this->getRequest()->getParam('reviews', null);

        if (is_array($news) && sizeof($news) > 0) {
            try {
                foreach ($news as $id) {
                    Mage::getModel('lpreviews/reviews')->setId($id)->delete();
                }
                $this->_getSession()->addSuccess($this->__('Total of %d news have been deleted', sizeof($news)));
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        } else {
            $this->_getSession()->addError($this->__('Please select reviews'));
        }
        $this->_redirect('*/*');
    }
}