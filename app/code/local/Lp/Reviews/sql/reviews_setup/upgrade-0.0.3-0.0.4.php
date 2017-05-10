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

$this->getConnection()->addColumn(
    $tableReviews,
    'status',
    [
        'type' => Varien_Db_Ddl_Table::TYPE_BOOLEAN,
        'comment' => 'Status',
        'default' => 0
    ]
);

$this->endSetup();
