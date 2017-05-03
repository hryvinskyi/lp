<?php
/**
 * Copyright (c) 2017. Volodumur Hryvinskyi
 * @author   Volodumur Hryvinskyi <script@email.ua>
 * @package  scriptua\lp
 */

class Lp_Reviews_IndexController extends Mage_Core_Controller_Front_Action
{
    public function testAction() {
        $this->loadLayout();

        $layoutHandles = $this->getLayout()->getUpdate()->getHandles();

        echo '<pre>' . print_r($layoutHandles, true) . '</pre>';

        //$this->renderLayout();
    }


    public function indexAction() {
        $this->loadLayout()->renderLayout();
    }
}