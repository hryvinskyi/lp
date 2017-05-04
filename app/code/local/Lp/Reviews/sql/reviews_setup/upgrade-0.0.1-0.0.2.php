<?php
/**
 * Copyright (c) 2017. Volodumur Hryvinskyi
 * @author   Volodumur Hryvinskyi <script@email.ua>
 * @package  scriptua\lp
 */

/**
 * @var $this Mage_Core_Model_Resource_Setup
 */

$tableReviews = $this->getTable('lpreviews/reviews_items');

$this->startSetup();

$table = $this->getConnection()->modifyColumn($tableReviews, 'created_at', array('type' => Varien_Db_Ddl_Table::TYPE_DATETIME));
$this->endSetup();
