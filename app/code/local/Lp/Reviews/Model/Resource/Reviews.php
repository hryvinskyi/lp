<?php
/**
 * Copyright (c) 2017. Volodumur Hryvinskyi
 * @author   Volodumur Hryvinskyi <script@email.ua>
 * @package  scriptua\lp
 */

class Lp_Reviews_Model_Resource_Reviews extends Mage_Core_Model_Mysql4_Abstract
{

    public function _construct()
    {
        $this->_init('lpreviews/reviews_items', 'id');
    }

}
