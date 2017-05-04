<?php
/**
 * Copyright (c) 2017. Volodumur Hryvinskyi
 * @author   Volodumur Hryvinskyi <script@email.ua>
 * @package  scriptua\lp
 */

class Lp_Reviews_Model_Resource extends Mage_Core_Model_Resource_Db_Abstract
{

    public function _construct()
    {
        $this->_init('lp_reviews/reviews_items', 'id');
    }

}