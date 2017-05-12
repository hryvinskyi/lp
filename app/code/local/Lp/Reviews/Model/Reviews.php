<?php

/**
 * Copyright (c) 2017. Volodumur Hryvinskyi
 * @author   Volodumur Hryvinskyi <script@email.ua>
 * @package  scriptua\lp
 */
class Lp_Reviews_Model_Reviews extends Mage_Core_Model_Abstract
{
    protected $_eventPrefix = 'lpreviews';

    const XML_PATH_EMAIL_TEMPLATE_ADMIN   = 'lp/lp_group/email_template_admin';
    const XML_PATH_EMAIL_TEMPLATE_USER    = 'lp/lp_group/email_template_user';
    const XML_PATH_SENDER_EMAIL_IDENTITY  = 'lp/lp_group/sender_email_identity';
    const XML_PATH_RECIPIENT_EMAIL        = 'lp/lp_group/recipient_email';

    /**
     * @inheritdoc
     */
    public function _construct()
    {
        parent::_construct();
        $this->_init('lpreviews/reviews');
    }

    /**
     * Validation model attributes
     * @return array|bool
     */
    public function validate()
    {
        $errors = [];

        if (!Zend_Validate::is($this->getContent(), 'NotEmpty')) {
            $errors[] = Mage::helper('lpreviews')->__('Review content can\'t be empty');
        }

        if (empty($errors)) {
            return true;
        }

        return $errors;
    }

    /**
     * Update Mass status
     *
     * @param $reviewsIds
     * @param $attrData
     *
     * @return $this
     */
    public function updateAttributes($reviewsIds, $attrData)
    {
        $reviews = $this->getCollection()
            ->addFieldToFilter('id', ['in' => $reviewsIds]);

        foreach ($reviews as $product) {
            $product->setStatus($attrData['status']);
            $product->save();
        }
        return $this;
    }
}