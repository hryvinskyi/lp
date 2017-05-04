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
}