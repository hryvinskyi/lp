<?php
/**
 * Copyright (c) 2017. Volodumur Hryvinskyi
 * @author   Volodumur Hryvinskyi <script@email.ua>
 * @package  scriptua\lp
 */

class Lp_Reviews_Block_Adminhtml_Reviews_Columns_User extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        $user_data = Mage::getModel('customer/customer')->load((int)$row->getUserId());

        if($user_data->getName()) {
            return $user_data->getName();
        }

        return '';
    }
}